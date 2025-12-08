@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan</h1>
            <p class="text-gray-500 mt-1">Laporan pergerakan stok obat</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('reports.index') }}" method="GET" class="flex items-center gap-3" id="filterForm">
                
                <!-- Custom Dropdown Type -->
                <div class="relative" id="dropdown-type">
                    <input type="hidden" name="type" id="input-type" value="{{ request('type', 'all') }}">
                    <button type="button" onclick="toggleDropdown('type')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-cyan-500 hover:text-cyan-600 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 min-w-[160px] justify-between">
                        <span id="selected-type-text">
                            @if(request('type') == 'masuk') Obat Masuk
                            @elseif(request('type') == 'keluar') Obat Keluar
                            @elseif(request('type') == 'penyesuaian') Penyesuaian
                            @else Semua Jenis
                            @endif
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" id="arrow-type" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="list-type" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.1)] border border-gray-100 py-1 z-50 transform origin-top-right transition-all duration-200 scale-95 opacity-0">
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('type', 'all') == 'all' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('type', 'all', 'Semua Jenis')">
                            Semua Jenis
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('type') == 'masuk' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('type', 'masuk', 'Obat Masuk')">
                            Obat Masuk
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('type') == 'keluar' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('type', 'keluar', 'Obat Keluar')">
                            Obat Keluar
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('type') == 'penyesuaian' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('type', 'penyesuaian', 'Penyesuaian')">
                            Penyesuaian
                        </div>
                    </div>
                </div>

                <!-- Custom Dropdown Range -->
                <div class="relative" id="dropdown-range">
                    <input type="hidden" name="range" id="input-range" value="{{ request('range', 'all') }}">
                    <button type="button" onclick="toggleDropdown('range')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-cyan-500 hover:text-cyan-600 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20 min-w-[160px] justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span id="selected-range-text">
                                @if(request('range') == 'today') Hari Ini
                                @elseif(request('range') == '7_days') 7 Hari Terakhir
                                @elseif(request('range') == '30_days') 30 Hari Terakhir
                                @else Semua Periode
                                @endif
                            </span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" id="arrow-range" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="list-range" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.1)] border border-gray-100 py-1 z-50 transform origin-top-right transition-all duration-200 scale-95 opacity-0">
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('range', 'all') == 'all' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('range', 'all', 'Semua Periode')">
                            Semua Periode
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('range') == 'today' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('range', 'today', 'Hari Ini')">
                            Hari Ini
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('range') == '7_days' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('range', '7_days', '7 Hari Terakhir')">
                            7 Hari Terakhir
                        </div>
                        <div class="cursor-pointer px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-cyan-700 transition-colors {{ request('range') == '30_days' ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}" onclick="selectOption('range', '30_days', '30 Hari Terakhir')">
                            30 Hari Terakhir
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Transaksi -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalTransactions) }}</p>
            </div>
        </div>

        <!-- Total Masuk -->
        <div class="bg-green-50 p-4 rounded-xl border border-green-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-green-600">Total Masuk</p>
                <p class="text-2xl font-bold text-green-700 mt-1">{{ number_format($totalMasuk) }}</p>
            </div>
        </div>

        <!-- Total Keluar -->
        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-600">Total Keluar</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($totalKeluar) }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4">No. Batch</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-center">Kuantitas</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $activity->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">{{ $activity->batch->obat->nama_obat ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-gray-600">{{ $activity->batch->no_batches ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->jenis_aktivitas == 'masuk')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Masuk
                                    </span>
                                @elseif($activity->jenis_aktivitas == 'keluar')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Keluar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ ucfirst($activity->jenis_aktivitas) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-medium {{ $activity->jenis_aktivitas == 'masuk' ? 'text-green-600' : ($activity->jenis_aktivitas == 'keluar' ? 'text-blue-600' : 'text-orange-600') }}">
                                    {{ number_format($activity->jumlah) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $activity->keterangan }}">
                                {{ $activity->keterangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $activity->user->username ?? 'System' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-base font-medium text-gray-900">Tidak ada data laporan</p>
                                <p class="text-sm mt-1">Coba ubah filter periode atau jenis transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($activities->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $activities->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDropdown(type) {
        const list = document.getElementById(`list-${type}`);
        const arrow = document.getElementById(`arrow-${type}`);
        
        // Close other dropdowns
        ['type', 'range'].forEach(t => {
            if (t !== type) {
                const otherList = document.getElementById(`list-${t}`);
                const otherArrow = document.getElementById(`arrow-${t}`);
                if (otherList && !otherList.classList.contains('hidden')) {
                    otherList.classList.add('hidden');
                    otherList.classList.remove('scale-100', 'opacity-100');
                    otherList.classList.add('scale-95', 'opacity-0');
                    if(otherArrow) otherArrow.classList.remove('rotate-180');
                }
            }
        });

        if (list.classList.contains('hidden')) {
            // Open
            list.classList.remove('hidden');
            setTimeout(() => {
                list.classList.remove('scale-95', 'opacity-0');
                list.classList.add('scale-100', 'opacity-100');
            }, 10);
            arrow.classList.add('rotate-180');
        } else {
            // Close
            list.classList.remove('scale-100', 'opacity-100');
            list.classList.add('scale-95', 'opacity-0');
            arrow.classList.remove('rotate-180');
            setTimeout(() => {
                list.classList.add('hidden');
            }, 200);
        }
    }

    function selectOption(type, value, text) {
        document.getElementById(`input-${type}`).value = value;
        document.getElementById('filterForm').submit();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        ['type', 'range'].forEach(type => {
            const dropdown = document.getElementById(`dropdown-${type}`);
            const list = document.getElementById(`list-${type}`);
            const arrow = document.getElementById(`arrow-${type}`);
            
            if (dropdown && !dropdown.contains(event.target) && !list.classList.contains('hidden')) {
                list.classList.remove('scale-100', 'opacity-100');
                list.classList.add('scale-95', 'opacity-0');
                arrow.classList.remove('rotate-180');
                setTimeout(() => {
                    list.classList.add('hidden');
                }, 200);
            }
        });
    });
</script>
@endpush
