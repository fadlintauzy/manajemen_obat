@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('medicines.index') }}" class="p-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Obat Baru</h2>
            <p class="text-gray-500">Isi formulir berikut untuk menambahkan data obat</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('medicines.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Nama Obat -->
            <div>
                <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat') }}" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all placeholder-gray-400"
                    placeholder="Masukkan nama obat lengkap">
                @error('nama_obat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dosis -->
                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                    <input type="text" name="dosis" id="dosis" value="{{ old('dosis') }}" required 
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all placeholder-gray-400"
                        placeholder="Contoh: 500mg">
                    @error('dosis')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}" required 
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all placeholder-gray-400"
                        placeholder="Contoh: Tablet, Botol">
                    @error('satuan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" id="category" value="{{ old('category') }}" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all placeholder-gray-400"
                    placeholder="Contoh: Antibiotik, Analgesik">
                @error('category')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-50">
                <a href="{{ route('medicines.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-cyan-600 rounded-xl hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-100 transition-all shadow-sm shadow-cyan-200">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
