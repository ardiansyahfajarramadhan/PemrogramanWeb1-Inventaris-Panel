<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Register</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen relative overflow-hidden">
    
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-black text-white tracking-wider">MANTIS<span class="text-cyan-400">PANEL</span></h2>
            <p class="text-gray-400 text-sm mt-2">Pendaftaran Otoritas Administrator Baru</p>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-slate-800">
            <div class="mb-5">
                <h3 class="text-xl font-bold text-white">Buat Akun</h3>
                <p class="text-gray-400 text-xs mt-1">Isi data di bawah dengan benar untuk mendapatkan akses kontrol gudang.</p>
                
                <?php if (isset($_GET['error']) && $_GET['error'] == 'username_taken'): ?>
                    <div class="bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs p-3 rounded-lg mt-3 text-center">
                        ⚠️ Username sudah terdaftar! Silakan cari nama lain.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] == 'failed'): ?>
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs p-3 rounded-lg mt-3 text-center">
                        ❌ Gagal mendaftar ke sistem. Silakan coba lagi.
                    </div>
                <?php endif; ?>
            </div>

            <form action="actions/auth_action.php" method="POST" class="space-y-4">
                <div>
                    <label for="nama_lengkap" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required 
                        class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition text-sm" 
                        placeholder="Nama lengkap Anda...">
                </div>

                <div>
                    <label for="username" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Username</label>
                    <input type="text" id="username" name="username" required 
                        class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition text-sm" 
                        placeholder="Buat nama pengguna...">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                        class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition text-sm" 
                        placeholder="••••••••">
                </div>

                <button type="submit" name="register" 
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold py-3 px-4 rounded-lg transition shadow-lg shadow-cyan-500/20 mt-2 text-sm uppercase tracking-wider cursor-pointer">
                    Daftar Admin Baru
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-xs text-gray-400">Sudah punya akun otoritas? <a href="login.php" class="text-cyan-400 hover:underline">Sign In di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>