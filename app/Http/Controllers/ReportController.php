<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['batch.obat', 'user']);

        // Filter by Type
        if ($request->has('type') && $request->type != 'all') {
            $query->where('jenis_aktivitas', $request->type);
        }

        // Filter by Date Range
        if ($request->has('range')) {
            $range = $request->range;
            $now = now();
            
            if ($range == 'today') {
                $query->whereDate('created_at', $now->today());
            } elseif ($range == '7_days') {
                $query->where('created_at', '>=', $now->subDays(7));
            } elseif ($range == '30_days') {
                $query->where('created_at', '>=', $now->subDays(30));
            }
        }

        $activities = $query->latest()->paginate(10);

        // Stats (Calculate based on current filters or overall? Usually overall or based on date range but all types)
        // Let's make stats respect date range but ignore type filter for "Total Masuk" vs "Total Keluar" context, 
        // OR just show overall stats. The design shows "Total Transaksi", "Total Masuk", "Total Keluar".
        // Let's make them respect the date range filter if present, but independent of type filter.
        
        $statsQuery = Activity::query();
        if ($request->has('range')) {
            $range = $request->range;
            $now = now();
            if ($range == 'today') {
                $statsQuery->whereDate('created_at', $now->today());
            } elseif ($range == '7_days') {
                $statsQuery->where('created_at', '>=', $now->subDays(7));
            } elseif ($range == '30_days') {
                $statsQuery->where('created_at', '>=', $now->subDays(30));
            }
        }

        $totalTransactions = $statsQuery->count();
        $totalMasuk = (clone $statsQuery)->where('jenis_aktivitas', 'masuk')->count();
        $totalKeluar = (clone $statsQuery)->where('jenis_aktivitas', 'keluar')->count();

        return view('reports.index', compact('activities', 'totalTransactions', 'totalMasuk', 'totalKeluar'));
    }
}
