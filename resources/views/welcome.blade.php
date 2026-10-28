<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow — Sistem Manajemen Inventaris & Penjualan Terintegrasi</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
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
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-pattern {
            background-color: #fafbfd;
            background-image: radial-gradient(#e0e7ff 0.8px, transparent 0.8px), radial-gradient(#f1f5f9 0.8px, #fafbfd 0.8px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }
    </style>
</head>
<body class="hero-pattern text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white text-xs py-2.5 px-4 text-center font-medium border-b border-indigo-900/50">
        <div class="max-w-7xl mx-auto flex items-center justify-center space-x-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500 text-white uppercase tracking-wider">
                UTS Web Programming 2
            </span>
            <span class="text-slate-300 hidden sm:inline">Integrated Laravel Project:</span>
            <span class="text-indigo-200 font-semibold">Inventory & Sales Management System</span>
        </div>
    </div>

    <!-- Main Navigation Header (Full Width) -->
    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/25 group-hover:scale-105 transition">
                    <i class="fa-solid fa-boxes-stacked text-lg"></i>
                </div>
                <div>
                    <span class="font-extrabold text-xl tracking-tight text-slate-900">
                        Stock<span class="text-indigo-600">Flow</span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-400 block -mt-1 tracking-wider uppercase">
                        Distribution & Retail
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#tentang" class="hover:text-indigo-600 transition">Tentang Sistem</a>
                <a href="#fitur" class="hover:text-indigo-600 transition">Fitur Utama</a>
                <a href="#alur" class="hover:text-indigo-600 transition">Alur Transaksi</a>
                <a href="#arsitektur" class="hover:text-indigo-600 transition">Arsitektur & Keamanan</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/25 transition">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/25 transition transform hover:-translate-y-0.5">
                        <span>Masuk ke Sistem</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1">

        <!-- HERO SECTION (Spacious & Full Width) -->
        <section class="relative pt-12 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
            <!-- Decorative gradient glows -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-indigo-200/50 via-violet-200/40 to-pink-200/30 blur-3xl rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
                <!-- Badge Pill -->
                <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-200/80 text-indigo-700 text-xs font-bold mb-6 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    <span>Sistem Manajemen Bisnis Distribusi & Retail Terpadu</span>
                </div>

                <!-- Big Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 max-w-4xl mx-auto leading-tight sm:leading-tight">
                    Kelola Stok, Pengadaan, dan Transaksi Penjualan Secara <span class="gradient-text">Presisi & Terintegrasi</span>
                </h1>

                <!-- Subtitle -->
                <p class="mt-6 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed font-normal">
                    Dirancang untuk mengatasi permasalahan pencatatan manual: stok berubah otomatis saat pembelian atau penjualan, anti-overselling, dilindungi transaksi atomik, dan memiliki pembatasan hak akses yang tegas.
                </p>

                <!-- Hero CTA Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2.5 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-bold shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-right-to-bracket text-sm"></i>
                        <span>Masuk ke Dashboard Sistem</span>
                    </a>
                    <a href="#demo-accounts" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-2xl text-sm font-bold shadow-xs transition">
                        <i class="fa-solid fa-users-viewfinder text-indigo-500"></i>
                        <span>Lihat Akun Demo (Admin & Staff)</span>
                    </a>
                </div>

                <!-- Live Key Highlights Ticker -->
                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto text-left">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider block">Mutasi Stok</span>
                        <p class="text-sm font-extrabold text-slate-900 mt-1">Otomatis Real-Time</p>
                        <span class="text-xs text-slate-400">Bertambah via PO, berkurang via Kasir</span>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-xs font-bold text-violet-600 uppercase tracking-wider block">Konsistensi</span>
                        <p class="text-sm font-extrabold text-slate-900 mt-1">Anti-Overselling</p>
                        <span class="text-xs text-slate-400">Locking pesimis & atomic rollback</span>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-xs font-bold text-pink-600 uppercase tracking-wider block">Otorisasi</span>
                        <p class="text-sm font-extrabold text-slate-900 mt-1">Role-Based (RBAC)</p>
                        <span class="text-xs text-slate-400">Admin/Owner vs Staff Kasir</span>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block">Kualitas Kode</span>
                        <p class="text-sm font-extrabold text-slate-900 mt-1">19 Tests Passed</p>
                        <span class="text-xs text-slate-400">Unit & feature test komprehensif</span>
                    </div>
                </div>

                <!-- Wide Interactive Mockup Preview -->
                <div class="mt-14 max-w-5xl mx-auto rounded-3xl bg-slate-900 p-3 sm:p-4 shadow-2xl border border-slate-800">
                    <div class="bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 text-left">
                        <!-- Window Chrome Topbar -->
                        <div class="px-5 py-3 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                <span class="text-xs font-mono text-slate-400 ml-2">StockFlow Management Console &bull; http://127.0.0.1:8000/dashboard</span>
                            </div>
                            <span class="text-[11px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                                ● Database Live Connected
                            </span>
                        </div>

                        <!-- Mockup Content Grid -->
                        <div class="p-6 md:p-8 bg-slate-900/60 grid grid-cols-1 md:grid-cols-3 gap-6 text-slate-300 text-xs">
                            <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700/60">
                                <span class="text-slate-400 uppercase font-bold tracking-wider text-[10px]">Modul Pengadaan (Stock-In)</span>
                                <h4 class="text-white text-base font-bold mt-1">Purchase Order System</h4>
                                <p class="text-slate-400 mt-2 leading-relaxed">Input transaksi pemasok dengan multi-item dinamis. Menghasilkan invoice resmi dan menaikkan stok fisik seketika.</p>
                            </div>
                            <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700/60">
                                <span class="text-slate-400 uppercase font-bold tracking-wider text-[10px]">Modul Kasir (Stock-Out)</span>
                                <h4 class="text-white text-base font-bold mt-1">Point of Sale & Billing</h4>
                                <p class="text-slate-400 mt-2 leading-relaxed">Kasir melayani transaksi cepat. Harga dan total dihitung di server, menolak checkout jika stok barang di gudang kurang.</p>
                            </div>
                            <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700/60">
                                <span class="text-slate-400 uppercase font-bold tracking-wider text-[10px]">Analisis & Alert Cerdas</span>
                                <h4 class="text-white text-base font-bold mt-1">Low-Stock Watchdog</h4>
                                <p class="text-slate-400 mt-2 leading-relaxed">Deteksi dini produk dengan stok &le; minimum stock. Pemilik dapat melihat omzet hari ini dan bulan ini secara realtime.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- FITUR UTAMA (Full Width Grid) -->
        <section id="fitur" class="py-20 bg-white border-y border-slate-200/80">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Fitur Utama Aplikasi</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                        Dirancang Khusus Sesuai Standar Bisnis & Spesifikasi UTS
                    </h2>
                    <p class="text-slate-600 text-sm mt-3">
                        Mengintegrasikan materi PHP, MySQL, Eloquent ORM, arsitektur MVC, validasi input, dan transaksi konsisten.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Master Data Produk & SKU</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Mencatat SKU unik, nama produk, kategori, harga modal, harga jual, stok fisik, dan batas minimum stok. Dilindungi dengan proteksi *Soft Delete*.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-truck-moving"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pemasok & Pengadaan (Stock-In)</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Mencatat data pemasok resmi dan histori pembelian. Input multi-item dinamis otomatis menambah stok produk saat transaksi tersimpan.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-cash-register"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Kasir Penjualan (Stock-Out)</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Penjualan produk langsung mengurangi stok. Total nilai transaksi dihitung di server, dan penjualan ditolak tegas jika kuantitas melebihi stok.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Integritas DB Transaction</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Menerapkan atomisitas database `DB::transaction`. Jika satu item gagal, seluruh mutasi di-rollback sehingga tidak ada data setengah tersimpan.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Anti-Overselling Concurrency</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Menggunakan `Product::lockForUpdate()` untuk mencegah *race condition* ketika dua penjualan memproses produk yang sama hampir bersamaan.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-indigo-300 hover:shadow-md transition group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Laporan & Peringatan Stok</h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Dashboard menyajikan total omzet hari ini dan bulan ini via query agregat aktual, disertai tabel *Low-Stock Alert* untuk tindakan restock cepat.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALUR TRANSAKSI BISNIS (Slide 7) -->
        <section id="alur" class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Workflow Skenario Bisnis</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">
                        Alur Terpadu Pengadaan Stok & Penjualan
                    </h2>
                    <p class="text-slate-600 text-sm mt-3">
                        Bagaimana sistem mengelola siklus barang dari distributor hingga ke tangan konsumen secara konsisten.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                    <!-- Workflow Purchase -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <span class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg">Alur Pembelian (Stock-In)</h3>
                                    <span class="text-xs text-indigo-600 font-semibold">Pengadaan Barang dari Supplier</span>
                                </div>
                            </div>

                            <ol class="space-y-4 text-xs text-slate-600">
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                                    <span>Staff/Admin memilih supplier terdaftar dan menentukan tanggal pengadaan.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                                    <span>Menambahkan 1 atau lebih produk dengan kuantitas dan harga beli satuan.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                                    <span>Sistem memvalidasi kuantitas (&ge; 1) dan harga modal secara ketat di server.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                                    <span class="font-semibold text-slate-800">Transaksi disimpan & stok fisik produk otomatis bertambah di inventaris.</span>
                                </li>
                            </ol>
                        </div>

                        <div class="mt-8 pt-4 border-t border-slate-100 text-[11px] text-slate-400">
                            Nomor unik PO-YYYYMMDD-XXXXX diterbitkan otomatis dan dapat dibatalkan oleh Admin dengan pengembalian stok.
                        </div>
                    </div>

                    <!-- Workflow Sale -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-arrow-up"></i>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg">Alur Penjualan (Stock-Out)</h3>
                                    <span class="text-xs text-emerald-600 font-semibold">Kasir & Pelayanan Pelanggan</span>
                                </div>
                            </div>

                            <ol class="space-y-4 text-xs text-slate-600">
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                                    <span>Kasir memilih produk yang akan dibeli konsumen dan memasukkan kuantitas.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                                    <span>Sistem mengunci baris produk (`lockForUpdate`) dan memeriksa kecukupan stok fisik.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                                    <span>Server menghitung subtotal berdasarkan harga jual resmi di database, bukan input browser.</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                                    <span class="font-semibold text-slate-800">Jika stok cukup, stok berkurang dan struk INV-YYYYMMDD-XXXXX tercetak.</span>
                                </li>
                            </ol>
                        </div>

                        <div class="mt-8 pt-4 border-t border-slate-100 text-[11px] text-slate-400">
                            Jika stok kurang, seluruh transaksi langsung ditolak (rollback) tanpa ada data yang rusak atau stok yang berkurang.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DEMO ACCOUNTS QUICK ACCESS (Wide Card) -->
        <section id="demo-accounts" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-8 lg:p-12 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10 max-w-3xl">
                        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Akses Cepat Pengujian</span>
                        <h2 class="text-3xl font-extrabold text-white mt-2 tracking-tight">
                            Siap Diuji Langsung oleh Dosen & Tim Penilai
                        </h2>
                        <p class="text-slate-300 text-sm mt-3 leading-relaxed">
                            Database telah dilengkapi dengan akun demonstrasi dengan hak akses terpisah sesuai aturan bisnis UTS.
                        </p>

                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Admin Card -->
                            <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                                        👑 Role: Admin / Owner
                                    </span>
                                </div>
                                <div class="mt-3 text-xs space-y-1">
                                    <p class="text-slate-400">Email: <strong class="text-white font-mono">admin@inventory.com</strong></p>
                                    <p class="text-slate-400">Password: <strong class="text-white font-mono">password123</strong></p>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-2">Akses penuh: Kelola Pengguna, Master Data, Transaksi, dan Pembatalan.</p>
                            </div>

                            <!-- Staff Card -->
                            <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        🎀 Role: Staff Kasir
                                    </span>
                                </div>
                                <div class="mt-3 text-xs space-y-1">
                                    <p class="text-slate-400">Email: <strong class="text-white font-mono">staff@inventory.com</strong></p>
                                    <p class="text-slate-400">Password: <strong class="text-white font-mono">password123</strong></p>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-2">Akses operasional: Kasir Penjualan, Pembelian Stok, dan Katalog Produk.</p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-8 py-3.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-2xl text-sm font-bold shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                                <span>Menuju Halaman Login & Uji Sistem Sekarang</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Professional Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-white text-sm">StockFlow</span>
                <span>&bull;</span>
                <span>Integrated Laravel Project (Web Programming 2)</span>
            </div>
            <div>
                <span>Dibangun dengan Laravel 10, MySQL, Eloquent, & Tailwind CSS</span>
            </div>
        </div>
    </footer>

</body>
</html>
