<?php
// Pastikan koneksi database tersedia di topbar untuk menghitung notifikasi dinamis
if (isset($db)) {
    // 1. Hitung jumlah komoditas yang stoknya kritis (di bawah 10 unit) sebagai alert
    try {
        $queryAlert = "SELECT COUNT(id) FROM barang WHERE stok < 10";
        $stmtAlert = $db->query($queryAlert);
        $stokKritis = $stmtAlert->fetchColumn() ?? 0;
    } catch (PDOException $e) {
        $stokKritis = 0;
    }

    // 2. Hitung total seluruh akun administrator terdaftar
    try {
        $queryUser = "SELECT COUNT(id) FROM users";
        $stmtUser = $db->query($queryUser);
        $totalAdmin = $stmtUser->fetchColumn() ?? 1;
    } catch (PDOException $e) {
        $totalAdmin = 1;
    }
} else {
    $stokKritis = 0;
    $totalAdmin = 1;
}
?>
<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40 shadow-sm">
    
    <!-- Bagian Kiri: Sapaan Otoritas Admin -->
    <div class="flex items-center gap-4">
        <h1 class="text-sm font-semibold text-slate-800 flex items-center gap-2">
            🔑 Otoritas: 
            <span class="text-cyan-600 font-bold bg-cyan-50/60 px-2.5 py-1 rounded-lg border border-cyan-100/50">
                <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>
            </span>
        </h1>
        
        <!-- PINTASAN CEPAT: Tombol Monitor Etalase Luar -->
        <a href="index.php" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs text-gray-500 hover:text-cyan-600 font-medium transition group bg-slate-50 px-2.5 py-1 rounded-md border border-gray-100">
            <span>🌐</span>
            <span>Buka Etalase</span>
        </a>
    </div>

    <!-- Bagian Kanan: Widget Informasi Sistem -->
    <div class="flex items-center gap-4 sm:gap-6">
        
        <!-- WIDGET 1: Notifikasi Alert Stok Kritis (Dinamis) -->
        <div class="relative flex items-center gap-1.5 text-xs font-medium">
            <span class="text-base">🔔</span>
            <span class="text-gray-500 hidden md:inline">Logistik Kritis:</span>
            <?php if ($stokKritis > 0): ?>
                <span class="bg-amber-500 text-white font-black text-[10px] px-2 py-0.5 rounded-full animate-bounce">
                    <?php echo $stokKritis; ?> Item
                </span>
            <?php else: ?>
                <span class="bg-slate-100 text-slate-500 font-bold text-[10px] px-2 py-0.5 rounded-full">
                    0 Aman
                </span>
            <?php endif; ?>
        </div>

        <!-- WIDGET 2: Total Akun Otoritas (Dinamis) -->
        <div class="flex items-center gap-1.5 text-xs font-medium border-l border-gray-200 pl-4">
            <span class="text-base">👥</span>
            <span class="text-gray-500 hidden md:inline">Otoritas Terdaftar:</span>
            <span class="bg-cyan-100 text-cyan-700 font-bold text-[10px] px-2 py-0.5 rounded-full">
                <?php echo $totalAdmin; ?> Admin
            </span>
        </div>

        <!-- WIDGET 3: Indikator Database PostgreSQL -->
        <div class="flex items-center gap-2 bg-slate-50 border border-gray-200/80 px-3 py-1 rounded-lg text-xs font-medium">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-gray-500">DB: <span class="text-slate-800 font-bold">PostgreSQL</span></span>
        </div>

        <!-- WIDGET 4: Kalender Sistem Dinamis -->
        <div class="flex items-center gap-1.5 text-xs text-gray-500 font-medium border-l border-gray-200 pl-4 hidden sm:flex">
            <span>📅</span>
            <span><?php echo date('d M Y'); ?></span>
        </div>

    </div>
</header>