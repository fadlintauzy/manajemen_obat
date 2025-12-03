<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Stok (Sum of all quantities)
        $total_stok = \App\Models\Batch::sum('stok');

        // 2. Stock Categories (By Quantity)
        // Expired Stock
        $stok_expired = \App\Models\Batch::where('tgl_kadaluarsa', '<=', now())->sum('stok');
        
        // Warning Stock (Expiring in 3 months)
        $stok_warning = \App\Models\Batch::where('tgl_kadaluarsa', '>', now())
            ->where('tgl_kadaluarsa', '<=', now()->addMonths(3))
            ->sum('stok');

        // Low Stock (Not expired, not warning, but low quantity) - This is a bit tricky as it overlaps.
        // Let's define categories for the Chart specifically:
        // - Expired
        // - Warning (Expiring Soon)
        // - Normal (Everything else)
        
        $stok_normal = $total_stok - $stok_expired - $stok_warning;

        // Counts for Cards (Keep these as batch counts or switch to quantity? User said "referencing benar benar semua total stok", implying quantity)
        // Let's keep cards as "Batch Counts" for "Segera Expired" and "Kedaluwarsa" as that makes more sense for "items to action", 
        // BUT the chart should be Quantity.
        
        $count_segera_expired = \App\Models\Batch::where('tgl_kadaluarsa', '>', now())
            ->where('tgl_kadaluarsa', '<=', now()->addMonths(3))
            ->count();

        $count_kedaluwarsa = \App\Models\Batch::where('tgl_kadaluarsa', '<=', now())->count();
        
        $count_stok_rendah = \App\Models\Batch::where('stok', '<', 100)->count();

        // 5. Peringatan List (Expired or Expiring Soon)
        // Ensure unique batches. The query looks fine, but let's be explicit.
        $peringatan_list = \App\Models\Batch::with('obat')
            ->where('tgl_kadaluarsa', '<=', now()->addMonths(3))
            ->orderBy('tgl_kadaluarsa', 'asc')
            ->get()
            ->map(function ($batch) {
                $days_left = now()->diffInDays($batch->tgl_kadaluarsa, false);
                $status = 'safe';
                if ($days_left < 0) {
                    $status = 'expired';
                } elseif ($days_left <= 90) {
                    $status = 'warning';
                }

                return [
                    'id_batch' => $batch->id_batch, // Add ID for uniqueness check if needed
                    'name' => $batch->obat->nama_obat . ' ' . $batch->obat->dosis,
                    'batch' => $batch->no_batches,
                    'location' => $batch->lokasi_penyimpanan,
                    'status' => $status,
                    'days_left' => abs(intval($days_left)),
                    'quantity' => number_format($batch->stok)
                ];
            });

        // 6. Recent Activities
        $activities = \App\Models\Activity::with(['batch.obat'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($act) {
                $icon = 'arrow-down'; // Default
                $color = 'text-blue-500 bg-blue-100';
                
                if ($act->jenis_aktivitas == 'masuk') {
                    $icon = 'arrow-down';
                    $color = 'text-green-500 bg-green-100';
                } elseif ($act->jenis_aktivitas == 'keluar') {
                    $icon = 'arrow-up';
                    $color = 'text-blue-500 bg-blue-100';
                } else {
                    $icon = 'adjustments'; // Penyesuaian
                    $color = 'text-orange-500 bg-orange-100';
                }

                return [
                    'obat' => $act->batch->obat->nama_obat . ' ' . $act->batch->obat->dosis,
                    'batch' => $act->batch->no_batches,
                    'type' => ucfirst($act->jenis_aktivitas),
                    'amount' => $act->jumlah,
                    'date' => \Carbon\Carbon::parse($act->created_at)->format('d M'),
                    'icon' => $icon,
                    'color' => $color,
                    'is_positive' => $act->jenis_aktivitas == 'masuk'
                ];
            });

        $data = [
            'total_stok' => number_format($total_stok),
            'segera_expired' => $count_segera_expired,
            'kedaluwarsa' => $count_kedaluwarsa,
            'stok_rendah' => $count_stok_rendah,
            'peringatan_list' => $peringatan_list,
            'activities' => $activities,
            // Chart Data (Quantities)
            'chart_normal' => $stok_normal,
            'chart_warning' => $stok_warning,
            'chart_expired' => $stok_expired
        ];

        return view('dashboard.index', $data);
    }
}
