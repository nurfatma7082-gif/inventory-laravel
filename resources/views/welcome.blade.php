<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow — Sistem Manajemen Inventaris & Penjualan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Top info bar */
        .topbar {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
        }

        /* Navbar */
        .navbar { background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }

        /* Hero background */
        .hero-section {
            background: linear-gradient(135deg, #f8f7ff 0%, #eef2ff 50%, #faf5ff 100%);
        }

        /* Dashboard card mockup */
        .mock-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(79,70,229,0.12), 0 4px 16px rgba(0,0,0,0.06);
        }

        /* Floating elements */
        @keyframes floatUp {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes floatUp2 {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50% { transform: translateY(-6px) rotate(2deg); }
        }
        .float1 { animation: floatUp 4s ease-in-out infinite; }
        .float2 { animation: floatUp2 5s ease-in-out infinite 0.8s; }
        .float3 { animation: floatUp 3.5s ease-in-out infinite 1.5s; }

        /* Pill badge */
        .pill-badge {
            background: linear-gradient(135deg, #ede9fe, #e0e7ff);
            border: 1px solid #c4b5fd;
            color: #6d28d9;
        }

        /* Feature section */
        .section-alt { background: #f9fafb; }

        /* Stat badge */
        .stat-bubble {
            background: white;
            box-shadow: 0 8px 32px rgba(79,70,229,0.15);
            border-radius: 16px;
        }

        /* Responsive hero image column */
        .hero-visual {
            position: relative;
            width: 100%;
            max-width: 480px;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-white">

    <!-- ───── Top Info Bar ───── -->
    <div class="topbar py-2 px-4 text-center text-white text-xs font-semibold">
        <i class="fa-solid fa-bolt-lightning mr-1 text-yellow-300"></i>
        UTS Web Programming 2 &bull; Integrated Laravel Project &bull; Inventory & Sales Management System
    </div>

    <!-- ───── Navbar ───── -->
    <nav class="navbar sticky top-0 z-50 w-full">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white text-sm shadow-md shadow-indigo-400/40 group-hover:shadow-indigo-400/60 transition-shadow">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div>
                    <span class="font-extrabold text-base text-slate-900 leading-none block">StockFlow</span>
                    <span class="text-[10px] font-semibold text-indigo-600 leading-none block mt-0.5">Inventory & Sales</span>
                </div>
            </a>

            <!-- Nav Links (desktop) -->
            <div class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                <a href="#fitur" class="hover:text-indigo-600 transition">Fitur Sistem</a>
                <a href="#teknologi" class="hover:text-indigo-600 transition">Teknologi</a>
                <a href="#tentang" class="hover:text-indigo-600 transition">Tentang</a>
            </div>

            <!-- CTA -->
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-500/30 transition">
                    <i class="fa-solid fa-chart-pie text-xs"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-500/30 transition">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span>Masuk Sistem</span>
                </a>
            @endauth
        </div>
    </nav>

    <!-- ───── Hero Section ───── -->
    <section class="hero-section min-h-[88vh] flex items-center overflow-hidden relative">
        <!-- Decorative circles -->
        <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-violet-200/40 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 -left-16 w-64 h-64 rounded-full bg-indigo-200/40 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16 w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

                <!-- ── TEXT SIDE ── -->
                <div class="flex-1 text-center lg:text-left order-2 lg:order-1">
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 pill-badge rounded-full px-4 py-1.5 text-xs font-bold mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></span>
                        <span>Integrated Project &bull; UTS Web Programming 2</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-extrabold text-slate-900 leading-tight tracking-tight max-w-xl mx-auto lg:mx-0">
                        Kelola Stok &amp;
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">
                            Transaksi Bisnis
                        </span>
                        <br>Dalam Satu Sistem
                    </h1>

                    <!-- Subtext -->
                    <p class="mt-5 text-slate-500 text-base leading-relaxed max-w-md mx-auto lg:mx-0">
                        Solusi manajemen inventaris dan penjualan terintegrasi. Pantau stok barang, catat pembelian dari supplier, dan kelola transaksi kasir — semua dalam satu platform berbasis Laravel 10.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center space-x-2 px-7 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Buka Aplikasi</span>
                        </a>
                        <a href="#fitur"
                           class="inline-flex items-center justify-center space-x-2 px-7 py-3.5 bg-white hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-sm shadow-sm border border-slate-200 transition">
                            <i class="fa-solid fa-circle-info text-indigo-500"></i>
                            <span>Lihat Fitur</span>
                        </a>
                    </div>

                    <!-- Stats row -->
                    <div class="mt-10 flex flex-wrap gap-5 justify-center lg:justify-start">
                        <div class="text-center lg:text-left">
                            <p class="text-2xl font-extrabold text-slate-900">19 ✓</p>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Automated Tests Passed</p>
                        </div>
                        <div class="w-px bg-slate-200 hidden sm:block"></div>
                        <div class="text-center lg:text-left">
                            <p class="text-2xl font-extrabold text-slate-900">2 Role</p>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Admin & Staff Kasir</p>
                        </div>
                        <div class="w-px bg-slate-200 hidden sm:block"></div>
                        <div class="text-center lg:text-left">
                            <p class="text-2xl font-extrabold text-slate-900">Laravel 10</p>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">MVC + MySQL</p>
                        </div>
                    </div>
                </div>

                <!-- ── VISUAL SIDE ── -->
                <div class="flex-1 flex justify-center items-center order-1 lg:order-2">
                    <div class="hero-visual float1">

                        <!-- Main dashboard mockup card -->
                        <div class="mock-card p-5 w-full max-w-sm mx-auto">
                            <!-- Header bar -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-[11px] font-semibold text-slate-400">Dashboard Ringkasan</p>
                                    <p class="text-base font-extrabold text-slate-800">StockFlow Overview</p>
                                </div>
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-sm">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                            </div>

                            <!-- Stat cards row -->
                            <div class="grid grid-cols-2 gap-2.5 mb-4">
                                <div class="bg-indigo-50 rounded-xl p-3">
                                    <p class="text-[10px] text-indigo-500 font-semibold">Total Produk</p>
                                    <p class="text-xl font-extrabold text-indigo-700">11</p>
                                </div>
                                <div class="bg-violet-50 rounded-xl p-3">
                                    <p class="text-[10px] text-violet-500 font-semibold">Kategori</p>
                                    <p class="text-xl font-extrabold text-violet-700">4</p>
                                </div>
                                <div class="bg-emerald-50 rounded-xl p-3">
                                    <p class="text-[10px] text-emerald-600 font-semibold">Penjualan</p>
                                    <p class="text-xl font-extrabold text-emerald-700">Rp 8.4 jt</p>
                                </div>
                                <div class="bg-amber-50 rounded-xl p-3">
                                    <p class="text-[10px] text-amber-600 font-semibold">Low Stock</p>
                                    <p class="text-xl font-extrabold text-amber-700">3 item</p>
                                </div>
                            </div>

                            <!-- Mini bar chart -->
                            <div class="bg-slate-50 rounded-xl p-3">
                                <p class="text-[10px] font-bold text-slate-500 mb-2">Grafik Penjualan Minggu Ini</p>
                                <div class="flex items-end gap-1.5 h-14">
                                    <div class="flex-1 bg-indigo-200 rounded-t" style="height:40%"></div>
                                    <div class="flex-1 bg-indigo-300 rounded-t" style="height:65%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t" style="height:50%"></div>
                                    <div class="flex-1 bg-indigo-500 rounded-t" style="height:80%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-t" style="height:60%"></div>
                                    <div class="flex-1 bg-violet-500 rounded-t" style="height:90%"></div>
                                    <div class="flex-1 bg-violet-600 rounded-t" style="height:100%"></div>
                                </div>
                                <div class="flex justify-between mt-1.5 text-[9px] text-slate-400 font-medium">
                                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating notification: Low Stock -->
                        <div class="stat-bubble absolute -top-4 -right-4 sm:-right-10 px-4 py-2.5 float2 z-10">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center text-amber-500 text-xs">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-800">Low Stock!</p>
                                    <p class="text-[10px] text-slate-500">3 produk perlu restok</p>
                                </div>
                            </div>
                        </div>

                        <!-- Floating notification: Sale done -->
                        <div class="stat-bubble absolute -bottom-4 -left-4 sm:-left-10 px-4 py-2.5 float3 z-10">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-500 text-xs">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-800">Transaksi OK</p>
                                    <p class="text-[10px] text-slate-500">Sale #001 · Rp 320.000</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ───── Feature Section ───── -->
    <section id="fitur" class="section-alt py-20">
        <div class="max-w-7xl mx-auto px-5 sm:px-8">
            <div class="text-center mb-12">
                <span class="inline-block pill-badge rounded-full px-4 py-1.5 text-xs font-bold mb-3">Fitur Utama</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Semua yang Bisnis Butuhkan</h2>
                <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto">Tiga modul utama yang terintegrasi dan saling terhubung secara otomatis</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 hover:shadow-md hover:border-indigo-100 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white flex items-center justify-center text-xl mb-5 transition-all duration-300">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-2">Master Data & Stok</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Manajemen produk dengan SKU unik, kategori, supplier, harga modal & jual. Sistem deteksi otomatis saat stok menipis dengan <em>Low-Stock Alert</em>.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center space-x-2 text-indigo-600 text-xs font-bold">
                        <i class="fa-solid fa-shield-halved text-xs"></i>
                        <span>Hanya Admin</span>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 hover:shadow-md hover:border-violet-100 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-violet-100 group-hover:bg-violet-600 text-violet-600 group-hover:text-white flex items-center justify-center text-xl mb-5 transition-all duration-300">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-2">Pembelian (Stock-In)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Catat pengadaan barang dari pemasok dengan nomor invoice PO. Stok fisik otomatis bertambah saat transaksi disimpan secara atomik menggunakan database transaction.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center space-x-2 text-violet-600 text-xs font-bold">
                        <i class="fa-solid fa-users text-xs"></i>
                        <span>Admin & Staff</span>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 hover:shadow-md hover:border-emerald-100 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 group-hover:bg-emerald-600 text-emerald-600 group-hover:text-white flex items-center justify-center text-xl mb-5 transition-all duration-300">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-2">Penjualan (Stock-Out)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kasir transaksi multi-item dengan harga dihitung <em>server-side</em> (anti-manipulasi). Mencegah <em>overselling</em> dengan validasi stok real-time dan lock row database.
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center space-x-2 text-emerald-600 text-xs font-bold">
                        <i class="fa-solid fa-users text-xs"></i>
                        <span>Admin & Staff</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ───── Tech Stack Section ───── -->
    <section id="teknologi" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8">
            <div class="text-center mb-10">
                <span class="inline-block pill-badge rounded-full px-4 py-1.5 text-xs font-bold mb-3">Teknologi</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Dibangun dengan Teknologi Modern</h2>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="flex items-center space-x-2.5 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3">
                    <i class="fa-brands fa-laravel text-red-500 text-xl"></i>
                    <div>
                        <p class="text-xs font-extrabold text-slate-800">Laravel 10</p>
                        <p class="text-[10px] text-slate-500">PHP Framework</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2.5 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3">
                    <i class="fa-solid fa-database text-blue-500 text-xl"></i>
                    <div>
                        <p class="text-xs font-extrabold text-slate-800">MySQL 8</p>
                        <p class="text-[10px] text-slate-500">Relational Database</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2.5 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3">
                    <i class="fa-solid fa-wind text-cyan-500 text-xl"></i>
                    <div>
                        <p class="text-xs font-extrabold text-slate-800">Tailwind CSS</p>
                        <p class="text-[10px] text-slate-500">UI Framework</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2.5 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3">
                    <i class="fa-brands fa-github text-slate-700 text-xl"></i>
                    <div>
                        <p class="text-xs font-extrabold text-slate-800">GitHub</p>
                        <p class="text-[10px] text-slate-500">Version Control</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2.5 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3">
                    <i class="fa-solid fa-flask text-violet-500 text-xl"></i>
                    <div>
                        <p class="text-xs font-extrabold text-slate-800">PHPUnit / Pest</p>
                        <p class="text-[10px] text-slate-500">19 Automated Tests</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ───── About / CTA Banner ───── -->
    <section id="tentang" class="py-16 bg-gradient-to-br from-indigo-600 to-violet-700">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 text-center text-white">
            <i class="fa-solid fa-boxes-stacked text-4xl text-indigo-300 mb-4"></i>
            <h2 class="text-3xl font-extrabold mb-3">Siap Menggunakan StockFlow?</h2>
            <p class="text-indigo-200 text-sm leading-relaxed max-w-lg mx-auto mb-8">
                Masuk menggunakan akun yang telah diberikan. Sistem mendukung dua peran pengguna: <strong class="text-white">Admin</strong> untuk pengelolaan data master, dan <strong class="text-white">Staff Kasir</strong> untuk operasional transaksi harian.
            </p>
            <a href="{{ route('login') }}"
               class="inline-flex items-center space-x-3 px-8 py-4 bg-white hover:bg-indigo-50 text-indigo-700 rounded-2xl font-extrabold text-sm shadow-xl transition transform hover:-translate-y-0.5">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Masuk ke Sistem Sekarang</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>

    <!-- ───── Footer ───── -->
    <footer class="bg-slate-900 py-8 text-center text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-5 sm:px-8">
            <div class="flex items-center justify-center space-x-2.5 mb-3">
                <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white text-xs">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span class="font-extrabold text-slate-300">StockFlow</span>
            </div>
            <p class="text-slate-600">&copy; 2026 StockFlow &bull; Tugas Ujian Tengah Semester Web Programming 2 &bull; Laravel 10 & MySQL</p>
        </div>
    </footer>

</body>
</html>
