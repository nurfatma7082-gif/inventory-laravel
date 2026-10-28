<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory & Sales System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 p-8 text-center text-white relative">
            <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl mx-auto flex items-center justify-center text-3xl shadow-inner mb-3">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">StockFlow Management</h1>
            <p class="text-indigo-100 text-xs mt-1">Sistem Terintegrasi Inventaris & Kasir Penjualan</p>
        </div>

        <div class="p-8">
            <!-- Session Messages -->
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@inventory.com') }}" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition"
                               placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" value="password123" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span>Ingat saya</span>
                    </label>
                    <span class="text-slate-400">UTS Web Programming 2</span>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium text-sm transition shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider text-center mb-3">Akun Demo Pengujian:</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="fillAccount('admin@inventory.com', 'password123')" 
                            class="p-2.5 rounded-lg border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 text-left transition group">
                        <div class="font-semibold text-slate-800 group-hover:text-indigo-600 flex items-center">
                            <i class="fa-solid fa-shield text-indigo-500 mr-1.5"></i> Admin
                        </div>
                        <div class="text-[11px] text-slate-500 truncate">admin@inventory.com</div>
                    </button>
                    <button type="button" onclick="fillAccount('staff@inventory.com', 'password123')" 
                            class="p-2.5 rounded-lg border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 text-left transition group">
                        <div class="font-semibold text-slate-800 group-hover:text-emerald-600 flex items-center">
                            <i class="fa-solid fa-user-tag text-emerald-500 mr-1.5"></i> Staff
                        </div>
                        <div class="text-[11px] text-slate-500 truncate">staff@inventory.com</div>
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
