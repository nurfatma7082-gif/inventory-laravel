<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow — Sistem Manajemen Inventaris & Penjualan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 70%, #4338ca 100%);
        }
        .glow-orb-1 {
            background: radial-gradient(circle, rgba(99,102,241,0.35) 0%, transparent 70%);
        }
        .glow-orb-2 {
            background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, transparent 70%);
        }
        .glow-orb-3 {
            background: radial-gradient(circle, rgba(16,185,129,0.2) 0%, transparent 70%);
        }
        .card-glass {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .stat-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(3deg); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }
        .float-anim2 { animation: float2 5s ease-in-out infinite; }
        .float-anim3 { animation: float 3.5s ease-in-out infinite 0.5s; }
    </style>
</head>
<body class="hero-bg min-h-screen text-white antialiased flex flex-col overflow-x-hidden">

    <!-- Decorative background orbs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="glow-orb-1 absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full"></div>
        <div class="glow-orb-2 absolute top-1/3 -right-32 w-[400px] h-[400px] rounded-full"></div>
        <div class="glow-orb-3 absolute bottom-0 left-1/3 w-[350px] h-[350px] rounded-full"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <!-- Navbar -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/30 border border-indigo-400/40 text-white flex items-center justify-center text-lg shadow-lg">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <span class="font-extrabold text-lg tracking-tight text-white block leading-tight">StockFlow</span>
                <span class="text-[10px] font-semibold text-indigo-300 block">Inventory & Sales System</span>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <span class="hidden sm:inline text-xs font-semibold text-indigo-300/80 border border-indigo-400/30 px-3 py-1.5 rounded-lg">UTS Web Programming 2</span>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs shadow-md transition">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-500 hover:bg-indigo-400 text-white font-bold text-xs shadow-lg shadow-indigo-700/40 transition transform hover:-translate-y-0.5">
                    <span>Masuk Sistem</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <main class="relative z-10 flex-1 w-full max-w-7xl mx-auto px-6 pt-8 pb-16 flex flex-col">

        <!-- Hero Top: Text + Visual Illustration -->
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-8 min-h-[420px]">
            <!-- Text Side -->
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 text-xs font-bold mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Integrated Laravel Project &bull; UTS Web Programming 2</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight text-white max-w-2xl">
                    Sistem Manajemen<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-violet-300">Inventaris & Penjualan</span>
                </h1>

                <p class="mt-5 text-slate-300 text-sm sm:text-base leading-relaxed max-w-lg">
                    Solusi pencatatan stok barang dan transaksi penjualan secara terintegrasi. Dirancang dengan Laravel 10, MySQL, dan arsitektur MVC yang bersih.
                </p>

                <!-- Stats Row -->
                <div class="mt-8 flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="stat-card rounded-2xl px-5 py-3 text-center">
                        <div class="text-2xl font-extrabold text-indigo-300">10+</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Produk Tersimpan</div>
                    </div>
                    <div class="stat-card rounded-2xl px-5 py-3 text-center">
                        <div class="text-2xl font-extrabold text-violet-300">19</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Automated Tests</div>
                    </div>
                    <div class="stat-card rounded-2xl px-5 py-3 text-center">
                        <div class="text-2xl font-extrabold text-emerald-300">2</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Role Pengguna</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-10">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center space-x-3 px-8 py-4 bg-indigo-500 hover:bg-indigo-400 text-white rounded-2xl text-sm font-extrabold shadow-2xl shadow-indigo-900/60 transition transform hover:-translate-y-1 hover:shadow-indigo-700/50">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Sistem</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Visual Illustration Side -->
            <div class="flex-1 flex items-center justify-center relative">
                <!-- Central floating dashboard mockup -->
                <div class="relative w-full max-w-sm">
                    <!-- Main card -->
                    <div class="card-glass rounded-3xl p-6 shadow-2xl float-anim">
                        <!-- Fake chart header -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Total Pendapatan</p>
                                <p class="text-2xl font-extrabold text-white mt-0.5">Rp 8.450.000</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400">
                                <i class="fa-solid fa-arrow-trend-up text-sm"></i>
                            </div>
                        </div>
                        <!-- Fake mini bar chart -->
                        <div class="flex items-end gap-1.5 h-20 mt-2">
                            <div class="flex-1 bg-indigo-500/40 rounded-t-lg" style="height:45%"></div>
                            <div class="flex-1 bg-indigo-500/40 rounded-t-lg" style="height:65%"></div>
                            <div class="flex-1 bg-indigo-500/50 rounded-t-lg" style="height:50%"></div>
                            <div class="flex-1 bg-indigo-500/60 rounded-t-lg" style="height:75%"></div>
                            <div class="flex-1 bg-indigo-400/60 rounded-t-lg" style="height:60%"></div>
                            <div class="flex-1 bg-indigo-300/70 rounded-t-lg" style="height:90%"></div>
                            <div class="flex-1 bg-white/30 rounded-t-lg border border-white/30" style="height:100%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-[9px] text-slate-500 font-medium">
                            <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                        </div>
                    </div>

                    <!-- Floating card: Low Stock Alert -->
                    <div class="card-glass rounded-2xl px-4 py-3 shadow-xl absolute -top-6 -right-6 w-44 float-anim2">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-6 h-6 rounded-lg bg-amber-500/30 border border-amber-400/30 flex items-center justify-center">
                                <i class="fa-solid fa-triangle-exclamation text-amber-400 text-[10px]"></i>
                            </div>
                            <span class="text-[10px] font-bold text-amber-300">Low Stock Alert</span>
                        </div>
                        <p class="text-[10px] text-slate-400 leading-relaxed">3 produk stok menipis. Segera restok!</p>
                    </div>

                    <!-- Floating card: Transaction Done -->
                    <div class="card-glass rounded-2xl px-4 py-3 shadow-xl absolute -bottom-4 -left-6 w-48 float-anim3">
                        <div class="flex items-center space-x-2 mb-1.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-500/30 border border-emerald-400/30 flex items-center justify-center">
                                <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-300">Transaksi Berhasil</span>
                        </div>
                        <p class="text-xs font-bold text-white">Rp 320.000</p>
                        <p class="text-[10px] text-slate-400">Sale #INV-2024-001</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature Cards -->
        <div class="mt-20">
            <p class="text-center text-xs font-bold text-slate-500 uppercase tracking-widest mb-8">Fitur Utama Sistem</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Card 1 -->
                <div class="card-glass rounded-3xl p-6 hover:bg-white/10 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-white">Master Data & Stok</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Manajemen produk (SKU unik), kategori, dan supplier. Notifikasi otomatis saat stok menipis (<em>Low-Stock Alert</em>).
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="card-glass rounded-3xl p-6 hover:bg-white/10 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-violet-500/20 border border-violet-400/30 text-violet-300 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-white">Pembelian (Stock-In)</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Pencatatan pengadaan dari pemasok dengan invoice PO. Stok otomatis bertambah saat transaksi tersimpan secara atomik.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="card-glass rounded-3xl p-6 hover:bg-white/10 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 flex items-center justify-center text-xl mb-5 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-white">Penjualan (Stock-Out)</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        Kasir transaksi dengan harga dihitung <em>server-side</em>. Mencegah <em>overselling</em> dan stok otomatis berkurang.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-6 py-6 text-center text-xs text-slate-600 border-t border-white/10">
        &copy; 2026 StockFlow &bull; Tugas Ujian Tengah Semester Web Programming 2 (Laravel 10 & MySQL)
    </footer>

</body>
</html>
