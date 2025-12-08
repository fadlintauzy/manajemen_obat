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
            ->whereDate('tgl_kadaluarsa', '<', now()->startOfDay())
            ->get();

        foreach ($expired as $batch) {
            $notifications[] = [
                'type' => 'expired',
                'message' => "Batch {$batch->no_batches} ({$batch->obat->nama_obat}) telah kadaluwarsa!",
                'date' => $batch->tgl_kadaluarsa,
                'color' => 'red'
            ];
        }

        // 2. Expiring Soon (Next 30 days)
        $expiringSoon = Batch::with('obat')
            ->whereDate('tgl_kadaluarsa', '>=', now()->startOfDay())
            ->whereDate('tgl_kadaluarsa', '<=', now()->addDays(30)->endOfDay())
            ->get();

        foreach ($expiringSoon as $batch) {
            $expiryDate = \Carbon\Carbon::parse($batch->tgl_kadaluarsa)->endOfDay();
            $daysLeft = (int) now()->diffInDays($expiryDate, false);
            
            $notifications[] = [
                'type' => 'warning',
                'message' => "Batch {$batch->no_batches} ({$batch->obat->nama_obat}) akan kadaluwarsa {$daysLeft} hari lagi.",
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
        $expired = Batch::whereDate('tgl_kadaluarsa', '<', now()->startOfDay())->count();
        $expiringSoon = Batch::whereDate('tgl_kadaluarsa', '>=', now()->startOfDay())
            ->whereDate('tgl_kadaluarsa', '<=', now()->addDays(30)->endOfDay())
            ->count();
        $lowStock = Batch::where('stok', '<', 100)->count();

        return $expired + $expiringSoon + $lowStock;
    }
}
