<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Batch;
use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomingMedicineController extends Controller
{
    public function create()
    {
        $medicines = Obat::orderBy('nama_obat')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        
        return view('transaction.incoming.create', compact('medicines', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obats,id_obat',
            'no_batches' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'tgl_kadaluarsa' => 'required|date|after:today',
            'tgl_penerimaan' => 'required|date',
            'lokasi_penyimpanan' => 'required|string|max:100',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create Batch
                $batch = Batch::create([
                    'id_obat' => $request->id_obat,
                    'id_supplier' => $request->id_supplier,
                    'no_batches' => $request->no_batches,
                    'stok' => $request->jumlah,
                    'tgl_penerimaan' => $request->tgl_penerimaan,
                    'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
                    'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
                ]);

                // 2. Log Activity
                Activity::create([
                    'id_batch' => $batch->id_batch,
                    'jenis_aktivitas' => 'masuk',
                    'jumlah' => $request->jumlah,
                    'sisa_stok' => $request->jumlah,
                    'keterangan' => 'Penerimaan obat baru dari supplier',
                    'user_id' => auth()->id() ?? 1
                ]);
            });

            return redirect()->route('inventory.index')->with('success', 'Obat masuk berhasil dicatat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
