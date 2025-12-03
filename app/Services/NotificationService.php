<?php

namespace App\Services;

use App\Models\Batch;
use Carbon\Carbon;

class NotificationService
{
    public function getNotifications()
    {
        $notifications = [];

        // 1. Expired Batches
        $expired = Batch::with('obat')
            ->where('tgl_kadaluarsa', '<=', now())
            ->get();

        foreach ($expired as $batch) {
            $notifications[] = [
                'type' => 'expired',
                'message' => "Batch {$batch->no_batches} ({$batch->obat->nama_obat}) telah kadaluwarsa!",
                'date' => $batch->tgl_kadaluarsa,
                'color' => 'red'
            ];
        }

        // 2. Expiring Soon (Next 3 months)
        $expiringSoon = Batch::with('obat')
            ->where('tgl_kadaluarsa', '>', now())
            ->where('tgl_kadaluarsa', '<=', now()->addMonths(3))
            ->get();

        foreach ($expiringSoon as $batch) {
            $daysLeft = now()->diffInDays($batch->tgl_kadaluarsa);
            $notifications[] = [
                'type' => 'warning',
                'message' => "Batch {$batch->no_batches} ({$batch->obat->nama_obat}) akan kadaluwarsa dalam {$daysLeft} hari.",
                'date' => $batch->tgl_kadaluarsa,
                'color' => 'yellow'
            ];
        }

        // 3. Low Stock (< 100)
        $lowStock = Batch::with('obat')
            ->where('stok', '<', 100)
            ->get();

        foreach ($lowStock as $batch) {
            $notifications[] = [
                'type' => 'low_stock',
                'message' => "Stok Batch {$batch->no_batches} ({$batch->obat->nama_obat}) menipis ({$batch->stok} unit).",
                'date' => now(), // Priority
                'color' => 'orange'
            ];
        }

        // Sort by date/priority if needed, for now just return list
        return collect($notifications)->take(10); // Limit to 10 for UI
    }

    public function getCount()
    {
        $expired = Batch::where('tgl_kadaluarsa', '<=', now())->count();
        $expiringSoon = Batch::where('tgl_kadaluarsa', '>', now())
            ->where('tgl_kadaluarsa', '<=', now()->addMonths(3))
            ->count();
        $lowStock = Batch::where('stok', '<', 100)->count();

        return $expired + $expiringSoon + $lowStock;
    }
}
