<?php
// Mendapatkan nama file saat ini untuk menentukan menu yang aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-slate-900 text-slate-300 min-h-screen flex flex-col border-r border-slate-800 shadow-xl shrink-0">
    <!-- Brand / Header Sidebar -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950/40">
        <span class="text-lg font-black tracking-wider text-cyan-400">MANTIS<span class="text-white">PANEL</span></span>
        <span class="ml-2 px-1.5 py-0.5 text-[10px] font-bold bg-slate-800 text-slate-400 rounded border border-slate-700">v1.0</span>
    </div>

    <!-- Navigasi Menu -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Menu Utama</p>
        
        <!-- Dashboard Link -->
        <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition group <?php echo $current_page == 'dashboard.php' ? 'bg-cyan-500 text-slate-950 font-bold shadow-lg shadow-cyan-500/20' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <span class="text-lg">📊</span>
            <span>Dashboard</span>
        </a>

        <!-- Master Barang Link -->
        <a href="master_barang.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition group <?php echo $current_page == 'master_barang.php' ? 'bg-cyan-500 text-slate-950 font-bold shadow-lg shadow-cyan-500/20' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <span class="text-lg">📦</span>
            <span>Master Barang</span>
        </a>

        <!-- Transaksi Link -->
        <a href="transaksi.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition group <?php echo $current_page == 'transaksi.php' ? 'bg-cyan-500 text-slate-950 font-bold shadow-lg shadow-cyan-500/20' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <span class="text-lg">🔄</span>
            <span>Log Transaksi</span>
        </a>

        <!-- BARU: Link Memantau Halaman Utama Tanpa Logout -->
        <div class="pt-4">
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Monitoring</p>
            <a href="index.php" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800 hover:text-white transition group">
                <span class="text-lg group-hover:animate-pulse">🌐</span>
                <span class="text-slate-300 group-hover:text-cyan-400">Lihat Etalase Publik</span>
            </a>
        </div>

        <div class="pt-6">
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Sistem</p>
            <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition">
                <span class="text-lg">🚪</span>
                <span>Sign Out</span>
            </a>
        </div>
    </nav>

    <!-- Footer Sidebar / Info User Singkat -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/20 flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-cyan-500 flex items-center justify-center text-slate-950 font-bold text-xs">
            <?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 2)); ?>
        </div>
        <div class="overflow-hidden">
            <p class="text-xs font-semibold text-white truncate"><?php echo $_SESSION['nama_lengkap'] ?? 'Administrator'; ?></p>
            <p class="text-[10px] text-slate-500 truncate">Role: Super Admin</p>
        </div>
    </div>
</aside>