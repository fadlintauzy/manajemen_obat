<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Batch::with(['obat', 'supplier']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_batches', 'like', "%{$search}%")
                  ->orWhere('lokasi_penyimpanan', 'like', "%{$search}%")
                  ->orWhereHas('obat', function($q) use ($search) {
                      $q->where('nama_obat', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Status
        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'expired') {
                $query->whereDate('tgl_kadaluarsa', '<', now()->startOfDay());
            } elseif ($status === 'warning') {
                $query->whereDate('tgl_kadaluarsa', '>=', now()->startOfDay())
                      ->whereDate('tgl_kadaluarsa', '<=', now()->addDays(30)->endOfDay());
            } elseif ($status === 'active') {
                $query->whereDate('tgl_kadaluarsa', '>', now()->addDays(30)->endOfDay());
            }
        }

        $batches = $query->orderBy('tgl_kadaluarsa', 'asc')->paginate(10);

        // Stats
        $totalBatches = Batch::count();
        $activeStock = Batch::whereDate('tgl_kadaluarsa', '>', now()->addDays(30)->endOfDay())->where('stok', '>', 0)->count();
        $warningStock = Batch::whereDate('tgl_kadaluarsa', '>=', now()->startOfDay())
                             ->whereDate('tgl_kadaluarsa', '<=', now()->addDays(30)->endOfDay())
                             ->count();
        $expiredStock = Batch::whereDate('tgl_kadaluarsa', '<', now()->startOfDay())->count();

        return view('inventory.index', compact('batches', 'totalBatches', 'activeStock', 'warningStock', 'expiredStock'));
    }
    public function edit($id)
    {
        $batch = Batch::with('obat')->findOrFail($id);
        return view('inventory.edit', compact('batch'));
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        
        $request->validate([
            'stok' => 'required|integer|min:0',
            'tgl_kadaluarsa' => 'required|date',
            'lokasi_penyimpanan' => 'required|string',
        ]);

        $oldStock = $batch->stok;
        $newStock = $request->stok;

        // Update Batch
        $batch->update([
            'stok' => $newStock,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
        ]);

        // Log Activity if stock changed
        if ($oldStock != $newStock) {
            $diff = $newStock - $oldStock;
            Activity::create([
                'id_batch' => $batch->id_batch,
                'jenis_aktivitas' => 'penyesuaian',
                'jumlah' => abs($diff),
                'sisa_stok' => $newStock,
                'keterangan' => 'Penyesuaian stok dari ' . $oldStock . ' ke ' . $newStock,
                'user_id' => auth()->id() ?? 1 // Fallback if no auth
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Data batch berhasil diperbarui');
    }

    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();

        return redirect()->route('inventory.index')->with('success', 'Batch berhasil dihapus');
    }
}
