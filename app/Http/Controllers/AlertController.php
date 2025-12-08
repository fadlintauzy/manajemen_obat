<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $now = now()->startOfDay();
        
        // Stats
        $expiredCount = Batch::whereDate('tgl_kadaluarsa', '<', $now)->count();
        $criticalCount = Batch::whereDate('tgl_kadaluarsa', '>=', $now)
                              ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(30))
                              ->count();
        $warningCount = Batch::whereDate('tgl_kadaluarsa', '>', $now->copy()->addDays(30))
                             ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(60))
                             ->count();
        $noticeCount = Batch::whereDate('tgl_kadaluarsa', '>', $now->copy()->addDays(60))
                            ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(90))
                            ->count();

        // Filter Logic
        $query = Batch::with(['obat', 'supplier']);
        $filter = $request->get('filter', 'all');

        if ($filter === 'expired') {
            $query->whereDate('tgl_kadaluarsa', '<', $now);
        } elseif ($filter === 'critical') {
            $query->whereDate('tgl_kadaluarsa', '>=', $now)
                  ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(30));
        } elseif ($filter === 'warning') {
            $query->whereDate('tgl_kadaluarsa', '>', $now->copy()->addDays(30))
                  ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(90)); // Combined warning for list view if needed, or stick to specific
        }

        // If 'warning' filter in UI implies both 31-60 and 61-90 or just general warning?
        // Based on image tabs: "Semua", "Expired", "Kritis", "Peringatan"
        // Let's assume "Peringatan" covers 31-90 days for the list, or maybe just 31-60?
        // The stats show 31-60 and 61-90 separately.
        // Let's make "Peringatan" cover 31-90 days for the list to be useful.
        
        if ($filter === 'warning') {
             $query->whereDate('tgl_kadaluarsa', '>', $now->copy()->addDays(30))
                   ->whereDate('tgl_kadaluarsa', '<=', $now->copy()->addDays(90));
        }

        // Default sort by expiration date ascending (worst first)
        $batches = $query->orderBy('tgl_kadaluarsa', 'asc')->paginate(10);

        return view('alerts.index', compact(
            'batches', 
            'expiredCount', 
            'criticalCount', 
            'warningCount', 
            'noticeCount',
            'filter'
        ));
    }
}
