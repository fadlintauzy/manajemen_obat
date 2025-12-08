@extends('layouts.app')

@section('title', 'Stok Obat')

@section('content')
<div class="space-y-6">


    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Batch -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total Batch</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($totalBatches) }}</p>
        </div>

        <!-- Stok Aktif -->
        <div class="bg-green-50 p-4 rounded-xl border border-green-100 shadow-sm">
            <p class="text-sm font-medium text-green-600">Stok Aktif</p>
            <p class="text-2xl font-bold text-green-700 mt-2">{{ number_format($activeStock) }}</p>
        </div>

        <!-- Segera Expired -->
        <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 shadow-sm">
            <p class="text-sm font-medium text-orange-600">Segera Expired</p>
            <p class="text-2xl font-bold text-orange-700 mt-2">{{ number_format($warningStock) }}</p>
        </div>

        <!-- Expired -->
        <div class="bg-red-50 p-4 rounded-xl border border-red-100 shadow-sm">
            <p class="text-sm font-medium text-red-600">Expired</p>
            <p class="text-2xl font-bold text-red-700 mt-2">{{ number_format($expiredStock) }}</p>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between">
        <div class="relative flex-1 max-w-md">
            <form action="{{ route('inventory.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat, batch, lokasi..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
        </div>
        <div class="flex gap-3">
            <div class="relative" id="filterDropdownContainer">
                <button onclick="toggleFilterDropdown()" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-cyan-500 hover:text-cyan-600 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    @if(request('status') == 'active')
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span>Stok Aktif</span>
                    @elseif(request('status') == 'warning')
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span>Segera Expired</span>
                    @elseif(request('status') == 'expired')
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span>Expired</span>
                    @else
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Semua Status</span>
                    @endif
                    <svg class="w-4 h-4 text-gray-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="filterDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.1)] border border-gray-100 py-1 z-50 transform origin-top-right transition-all duration-200">
                    <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ !request('status') ? 'bg-gray-50 font-medium text-cyan-700' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                        Semua Status
                    </a>
                    <a href="{{ route('inventory.index', ['status' => 'active']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ request('status') == 'active' ? 'bg-green-50 font-medium text-green-700' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        Aktif
                    </a>
                    <a href="{{ route('inventory.index', ['status' => 'warning']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ request('status') == 'warning' ? 'bg-orange-50 font-medium text-orange-700' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Segera Expired
                    </a>
                    <a href="{{ route('inventory.index', ['status' => 'expired']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ request('status') == 'expired' ? 'bg-red-50 font-medium text-red-700' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        Expired
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4">No. Batch</th>
                        <th class="px-6 py-4 text-center">Kuantitas</th>
                        <th class="px-6 py-4">Kedaluwarsa</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($batches as $batch)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $batch->obat->nama_obat }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $batch->supplier->nama_supplier }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-gray-600">{{ $batch->no_batches }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-medium text-gray-900">{{ number_format($batch->stok) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($batch->tgl_kadaluarsa);
                                        $isExpired = $expiryDate->isPast();
                                        // Use startOfDay for accurate calendar day difference
                                        $daysDiff = (int) now()->startOfDay()->diffInDays($expiryDate->startOfDay(), false);
                                        
                                        // Warning if not expired AND days difference is <= 30
                                        $isWarning = !$isExpired && $daysDiff <= 30;
                                        $colorClass = $isExpired ? 'text-red-600' : ($isWarning ? 'text-orange-600' : 'text-gray-900');
                                    @endphp
                                    <p class="text-sm {{ $colorClass }}">{{ $expiryDate->format('d M Y') }}</p>
                                    <p class="text-xs {{ $colorClass }} mt-0.5">
                                        @if($isExpired)
                                            {{ abs($daysDiff) }} hari yang lalu
                                        @else
                                            {{ $daysDiff }} hari lagi
                                        @endif
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">
                                    {{ $batch->lokasi_penyimpanan }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($isExpired)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Expired
                                    </span>
                                @elseif($isWarning)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        Segera Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('inventory.edit', $batch->id_batch) }}" class="text-gray-400 hover:text-cyan-600 opacity-0 group-hover:opacity-100 transition-all" title="Edit Batch">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-base font-medium text-gray-900">Tidak ada data ditemukan</p>
                                <p class="text-sm mt-1">Coba ubah kata kunci pencarian atau filter Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($batches->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $batches->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
    // Ensure functions are global
    window.toggleFilterDropdown = function() {
        const dropdown = document.getElementById('filterDropdownMenu');
        if(dropdown) dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const container = document.getElementById('filterDropdownContainer');
        const dropdown = document.getElementById('filterDropdownMenu');
        
        if (container && dropdown && !container.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endpush
