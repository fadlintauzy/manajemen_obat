@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-gray-500">Ringkasan stok dan peringatan obat</p>
        </div>
        <div class="flex gap-3">
            <!-- Optional actions -->
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Stok -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="relative z-10">
                <p class="text-gray-500 font-medium mb-1">Total Stok</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $total_stok }}</h3>
                <p class="text-xs text-gray-400 mt-1">unit tersedia</p>
            </div>
            <div class="absolute right-4 top-4 w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-500 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>

        <!-- Segera Expired -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="relative z-10">
                <p class="text-gray-500 font-medium mb-1">Segera Expired</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $segera_expired }}</h3>
                <p class="text-xs text-gray-400 mt-1">batch dalam 3 bulan</p>
            </div>
            <div class="absolute right-4 top-4 w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-500 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Kedaluwarsa -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="relative z-10">
                <p class="text-gray-500 font-medium mb-1">Kadaluwarsa</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $kedaluwarsa }}</h3>
                <p class="text-xs text-gray-400 mt-1">batch perlu dimusnahkan</p>
            </div>
            <div class="absolute right-4 top-4 w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="relative z-10">
                <p class="text-gray-500 font-medium mb-1">Stok Rendah</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stok_rendah }}</h3>
                <p class="text-xs text-gray-400 mt-1">item perlu restock</p>
            </div>
            <div class="absolute right-4 top-4 w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Peringatan & Activity -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Peringatan Kedaluwarsa Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Peringatan Kedaluwarsa</h3>
                    <a href="{{ route('alerts.index') }}" class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($peringatan_list->take(3) as $alert)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-red-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ $alert['status'] == 'expired' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' }} flex items-center justify-center flex-shrink-0">
                                @if($alert['status'] == 'expired')
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
                                <h4 class="font-semibold text-gray-800">{{ $alert['name'] }}</h4>
                                <p class="text-sm text-gray-500">Batch: {{ $alert['batch'] }} • Rak {{ $alert['location'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($alert['status'] == 'expired')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    Expired
                                </span>
                            @else
                                <span class="text-sm font-bold text-orange-600">
                                    {{ $alert['days_left'] }} hari
                                </span>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">{{ $alert['quantity'] }} unit</p>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center">
                        <p class="text-gray-500 text-sm">Tidak ada peringatan kedaluwarsa saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @foreach($activities as $activity)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-cyan-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ $activity['color'] }} flex items-center justify-center flex-shrink-0">
                                @if($activity['icon'] == 'arrow-down')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                @elseif($activity['icon'] == 'arrow-up')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $activity['obat'] }}</h4>
                                <p class="text-sm text-gray-500">{{ $activity['type'] }} • {{ $activity['batch'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold {{ $activity['is_positive'] ? 'text-green-500' : ($activity['type'] == 'Penyesuaian' ? 'text-orange-500' : 'text-blue-500') }}">
                                {{ $activity['is_positive'] ? '+' : ($activity['type'] == 'Penyesuaian' ? '' : '-') }}{{ number_format($activity['amount']) }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $activity['date'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Status Stok Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-fit">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Status Stok</h3>
            
            <div class="relative w-48 h-48 mx-auto flex-shrink-0">
                <canvas id="stockChart"></canvas>
                <!-- Center Text -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-800">100%</span>
                        <span class="text-xs text-gray-400">Total Stok</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 space-y-3 flex-1 overflow-y-auto">
                @php
                    $total = $chart_normal + $chart_warning + $chart_expired;
                    $pct_normal = $total > 0 ? round(($chart_normal / $total) * 100) : 0;
                    $pct_warning = $total > 0 ? round(($chart_warning / $total) * 100) : 0;
                    $pct_expired = $total > 0 ? round(($chart_expired / $total) * 100) : 0;
                @endphp
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-green-500"></span>
                        <span class="text-gray-600">Stok Normal</span>
                    </div>
                    <span class="font-medium text-gray-800">{{ $pct_normal }}%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-yellow-500"></span>
                        <span class="text-gray-600">Akan Kadaluwarsa</span>
                    </div>
                    <span class="font-medium text-gray-800">{{ $pct_warning }}%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-red-500"></span>
                        <span class="text-gray-600">Kadaluwarsa</span>
                    </div>
                    <span class="font-medium text-gray-800">{{ $pct_expired }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Stok Normal', 'Akan Kadaluwarsa', 'Kadaluwarsa'],
            datasets: [{
                data: [{{ $chart_normal }}, {{ $chart_warning }}, {{ $chart_expired }}],
                backgroundColor: [
                    '#22c55e', // green-500
                    '#eab308', // yellow-500
                    '#ef4444'  // red-500
                ],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat('id-ID').format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
