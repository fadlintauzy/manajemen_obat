<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutgoingMedicineController extends Controller
{
    public function create()
    {
        // Get batches with stock > 0, ordered by expiration date (FEFO)
        // We also need to load the related medicine (Obat) to show the name
        $batches = Batch::with('obat')
            ->where('stok', '>', 0)
            ->orderBy('tgl_kadaluarsa', 'asc')
            ->get();

        return view('transaction.outgoing.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_batch' => 'required|exists:batches,id_batch',
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:255',
        ]);

        $batch = Batch::findOrFail($request->id_batch);

        if ($request->jumlah > $batch->stok) {
            return back()->with('error', 'Jumlah keluar melebihi stok yang tersedia (Stok: ' . $batch->stok . ')')->withInput();
        }

        try {
            DB::transaction(function () use ($request, $batch) {
                // 1. Decrease Batch Stock
                $batch->decrement('stok', $request->jumlah);

                // Check if stock is 0 and soft delete
                if ($batch->fresh()->stok <= 0) {
                    $batch->update(['is_valid' => false]);
                    $batch->delete();
                }

                // 2. Log Activity
                Activity::create([
                    'id_batch' => $batch->id_batch,
                    'jenis_aktivitas' => 'keluar',
                    'jumlah' => $request->jumlah,
                    'sisa_stok' => $batch->stok, // This will be the new stock after decrement
                    'keterangan' => 'Keluar ke: ' . $request->tujuan,
                    'user_id' => auth()->id() ?? 1
                ]);
            });

            return redirect()->route('inventory.index')->with('success', 'Obat keluar berhasil dicatat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
