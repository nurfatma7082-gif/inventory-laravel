<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventori & Manajemen Stok</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-indigo-50/40 to-pink-50/50 min-h-screen text-slate-800 flex flex-col justify-between">

    <!-- Header / Navbar Navigation -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-indigo-100/60 px-6 lg:px-12 py-3.5 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 to-rose-400 flex items-center justify-center text-white shadow-md shadow-indigo-200">
                    <span class="text-xl">📦</span>
                </div>
                <div>
                    <span class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-indigo-600 to-rose-500 bg-clip-text text-transparent">
                        Stockify
                    </span>
                    <span class="text-[10px] font-semibold bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-md ml-1.5 align-middle">
                        v1.0
                    </span>
                </div>
            </div>

            <nav class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-600">
                <a href="#fitur" class="hover:text-indigo-600 transition">Fitur Utama</a>
                <a href="#keunggulan" class="hover:text-indigo-600 transition">Keunggulan</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="{{ route('items.index') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-md shadow-indigo-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Masuk ke Sistem &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content / Hero Section -->
    <main class="flex-grow flex items-center justify-center px-6 py-12 md:py-20 relative overflow-hidden">
        <!-- Aksesori Hiasan Background Pastel -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-indigo-200/40 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-rose-200/40 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-4xl mx-auto text-center space-y-8 relative z-10">
            <!-- Badge Status -->
            <div class="inline-flex items-center gap-2 bg-white/90 border border-indigo-100 shadow-sm px-4 py-1.5 rounded-full">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-bold text-slate-700 tracking-wide uppercase">
                    Sistem Informasi Inventori Barang
                </span>
            </div>

            <!-- Headline Utama -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
                Kelola Stok Barang <br class="hidden sm:inline"/>
                <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-rose-500 bg-clip-text text-transparent">
                    Rapi, Cepat & Cerdas
                </span>
            </h1>

            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Platform pencatatan barang terpadu untuk memantau inventaris, kontrol ketersediaan stok, dan pengelolaan harga produk secara akurat.
            </p>

            <!-- Call To Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('items.index') }}" class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-rose-500 hover:from-indigo-700 hover:to-rose-600 text-white font-bold px-8 py-3.5 rounded-2xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>Lihat Data Inventori</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

            <!-- Card Highlights / Info Ringkas -->
            <div id="fitur" class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-12 text-left">
                <!-- Highlight 1 -->
                <div class="bg-white/90 backdrop-blur border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl mb-4">
                        📊
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Pencatatan Real-Time</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Data stok barang langsung terupdate setiap ada penambahan atau perubahan harga.
                    </p>
                </div>

                <!-- Highlight 2 -->
                <div class="bg-white/90 backdrop-blur border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xl mb-4">
                        ⚡
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Navigasi Ringkas</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Antarmuka yang intuitif dan mudah dioperasikan tanpa ribet untuk kebutuhan harian.
                    </p>
                </div>

                <!-- Highlight 3 -->
                <div class="bg-white/90 backdrop-blur border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xl mb-4">
                        🛡️
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Akurat & Aman</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Mencegah duplikasi data dan memudahkan rekapitulasi laporan stok barang.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 border-t border-slate-200/80 py-5 px-6 text-center text-xs text-slate-500">
        <p class="font-medium">
            Proyek Tugas Sistem Informasi • Universitas Malikussaleh
        </p>
    </footer>

</body>
</html>