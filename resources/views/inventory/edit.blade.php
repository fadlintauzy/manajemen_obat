@extends('layouts.app')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Batch Obat</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data stok atau informasi batch</p>
        </div>
        <a href="{{ route('inventory.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto w-full">
        <div class="p-6 sm:p-8">
            <form action="{{ route('inventory.update', $batch->id_batch) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Read-only Info -->
                    <div class="bg-cyan-50 rounded-xl p-5 border border-cyan-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-cyan-800 uppercase tracking-wider mb-1">Nama Obat</label>
                                <div class="flex items-center text-cyan-900">
                                    <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <span class="text-lg font-bold">{{ $batch->obat->nama_obat }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-cyan-800 uppercase tracking-wider mb-1">No. Batch</label>
                                <div class="flex items-center text-cyan-900">
                                    <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span class="text-lg font-mono font-medium">{{ $batch->no_batches }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editable Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="col-span-1 sm:col-span-2">
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <input type="number" name="stok" id="stok" required min="0" value="{{ old('stok', $batch->stok) }}" 
                                    class="block w-full rounded-lg border-gray-300 pl-10 pr-12 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3" placeholder="0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm font-medium">Unit</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Perubahan stok akan dicatat otomatis dalam riwayat aktivitas.
                            </p>
                        </div>

                        <div>
                            <label for="tgl_kadaluarsa" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kadaluwarsa</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date" name="tgl_kadaluarsa" id="tgl_kadaluarsa" required value="{{ old('tgl_kadaluarsa', \Carbon\Carbon::parse($batch->tgl_kadaluarsa)->format('Y-m-d')) }}" 
                                    class="block w-full rounded-lg border-gray-300 pr-2 pl-12 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3">
                            </div>
                        </div>

                        <div>
                            <label for="lokasi_penyimpanan" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penyimpanan</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" required value="{{ old('lokasi_penyimpanan', $batch->lokasi_penyimpanan) }}" 
                                    class="block w-full rounded-lg border-gray-300 pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3" placeholder="Contoh: Rak A-1">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <button type="button" onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Batch
                    </button>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('inventory.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('inventory.destroy', $batch->id_batch) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    function confirmDelete() {
        if(confirm('Apakah Anda yakin ingin menghapus batch ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua riwayat terkait batch ini.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
