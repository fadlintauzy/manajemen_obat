@extends('layouts.app')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Obat Masuk</h1>
            <p class="text-sm text-gray-500 mt-1">Catat penerimaan obat baru ke gudang</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl w-full">
        <div class="p-6 sm:p-8">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Penerimaan Obat</h2>
                    <p class="text-sm text-gray-500">Catat obat masuk ke gudang</p>
                </div>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('transaction.incoming.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama Obat (Custom Dropdown) -->
                    <div class="relative group" id="dropdown-obat">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat <span class="text-red-500">*</span></label>
                        <input type="hidden" name="id_obat" id="input-id-obat" required value="{{ old('id_obat') }}">
                        
                        <button type="button" onclick="toggleDropdown('obat')" class="relative w-full bg-white border border-gray-300 rounded-xl shadow-sm pl-10 pr-10 py-3 text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm transition-all duration-200 hover:border-cyan-400">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <span class="block truncate text-gray-500" id="selected-obat-text">Pilih obat</span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" id="arrow-obat" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <div id="list-obat" class="hidden absolute z-20 mt-2 w-full bg-white shadow-xl max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-hidden focus:outline-none sm:text-sm transform transition-all duration-200 origin-top scale-95 opacity-0">
                            <!-- Search Input -->
                            
                            <div class="overflow-y-auto max-h-48" id="options-obat">
                                @foreach($medicines as $medicine)
                                    <div class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-cyan-50 text-gray-700 hover:text-cyan-700 transition-colors duration-150 group option-item" onclick="selectOption('obat', '{{ $medicine->id_obat }}', '{{ $medicine->nama_obat }}')" data-text="{{ strtolower($medicine->nama_obat) }}">
                                        <div class="flex items-center">
                                            <span class="block truncate font-medium group-hover:font-semibold">
                                                {{ $medicine->nama_obat }}
                                            </span>
                                        </div>
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-cyan-600 hidden check-icon">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                @endforeach
                                <div id="no-results-obat" class="hidden px-4 py-3 text-sm text-gray-500 text-center">
                                    Tidak ada obat ditemukan
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Batch -->
                    <div>
                        <label for="no_batches" class="block text-sm font-medium text-gray-700 mb-1">Nomor Batch <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <input type="text" name="no_batches" id="no_batches" required value="{{ old('no_batches') }}" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3" placeholder="Contoh: PCT-2024-003">
                        </div>
                    </div>

                    <!-- Kuantitas -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <input type="number" name="jumlah" id="jumlah" required min="1" value="{{ old('jumlah') }}" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm pr-2 pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3" placeholder="Jumlah unit">
                        </div>
                    </div>

                    <!-- Supplier (Custom Dropdown) -->
                    <div class="relative group" id="dropdown-supplier">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                        <input type="hidden" name="id_supplier" id="input-id-supplier" required value="{{ old('id_supplier') }}">
                        
                        <button type="button" onclick="toggleDropdown('supplier')" class="relative w-full bg-white border border-gray-300 rounded-xl shadow-sm pl-10 pr-10 py-3 text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm transition-all duration-200 hover:border-cyan-400">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="block truncate text-gray-500" id="selected-supplier-text">Pilih supplier</span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" id="arrow-supplier" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <div id="list-supplier" class="hidden absolute z-20 mt-2 w-full bg-white shadow-xl max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-hidden focus:outline-none sm:text-sm transform transition-all duration-200 origin-top scale-95 opacity-0">
                            <!-- Search Input -->
                            
                            <div class="overflow-y-auto max-h-48" id="options-supplier">
                                @foreach($suppliers as $supplier)
                                    <div class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-cyan-50 text-gray-700 hover:text-cyan-700 transition-colors duration-150 group option-item" onclick="selectOption('supplier', '{{ $supplier->id_supplier }}', '{{ $supplier->nama_supplier }}')" data-text="{{ strtolower($supplier->nama_supplier) }}">
                                        <div class="flex items-center">
                                            <span class="block truncate font-medium group-hover:font-semibold">
                                                {{ $supplier->nama_supplier }}
                                            </span>
                                        </div>
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-cyan-600 hidden check-icon">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                @endforeach
                                <div id="no-results-supplier" class="hidden px-4 py-3 text-sm text-gray-500 text-center">
                                    Tidak ada supplier ditemukan
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Kadaluwarsa -->
                    <div>
                        <label for="tgl_kadaluarsa" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kadaluwarsa <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" name="tgl_kadaluarsa" id="tgl_kadaluarsa" required value="{{ old('tgl_kadaluarsa') }}" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm pr-2 pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3">
                        </div>
                    </div>

                    <!-- Tanggal Penerimaan -->
                    <div>
                        <label for="tgl_penerimaan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penerimaan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="date" name="tgl_penerimaan" id="tgl_penerimaan" required value="{{ old('tgl_penerimaan', date('Y-m-d')) }}" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm pr-2 pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3">
                        </div>
                    </div>

                    <!-- Lokasi Penyimpanan -->
                    <div class="md:col-span-2">
                        <label for="lokasi_penyimpanan" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" required value="{{ old('lokasi_penyimpanan') }}" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm pl-10 focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-3" placeholder="Contoh: Rak A-01">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    
                    <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDropdown(type) {
        const list = document.getElementById(`list-${type}`);
        const arrow = document.getElementById(`arrow-${type}`);
        const searchInput = document.getElementById(`search-${type}`);
        
        if (list.classList.contains('hidden')) {
            // Open
            list.classList.remove('hidden');
            setTimeout(() => {
                list.classList.remove('scale-95', 'opacity-0');
                list.classList.add('scale-100', 'opacity-100');
            }, 10);
            arrow.classList.add('rotate-180');
            searchInput.focus();
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
        document.getElementById(`input-id-${type}`).value = value;
        const textElement = document.getElementById(`selected-${type}-text`);
        textElement.textContent = text;
        textElement.classList.remove('text-gray-500');
        textElement.classList.add('text-gray-900');
        
        // Update check icons
        const options = document.querySelectorAll(`#options-${type} .option-item`);
        options.forEach(opt => {
            const checkIcon = opt.querySelector('.check-icon');
            const optText = opt.querySelector('span').innerText;
            if (optText === text) {
                checkIcon.classList.remove('hidden');
                opt.classList.add('bg-cyan-50', 'text-cyan-700');
            } else {
                checkIcon.classList.add('hidden');
                opt.classList.remove('bg-cyan-50', 'text-cyan-700');
            }
        });

        toggleDropdown(type);
    }

    function filterDropdown(type) {
        const input = document.getElementById(`search-${type}`);
        const filter = input.value.toLowerCase();
        const options = document.querySelectorAll(`#options-${type} .option-item`);
        let hasResults = false;

        options.forEach(option => {
            const text = option.getAttribute('data-text');
            if (text.includes(filter)) {
                option.style.display = "";
                hasResults = true;
            } else {
                option.style.display = "none";
            }
        });

        const noResults = document.getElementById(`no-results-${type}`);
        if (hasResults) {
            noResults.classList.add('hidden');
        } else {
            noResults.classList.remove('hidden');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = ['obat', 'supplier'];
        dropdowns.forEach(type => {
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
@endsection
