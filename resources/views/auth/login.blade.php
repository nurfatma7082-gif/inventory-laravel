<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun ✨ StockFlow</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fce7f3 0%, #ede9fe 40%, #e0e7ff 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Cute decorative background blur orbs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-pink-300/40 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-purple-300/40 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-md w-full bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl shadow-pink-500/10 border border-pink-200/60 overflow-hidden">
        
        <!-- Header Banner with Cute Pastel Gradient -->
        <div class="bg-gradient-to-r from-pink-500 via-rose-400 to-purple-500 p-8 text-center text-white relative">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center text-2xl shadow-inner mb-3 transform hover:rotate-6 transition">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[10px] font-extrabold bg-white/25 backdrop-blur-md text-white border border-white/30 uppercase tracking-widest mb-1">
                🌸 Sistem Terintegrasi
            </span>
            <h1 class="text-2xl font-extrabold tracking-tight">StockFlow ✨</h1>
            <p class="text-pink-100 text-xs mt-1 font-medium">Sistem Manajemen Inventaris & Kasir Penjualan</p>
        </div>

        <div class="p-7 sm:p-8 space-y-5">
            <!-- Session Messages -->
            @if(session('success'))
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Email 💌
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-pink-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@inventory.com') }}" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 text-sm outline-none transition bg-pink-50/20"
                               placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi 🔒
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-pink-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" value="password123" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 text-sm outline-none transition bg-pink-50/20"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded-lg border-pink-300 text-pink-500 focus:ring-pink-400">
                        <span class="font-medium text-slate-500">Ingat sesi saya</span>
                    </label>
                    <span class="text-pink-400 font-bold text-[11px]">UTS Web Prog 2 🌸</span>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-pink-500 via-rose-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-pink-500/25 flex items-center justify-center space-x-2 transform hover:-translate-y-0.5">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="pt-5 border-t border-pink-100">
                <p class="text-[11px] font-bold text-pink-400/90 uppercase tracking-wider text-center mb-2.5">
                    ✨ Klik Akun Demo Sekali-Tekan:
                </p>
                <div class="grid grid-cols-2 gap-2.5 text-xs">
                    <button type="button" onclick="fillAccount('admin@inventory.com', 'password123')" 
                            class="p-3 rounded-2xl border border-purple-200 bg-purple-50/40 hover:bg-purple-100/60 text-left transition group">
                        <div class="font-extrabold text-purple-700 flex items-center text-xs">
                            <span class="mr-1">👑</span> Admin
                        </div>
                        <div class="text-[10px] text-slate-500 truncate mt-0.5">admin@inventory.com</div>
                    </button>
                    <button type="button" onclick="fillAccount('staff@inventory.com', 'password123')" 
                            class="p-3 rounded-2xl border border-pink-200 bg-pink-50/40 hover:bg-pink-100/60 text-left transition group">
                        <div class="font-extrabold text-pink-700 flex items-center text-xs">
                            <span class="mr-1">🎀</span> Staff Kasir
                        </div>
                        <div class="text-[10px] text-slate-500 truncate mt-0.5">staff@inventory.com</div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
