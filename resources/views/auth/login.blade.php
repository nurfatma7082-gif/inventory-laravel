<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Sistem — StockFlow Management</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
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
    </style>
</head>
<body class="flex items-center justify-center p-4 relative overflow-hidden text-slate-800">

    <!-- Subtle decorative glow orbs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-violet-500/20 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-md w-full bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden">
        
        <!-- Header Banner: Elegant Deep Indigo / Violet Gradient -->
        <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-700 p-8 text-center text-white relative">
            <a href="{{ route('home') }}" class="absolute top-4 left-4 text-indigo-200 hover:text-white text-xs font-semibold flex items-center space-x-1 transition">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Beranda</span>
            </a>

            <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl mx-auto flex items-center justify-center text-2xl shadow-inner mb-3 border border-white/20">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight">StockFlow</h1>
            <p class="text-indigo-200 text-xs mt-1 font-medium">Inventory & Sales Management System</p>
        </div>

        <div class="p-7 sm:p-8 space-y-5">
            <!-- Session Messages -->
            @if(session('success'))
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@inventory.com') }}" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition"
                               placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" id="password" name="password" value="password123" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="font-medium text-slate-600">Ingat sesi saya</span>
                    </label>
                    <span class="text-slate-400 font-semibold text-[11px]">UTS Web Programming 2</span>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-indigo-600/30 flex items-center justify-center space-x-2 transform hover:-translate-y-0.5">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="pt-5 border-t border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center mb-2.5">
                    Klik untuk Memilih Akun Demo Pengujian:
                </p>
                <div class="grid grid-cols-2 gap-2.5 text-xs">
                    <button type="button" onclick="fillAccount('admin@inventory.com', 'password123')" 
                            class="p-3 rounded-2xl border border-indigo-200 bg-indigo-50/50 hover:bg-indigo-100/70 text-left transition group">
                        <div class="font-extrabold text-indigo-700 flex items-center text-xs">
                            <i class="fa-solid fa-shield-halved text-indigo-500 mr-1.5 text-xs"></i> Admin / Owner
                        </div>
                        <div class="text-[10px] text-slate-500 truncate mt-0.5 font-mono">admin@inventory.com</div>
                    </button>
                    <button type="button" onclick="fillAccount('staff@inventory.com', 'password123')" 
                            class="p-3 rounded-2xl border border-emerald-200 bg-emerald-50/50 hover:bg-emerald-100/70 text-left transition group">
                        <div class="font-extrabold text-emerald-700 flex items-center text-xs">
                            <i class="fa-solid fa-user-tag text-emerald-500 mr-1.5 text-xs"></i> Staff Kasir
                        </div>
                        <div class="text-[10px] text-slate-500 truncate mt-0.5 font-mono">staff@inventory.com</div>
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
