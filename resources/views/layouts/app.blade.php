<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PharmStock - Manajemen Obat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen relative">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-20 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-[#0f172a] text-white flex flex-col fixed h-full z-30 transition-transform duration-300 transform -translate-x-full lg:translate-x-0">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-700 justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cyan-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">PharmStock</h1>
                        <p class="text-xs text-gray-400">Manajemen Obat</p>
                    </div>
                </div>
                <!-- Close Button (Mobile Only) -->
                <button class="lg:hidden text-gray-400 hover:text-white" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('inventory.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('inventory.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="font-medium">Stok Obat</span>
                </a>

                <a href="{{ route('transaction.incoming.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('transaction.incoming.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('transaction.incoming.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">Obat Masuk</span>
                </a>

                <a href="{{ route('transaction.outgoing.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('transaction.outgoing.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('transaction.outgoing.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <span class="font-medium">Obat Keluar</span>
                </a>

                <a href="{{ route('alerts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('alerts.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('alerts.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="font-medium">Peringatan</span>
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('reports.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium">Laporan</span>
                </a>

                <a href="{{ route('medicines.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('medicines.*') ? 'bg-cyan-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('medicines.*') ? 'text-white' : 'group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="font-medium">Master Obat</span>
                </a>
            </nav>


        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-40">
                <div class="flex items-center gap-4 flex-1">
                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg" onclick="toggleSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h2 class="text-xl font-bold text-gray-800 hidden sm:block">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3 lg:gap-6 ml-4">
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(isset($notificationCount) && $notificationCount > 0)
                                <span class="absolute top-1 right-1 h-4 w-4 bg-red-500 rounded-full text-[10px] font-bold text-white flex items-center justify-center border-2 border-white">{{ $notificationCount }}</span>
                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50 overflow-hidden ring-1 ring-black ring-opacity-5">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                                <span class="text-xs text-gray-500">{{ $notificationCount ?? 0 }} Baru</span>
                            </div>
                            <div class="max-h-96 overflow-y-auto bg-white">
                                @if(isset($notifications) && count($notifications) > 0)
                                    @foreach($notifications as $notif)
                                        <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition-colors bg-white">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 mt-1.5">
                                                    @if($notif['type'] == 'expired')
                                                        <div class="w-2.5 h-2.5 rounded-full bg-red-500 ring-2 ring-red-100"></div>
                                                    @elseif($notif['type'] == 'warning')
                                                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-500 ring-2 ring-yellow-100"></div>
                                                    @else
                                                        <div class="w-2.5 h-2.5 rounded-full bg-orange-500 ring-2 ring-orange-100"></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-700 font-medium leading-snug">{{ $notif['message'] }}</p>
                                                    @php
                                                        $notifDate = \Carbon\Carbon::parse($notif['date']);
                                                        $isExpired = $notif['type'] == 'expired';
                                                        $isLowStock = $notif['type'] == 'low_stock';
                                                        
                                                        // For expired, compare start of days to get full calendar days
                                                        if ($isExpired) {
                                                            $daysDiff = (int) now()->startOfDay()->diffInDays($notifDate->startOfDay(), false);
                                                        } else {
                                                            // For warning, keep existing logic (end of day vs now) or align to calendar days?
                                                            // Let's align to calendar days for consistency "X hari lagi"
                                                            $daysDiff = (int) now()->startOfDay()->diffInDays($notifDate->startOfDay(), false);
                                                        }
                                                    @endphp
                                                    @if(!$isLowStock)
                                                        <p class="text-[10px] text-gray-400 mt-1">
                                                            @if($isExpired)
                                                                {{ abs($daysDiff) }} hari yang lalu
                                                            @else
                                                                {{ $daysDiff }} hari lagi
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-4 py-8 text-center bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <p class="text-xs text-gray-400">Tidak ada notifikasi baru</p>
                                    </div>
                                @endif
                            </div>
                            <!-- See All Link -->
                            <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-center">
                                <a href="#" class="text-xs text-cyan-600 hover:text-cyan-700 font-medium">Lihat Semua Peringatan</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pl-3 lg:pl-6 border-l border-gray-200">
                        <div class="w-9 h-9 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ substr(auth()->user()->username ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-sm hidden md:block">
                            <p class="font-semibold text-gray-700">{{ auth()->user()->username ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">Admin Gudang</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="ml-2 text-gray-400 hover:text-red-500" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-8 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // Close sidebar
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notificationDropdown');
            const button = dropdown.previousElementSibling; // The button is right before the dropdown div
            
            if (!dropdown.classList.contains('hidden')) {
                if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>
