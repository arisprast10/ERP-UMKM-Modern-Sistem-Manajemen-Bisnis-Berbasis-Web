<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $storeSetting->store_name ?? config('app.name', 'ERP UMKM') }} - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full antialiased font-sans bg-gray-50 text-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden print:h-auto print:overflow-visible">
        
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-indigo-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 print:hidden">
            
            <!-- Logo & Nama Toko -->
            <div class="flex items-center justify-center mt-6 mb-2 px-4">
                @if($storeSetting->store_logo)
                    <img src="{{ asset('storage/' . $storeSetting->store_logo) }}" class="h-10 w-10 rounded-full object-cover mr-2" alt="Logo">
                @else
                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center mr-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                @endif
                <span class="text-white text-lg font-bold truncate">{{ $storeSetting->store_name ?? 'ERP UMKM' }}</span>
            </div>
            <div class="border-t border-indigo-700 mx-4 mb-4"></div>

            <nav class="px-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                @if(auth()->user()->role->slug === 'admin' || auth()->user()->role->slug === 'kasir')
                <a href="{{ route('pos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('pos.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    POS / Kasir
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('customers.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pelanggan
                </a>
                @endif

                @if(auth()->user()->role->slug === 'admin' || auth()->user()->role->slug === 'gudang')
                <div class="pt-2">
                    <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Inventori</p>
                    <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('products.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Produk
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('categories.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Kategori Produk
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('suppliers.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        Supplier
                    </a>
                    <a href="{{ route('stock.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('stock.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Gudang & Stok
                    </a>
                </div>
                @endif

                @if(auth()->user()->role->slug === 'admin')
                <div class="pt-2">
                    <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Transaksi</p>
                    <a href="{{ route('transactions.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('transactions.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Riwayat Transaksi
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('reports.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Laporan Penjualan
                    </a>
                </div>
                <div class="pt-2">
                    <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Keuangan</p>
                    <a href="{{ route('expenses.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('expenses.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                        Pengeluaran
                    </a>
                    <a href="{{ route('expense_categories.index') }}" class="flex items-center px-3 py-2 text-sm font-medium pl-10 rounded-md {{ request()->routeIs('expense_categories.*') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-800' }}">
                        Kategori Pengeluaran
                    </a>
                </div>
                <div class="pt-2">
                    <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Administrasi</p>
                    <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manajemen Pengguna
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan Toko
                    </a>
                </div>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="flex items-center justify-between px-6 py-3 bg-white border-b shadow-sm print:hidden">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden mr-3">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <span class="text-gray-600 font-medium text-sm hidden md:block">@yield('title')</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500 hidden md:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                            <img class="object-cover w-9 h-9 rounded-full border-2 border-indigo-500" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4f46e5&color=fff" 
                                 alt="Avatar">
                            <span class="text-sm font-medium text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" 
                             class="absolute right-0 z-10 w-52 mt-2 bg-white rounded-lg shadow-lg border border-gray-100 py-1" x-cloak>
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-indigo-500">{{ auth()->user()->role->name ?? '-' }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            @if(auth()->user()->role->slug === 'admin')
                            <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pengaturan Toko
                            </a>
                            @endif
                            <div class="border-t mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main section -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 print:overflow-visible print:p-0 print:bg-white">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to format number
            function formatMoney(input) {
                let val = input.value.replace(/[^0-9]/g, '');
                if (val !== '') {
                    input.value = parseInt(val, 10).toLocaleString('id-ID');
                } else {
                    input.value = '';
                }
            }

            // Format on load
            document.querySelectorAll('.money-input').forEach(input => {
                formatMoney(input);
            });

            // Format on input
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('money-input')) {
                    formatMoney(e.target);
                }
            });

            // Clean before submit
            document.addEventListener('submit', function(e) {
                let moneyInputs = e.target.querySelectorAll('.money-input');
                moneyInputs.forEach(input => {
                    input.value = input.value.replace(/\./g, '');
                });
            });
        });
    </script>
</body>
</html>