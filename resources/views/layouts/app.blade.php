<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen Inventaris & Penjualan') | InventoryApp</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <div class="md:hidden bg-slate-900 text-white px-4 py-3 flex items-center justify-between shadow">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <span class="font-bold text-lg tracking-tight">StockFlow</span>
        </div>
        <button id="mobileMenuBtn" class="text-slate-300 hover:text-white p-2">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-64 bg-slate-900 text-slate-300 min-h-screen shrink-0 transition-all duration-300">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-slate-800 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center font-bold text-white shadow-lg">
                <i class="fa-solid fa-boxes-stacked text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-white text-lg tracking-tight leading-tight">StockFlow</h1>
                <p class="text-xs text-slate-400">Inventory & Sales</p>
            </div>
        </div>

        <!-- User Profile Card in Sidebar -->
        <div class="p-4 mx-4 my-3 bg-slate-800/60 rounded-xl border border-slate-700/50 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-indigo-400 font-bold text-base shadow">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                <div class="flex items-center space-x-1 mt-0.5">
                    @if(Auth::user()->isAdmin())
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                            <i class="fa-solid fa-shield-halved text-[10px] mr-1"></i> Admin
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <i class="fa-solid fa-user-tag text-[10px] mr-1"></i> Staff
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Links -->
        <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto text-sm">
            <div class="px-3 pt-2 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">Navigasi Utama</div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-6 text-center text-base mr-2 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                Dashboard
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-box-archive w-6 text-center text-base mr-2 {{ request()->routeIs('products.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Katalog Produk
            </a>

            <div class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi & Stok</div>

            <a href="{{ route('purchases.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('purchases.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-truck-ramp-box w-6 text-center text-base mr-2 {{ request()->routeIs('purchases.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Pembelian (Stock-In)
            </a>

            <a href="{{ route('sales.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('sales.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-cash-register w-6 text-center text-base mr-2 {{ request()->routeIs('sales.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Penjualan (Stock-Out)
            </a>

            @if(Auth::user()->isAdmin())
                <div class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data (Admin)</div>

                <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-tags w-6 text-center text-base mr-2 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    Kategori Produk
                </a>

                <a href="{{ route('suppliers.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('suppliers.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-warehouse w-6 text-center text-base mr-2 {{ request()->routeIs('suppliers.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    Pemasok (Suppliers)
                </a>

                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white font-medium shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-6 text-center text-base mr-2 {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    Kelola Pengguna
                </a>
            @endif
        </nav>

        <!-- Logout Bottom Button -->
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white rounded-lg transition-colors text-sm font-medium border border-red-500/20">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-xs">
            <div class="flex items-center space-x-3">
                <h2 class="text-xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                <span class="hidden md:inline-block text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                    UTS Web Programming 2
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <span class="text-xs text-slate-500 block">{{ now()->translatedFormat('l, d F Y') }}</span>
                    <span class="text-xs font-semibold text-indigo-600">Terautentikasi: {{ Auth::user()->email }}</span>
                </div>
            </div>
        </header>

        <!-- Notification Alerts -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mt-0.5 shrink-0"></i>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl mt-0.5 shrink-0"></i>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-xs">
                    <div class="flex items-center space-x-2 text-amber-800 font-semibold mb-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                        <span>Mohon periksa kembali input Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 text-amber-800/90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500">
            &copy; 2026 Integrated Laravel Project — Inventory & Sales Management System (Web Programming 2)
        </footer>
    </div>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
