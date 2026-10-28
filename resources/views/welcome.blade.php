<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow — Sistem Manajemen Inventaris & Penjualan</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 20%, #f0f4ff 0%, #f8fafc 60%, #eef2ff 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-600 selection:text-white">

    <!-- Navbar Minimalis & Bersih -->
    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-lg shadow-md shadow-indigo-600/30">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900 block leading-tight">StockFlow</span>
                <span class="text-[11px] font-semibold text-indigo-600 block">Inventory & Sales System</span>
            </div>
        </div>

        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white font-bold text-xs shadow-sm transition transform hover:-translate-y-0.5">
                    <span>Masuk / Login</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Visual Hero Section (Fokus & Menarik) -->
    <main class="w-full max-w-5xl mx-auto px-6 py-8 flex-1 flex flex-col items-center justify-center text-center">

        <!-- Tag UTS -->
        <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-indigo-100/80 border border-indigo-200 text-indigo-700 text-xs font-bold mb-6">
            <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
            <span>Integrated Project &bull; UTS Web Programming 2</span>
        </div>

        <!-- Judul Utama yang Jelas Sesuai Tugas -->
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl leading-tight">
            Sistem Manajemen Inventaris & Transaksi Penjualan Bisnis
        </h1>

        <p class="mt-4 text-sm sm:text-base text-slate-600 max-w-xl font-normal leading-relaxed">
            Aplikasi terintegrasi untuk mencatat pengadaan stok barang (*Stock-In*) dan transaksi kasir penjualan (*Stock-Out*) secara otomatis dan konsisten.
        </p>

        <!-- Tombol Masuk Utama yang Jelas -->
        <div class="mt-8">
            <a href="{{ route('login') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-bold shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-0.5">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Masuk ke Halaman Login Sistem</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- 3 Visual Kartu Fitur (Menunjukkan Web Ini Tentang Apa Secara Visual) -->
        <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-5 w-full text-left">
            <!-- Card 1 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">1. Master Data & Stok</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Pengelolaan produk dengan SKU unik, kategori, harga modal, harga jual, dan deteksi stok menipis (*Low-Stock Alert*).
                </p>
            </div>

            <!-- Card 2 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">2. Pembelian (Stock-In)</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Pencatatan pengadaan dari pemasok dengan nomor invoice PO. Stok fisik otomatis bertambah saat transaksi disimpan.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">3. Penjualan (Stock-Out)</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Transaksi kasir dengan perhitungan harga server-side, otomatis memotong stok barang, dan mencegah *overselling*.
                </p>
            </div>
        </div>

        <!-- Info Demo Accounts Card di Bawah -->
        <div class="mt-10 p-5 rounded-2xl bg-indigo-900 text-white max-w-xl w-full flex flex-col sm:flex-row items-center justify-between gap-4 text-xs shadow-lg">
            <div class="text-left">
                <span class="font-bold text-indigo-200 uppercase tracking-wider text-[10px] block">Akun Pengujian Demo:</span>
                <span class="text-slate-300 block mt-0.5">Admin: <strong class="text-white font-mono">admin@inventory.com</strong> (password123)</span>
                <span class="text-slate-300 block">Staff: <strong class="text-white font-mono">staff@inventory.com</strong> (password123)</span>
            </div>
            <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl font-bold shrink-0 transition text-xs">
                Login Sekarang &rarr;
            </a>
        </div>

    </main>

    <!-- Footer Simple -->
    <footer class="w-full max-w-6xl mx-auto px-6 py-6 text-center text-xs text-slate-400 border-t border-slate-200/60">
        &copy; 2026 StockFlow &bull; Tugas Ujian Tengah Semester Web Programming 2 (Laravel & MySQL)
    </footer>

</body>
</html>
