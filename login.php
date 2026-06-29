<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Log In</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white tracking-wider">MANTIS<span class="text-cyan-400">PANEL</span></h2>
            <p class="text-gray-400 text-sm mt-2">Sistem Manajemen Kontrol Inventaris Gudang</p>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-slate-800">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-white">Selamat Datang Kembali</h3>
                <p class="text-gray-400 text-xs mt-1">Silakan masukkan akun otoritas admin Anda.</p>
                
                <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs p-3 rounded-lg mt-3 text-center">
                        ⚠️ Username atau password salah!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['id']) || (isset($_GET['msg']) && $_GET['msg'] == 'forbidden')): ?>
                    <div class="bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs p-3 rounded-lg mt-3 text-center">
                        🔒 Akses ditolak! Anda wajib login terlebih dahulu.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'logout'): ?>
                    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs p-3 rounded-lg mt-3 text-center">
                        ✅ Anda berhasil keluar sistem.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'register_success'): ?>
                    <div class="bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs p-3 rounded-lg mt-3 text-center">
                        🎉 Registrasi berhasil! Silakan masuk dengan akun baru.
                    </div>
                <?php endif; ?>
            </div>

            <form action="actions/auth_action.php" method="POST" class="space-y-5">
                <div>
                    <label for="username" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Username</label>
                    <input type="text" id="username" name="username" required 
                        class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition text-sm" 
                        placeholder="Masukkan username anda...">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                        class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition text-sm" 
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-gray-400 cursor-pointer select-none">
                        <input type="checkbox" class="rounded border-slate-800 bg-slate-950 text-cyan-500 focus:ring-0 mr-2">
                        Ingat Saya
                    </label>
                    <a href="index.php" class="text-cyan-400 hover:underline">Kembali ke Beranda</a>
                </div>

                <button type="submit" name="login" 
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold py-3 px-4 rounded-lg transition shadow-lg shadow-cyan-500/20 mt-2 text-sm uppercase tracking-wider cursor-pointer">
                    Sign In
                </button>
            </form>

            <div class="text-center mt-5 pt-4 border-t border-slate-800/60">
                <p class="text-xs text-gray-400">Belum punya akses? <a href="register.php" class="text-cyan-400 hover:underline font-medium">Daftar Akun Otoritas Baru</a></p>
            </div>
        </div>

        <div class="text-center mt-6 text-xs text-gray-500">
            <p>Mantis Inventaris &bull; Ditenagai oleh PostgreSQL & Tailwind</p>
        </div>
    </div>
</body>
</html>