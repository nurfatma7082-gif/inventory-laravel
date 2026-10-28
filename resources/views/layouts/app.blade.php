<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen Inventaris') ✨ StokFlow</title>
    
    <!-- Google Fonts: Plus Jakarta Sans (Super Clean & Aesthetic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        pastel: {
                            pink: '#ffd1dc',
                            rose: '#ffe4e6',
                            lavender: '#ede9fe',
                            mint: '#d1fae5',
                            peach: '#ffedd5',
                            cream: '#fdfbf7',
                        },
                        cute: {
                            primary: '#ec4899',     // Pink-500
                            primaryDark: '#db2777', // Pink-600
                            secondary: '#8b5cf6',   // Violet-500
                            accent: '#f43f5e',      // Rose-500
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fdf8f6 0%, #f7f3fd 50%, #f3f7fd 100%);
            min-height: 100vh;
        }
        /* Custom Cute Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #fdf2f8;
        }
        ::-webkit-scrollbar-thumb {
            background: #f472b6;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ec4899;
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col md:flex-row min-h-screen">

    <!-- Mobile Top Navigation -->
    <div class="md:hidden bg-white/90 backdrop-blur-md px-5 py-3.5 flex items-center justify-between border-b border-pink-100 shadow-sm sticky top-0 z-30">
        <div class="flex items-center space-x-2.5">
            <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-pink-500 to-violet-500 flex items-center justify-center text-white shadow-md shadow-pink-500/25">
                <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
            </div>
            <div>
                <span class="font-extrabold text-base bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">StockFlow ✨</span>
                <span class="text-[10px] text-pink-400 block -mt-1 font-semibold">Inventory & Sales</span>
            </div>
        </div>
        <button id="mobileMenuBtn" class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-100 transition">
            <i class="fa-solid fa-bars text-sm"></i>
        </button>
    </div>

    <!-- Sidebar Navigation (Aesthetic Pastel & Modern) -->
    <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-64 bg-white/80 backdrop-blur-xl border-r border-pink-100 min-h-screen shrink-0 transition-all duration-300 shadow-sm">
        
        <!-- Brand Header -->
        <div class="px-6 py-5 border-b border-pink-100/70 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-pink-500 via-rose-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-pink-500/30 transform hover:scale-105 transition">
                <i class="fa-solid fa-cubes-stacked text-base"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent leading-none">
                    StockFlow ✨
                </h1>
                <p class="text-[11px] font-semibold text-pink-400 mt-1 flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                    Sistem Kasir & Stok
                </p>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="m-4 p-3.5 bg-gradient-to-r from-pink-50/80 via-purple-50/80 to-indigo-50/80 rounded-2xl border border-pink-200/50 flex items-center space-x-3 shadow-xs">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-pink-400 to-rose-400 flex items-center justify-center text-white font-extrabold text-base shadow-sm ring-2 ring-white">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                <div class="mt-0.5">
                    @if(Auth::user()->isAdmin())
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">
                            👑 Admin / Owner
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-pink-100 text-pink-700 border border-pink-200">
                            🎀 Staff Kasir
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto text-sm">
            <div class="px-3 pt-2 pb-1 text-[11px] font-bold text-pink-400/90 uppercase tracking-wider flex items-center space-x-1.5">
                <span>Menu Utama</span>
            </div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md shadow-pink-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-pink-50/80 hover:text-pink-600' }}">
                <span class="w-7 text-center mr-2">
                    <i class="fa-solid fa-compass text-base {{ request()->routeIs('dashboard') ? 'text-white' : 'text-pink-400' }}"></i>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md shadow-pink-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-pink-50/80 hover:text-pink-600' }}">
                <span class="w-7 text-center mr-2">
                    <i class="fa-solid fa-bag-shopping text-base {{ request()->routeIs('products.*') ? 'text-white' : 'text-pink-400' }}"></i>
                </span>
                <span>Katalog Produk</span>
            </a>

            <div class="px-3 pt-4 pb-1 text-[11px] font-bold text-pink-400/90 uppercase tracking-wider">Transaksi & Stok</div>

            <a href="{{ route('purchases.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('purchases.*') ? 'bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-md shadow-purple-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-purple-50/80 hover:text-purple-600' }}">
                <span class="w-7 text-center mr-2">
                    <i class="fa-solid fa-truck-ramp-box text-base {{ request()->routeIs('purchases.*') ? 'text-white' : 'text-purple-400' }}"></i>
                </span>
                <span>Pembelian (Stock-In)</span>
            </a>

            <a href="{{ route('sales.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('sales.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-emerald-50/80 hover:text-emerald-600' }}">
                <span class="w-7 text-center mr-2">
                    <i class="fa-solid fa-cash-register text-base {{ request()->routeIs('sales.*') ? 'text-white' : 'text-emerald-500' }}"></i>
                </span>
                <span>Penjualan (Stock-Out)</span>
            </a>

            @if(Auth::user()->isAdmin())
                <div class="px-3 pt-4 pb-1 text-[11px] font-bold text-pink-400/90 uppercase tracking-wider">Master Data (Admin)</div>

                <a href="{{ route('categories.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md shadow-pink-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-pink-50/80 hover:text-pink-600' }}">
                    <span class="w-7 text-center mr-2">
                        <i class="fa-solid fa-shapes text-base {{ request()->routeIs('categories.*') ? 'text-white' : 'text-pink-400' }}"></i>
                    </span>
                    <span>Kategori Produk</span>
                </a>

                <a href="{{ route('suppliers.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('suppliers.*') ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md shadow-pink-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-pink-50/80 hover:text-pink-600' }}">
                    <span class="w-7 text-center mr-2">
                        <i class="fa-solid fa-store text-base {{ request()->routeIs('suppliers.*') ? 'text-white' : 'text-pink-400' }}"></i>
                    </span>
                    <span>Pemasok (Suppliers)</span>
                </a>

                <a href="{{ route('users.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl font-semibold transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-md shadow-purple-500/25 scale-[1.02]' : 'text-slate-600 hover:bg-purple-50/80 hover:text-purple-600' }}">
                    <span class="w-7 text-center mr-2">
                        <i class="fa-solid fa-users text-base {{ request()->routeIs('users.*') ? 'text-white' : 'text-purple-400' }}"></i>
                    </span>
                    <span>Kelola Pengguna</span>
                </a>
            @endif
        </nav>

        <!-- Cute Logout Button -->
        <div class="p-4 border-t border-pink-100/70">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white rounded-2xl transition-all duration-200 text-xs font-bold border border-rose-200/60 shadow-xs group">
                    <i class="fa-solid fa-door-open group-hover:rotate-12 transition"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="bg-white/80 backdrop-blur-md border-b border-pink-100 px-6 py-4 flex items-center justify-between sticky top-0 z-20 shadow-xs">
            <div class="flex items-center space-x-3">
                <div class="w-2.5 h-7 rounded-full bg-gradient-to-b from-pink-500 to-purple-500"></div>
                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">@yield('page-title', 'Dashboard')</h2>
                <span class="hidden lg:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-pink-50 text-pink-600 border border-pink-200">
                    🌸 UTS Web Programming 2
                </span>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <span class="text-xs font-bold text-slate-700 block flex items-center justify-end space-x-1">
                        <i class="fa-regular fa-clock text-pink-400"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </span>
                    <span class="text-[11px] font-semibold text-purple-600">
                        {{ Auth::user()->email }} ({{ ucfirst(Auth::user()->role) }})
                    </span>
                </div>
            </div>
        </header>

        <!-- Flash Messages & Main Body -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50/90 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm backdrop-blur-sm animate-fade-in">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-sm"></i>
                    </span>
                    <div class="flex-1 text-sm font-semibold pt-1">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm backdrop-blur-sm animate-fade-in">
                    <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    </span>
                    <div class="flex-1 text-sm font-semibold pt-1">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-amber-50/90 border border-amber-200 text-amber-900 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center space-x-2 text-amber-800 font-bold mb-2">
                        <i class="fa-solid fa-circle-exclamation text-amber-600"></i>
                        <span>Periksa kembali input data Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-800 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Aesthetic Footer -->
        <footer class="py-4 px-6 text-center text-xs font-medium text-pink-400 border-t border-pink-100/70 bg-white/50 backdrop-blur-sm">
            Dibuat dengan 💖 untuk Ujian Tengah Semester &bull; <strong>Integrated Laravel Project (Inventory & Sales)</strong>
        </footer>
    </div>

    <!-- Mobile Drawer Script -->
    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
