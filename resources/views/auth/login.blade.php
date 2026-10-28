<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem — StockFlow Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
        }
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 relative overflow-hidden min-h-screen">

    <!-- Decorative glow orbs -->
    <div class="glow-orb w-96 h-96 bg-indigo-600/25 -top-32 -left-32"></div>
    <div class="glow-orb w-96 h-96 bg-violet-600/20 -bottom-32 -right-32"></div>
    <div class="glow-orb w-64 h-64 bg-indigo-400/15 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
    <!-- Grid overlay -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.8) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-md w-full">
        <!-- Back link -->
        <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-indigo-300 hover:text-white text-xs font-semibold mb-5 transition group">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform text-[10px]"></i>
            <span>Kembali ke Beranda</span>
        </a>

        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200/60">

            <!-- Header Banner -->
            <div class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-700 px-8 py-8 text-center text-white relative overflow-hidden">
                <!-- Subtle pattern inside header -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white/15 backdrop-blur-md rounded-2xl mx-auto flex items-center justify-center text-2xl shadow-inner mb-3 border border-white/20">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight">StockFlow</h1>
                    <p class="text-indigo-200 text-xs mt-1 font-medium">Inventory & Sales Management System</p>
                </div>
            </div>

            <!-- Form Body -->
            <div class="px-8 py-8 space-y-5 text-slate-800">

                <!-- Session Messages -->
                @if(session('success'))
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                   class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50 focus:bg-white"
                                   placeholder="nama@perusahaan.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </span>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50 focus:bg-white"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember + Label -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center space-x-2 text-slate-600 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="font-medium">Ingat sesi saya</span>
                        </label>
                        <span class="text-slate-400 font-semibold text-[11px]">UTS Web Programming 2</span>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-indigo-600/30 flex items-center justify-center space-x-2 transform hover:-translate-y-0.5">
                        <span>Masuk ke Dashboard</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>

            </div>
        </div>

        <!-- Footer note -->
        <p class="text-center text-[11px] text-indigo-300/60 mt-5 font-medium">
            &copy; 2026 StockFlow &mdash; Sistem Manajemen Inventaris & Penjualan
        </p>
    </div>

</body>
</html>
