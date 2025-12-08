@extends('layouts.app')

@section('title', 'Peringatan Kedaluwarsa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Peringatan Kedaluwarsa</h1>
        <p class="text-gray-500 mt-1">Monitor obat yang akan atau sudah kedaluwarsa</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Expired -->
        <div class="bg-red-50 p-4 rounded-xl border border-red-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 border border-red-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-red-600">Kedaluwarsa</p>
                <p class="text-2xl font-bold text-red-700">{{ number_format($expiredCount) }}</p>
            </div>
        </div>

        <!-- <= 30 Hari -->
        <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 border border-orange-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-orange-600">≤ 30 Hari</p>
                <p class="text-2xl font-bold text-orange-700">{{ number_format($criticalCount) }}</p>
            </div>
        </div>

        <!-- 31-60 Hari -->
        <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 border border-yellow-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-yellow-600">31-60 Hari</p>
                <p class="text-2xl font-bold text-yellow-700">{{ number_format($warningCount) }}</p>
            </div>
        </div>

        <!-- 61-90 Hari -->
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 border border-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">61-90 Hari</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($noticeCount) }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('alerts.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'all' ? 'bg-white shadow-sm text-gray-900 border border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
            Semua ({{ $expiredCount + $criticalCount + $warningCount + $noticeCount }})
        </a>
        <a href="{{ route('alerts.index', ['filter' => 'expired']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'expired' ? 'bg-red-50 text-red-700 border border-red-100 shadow-sm' : 'text-gray-500 hover:text-red-600 hover:bg-red-50' }}">
            Expired ({{ $expiredCount }})
        </a>
        <a href="{{ route('alerts.index', ['filter' => 'critical']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'critical' ? 'bg-orange-50 text-orange-700 border border-orange-100 shadow-sm' : 'text-gray-500 hover:text-orange-600 hover:bg-orange-50' }}">
            Kritis ({{ $criticalCount }})
        </a>
        <a href="{{ route('alerts.index', ['filter' => 'warning']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'warning' ? 'bg-yellow-50 text-yellow-700 border border-yellow-100 shadow-sm' : 'text-gray-500 hover:text-yellow-600 hover:bg-yellow-50' }}">
            Peringatan ({{ $warningCount + $noticeCount }})
        </a>
    </div>

    <!-- List -->
    <div class="space-y-4">
        @forelse($batches as $batch)
            @php
                $expiryDate = \Carbon\Carbon::parse($batch->tgl_kadaluarsa);
                $isExpired = $expiryDate->isPast();
                $daysDiff = (int) now()->startOfDay()->diffInDays($expiryDate->startOfDay(), false);
                
                // Determine status and styles
                if ($isExpired) {
                    $status = 'Expired';
                    $bgClass = 'bg-red-50 border-red-100';
                    $iconBg = 'bg-red-100 text-red-600';
                    $badgeClass = 'bg-red-600 text-white';
                    $daysTextClass = 'text-red-600';
                } elseif ($daysDiff <= 30) {
                    $status = 'Kritis';
                    $bgClass = 'bg-orange-50 border-orange-100';
                    $iconBg = 'bg-orange-100 text-orange-600';
                    $badgeClass = 'bg-orange-600 text-white';
                    $daysTextClass = 'text-orange-600';
                } elseif ($daysDiff <= 60) {
                    $status = 'Peringatan';
                    $bgClass = 'bg-yellow-50 border-yellow-100';
                    $iconBg = 'bg-yellow-100 text-yellow-600';
                    $badgeClass = 'bg-yellow-500 text-white';
                    $daysTextClass = 'text-yellow-600';
                } else {
                    $status = 'Info';
                    $bgClass = 'bg-white border-gray-200';
                    $iconBg = 'bg-gray-100 text-gray-600';
                    $badgeClass = 'bg-gray-500 text-white';
                    $daysTextClass = 'text-gray-600';
                }
            @endphp

            <div class="p-4 rounded-xl border {{ $bgClass }} flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:shadow-md">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center flex-shrink-0 mt-1 sm:mt-0">
                        @if($isExpired)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $batch->obat->nama_obat }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Batch: <span class="font-mono">{{ $batch->no_batches }}</span> • Rak {{ $batch->lokasi_penyimpanan }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4 pl-14 sm:pl-0">
                    <div class="text-right">
                        @if($isExpired)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $badgeClass }}">
                                Expired
                            </span>
                        @else
                            <span class="text-sm font-bold {{ $daysTextClass }}">
                                {{ $daysDiff }} hari
                            </span>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($batch->stok) }} unit</p>
                    </div>
                    <a href="{{ route('inventory.edit', $batch->id_batch) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        Lihat
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 font-medium">Tidak ada data peringatan untuk filter ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($batches->hasPages())
        <div class="mt-6">
            {{ $batches->appends(['filter' => $filter])->links() }}
        </div>
    @endif
</div>
@endsection
