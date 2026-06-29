<?php
require_once 'config/database.php'; 
require_once 'classes/Barang.php';

// Memulai session untuk mendeteksi apakah admin sedang login atau tidak
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = (new Database())->getConnection();
$daftar_barang = (new Barang($db))->getAll();

$totalStok = 0;
foreach ($daftar_barang as $b) {
    $totalStok += $b['stok'];
}
$totalRagam = count($daftar_barang);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Inventaris - Hub Elektronik</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-wider text-cyan-400">MANTIS<span class="text-white">PANEL</span></span>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:text-cyan-400 transition">Beranda</a>
                    <a href="#katalog" class="px-3 py-2 rounded-md text-sm font-medium hover:text-cyan-400 transition">Katalog</a>
                    
                    <!-- DINAMIS LOGIC: Cek Status Login Admin -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="ml-4 bg-emerald-500 hover:bg-emerald-600 text-slate-950 px-4 py-2 rounded-md text-sm font-bold transition shadow-lg shadow-emerald-500/20">
                            ⚙️ Masuk Dashboard Admin
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="ml-4 bg-cyan-500 hover:bg-cyan-600 text-slate-900 px-4 py-2 rounded-md text-sm font-semibold transition shadow-lg shadow-cyan-500/20">
                            Masuk Panel Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-950 text-white py-20 px-4 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-cyan-500/10 via-transparent to-transparent"></div>
        <div class="max-w-3xl mx-auto relative z-10">
            <span class="bg-cyan-500/10 text-cyan-400 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-cyan-500/20">System By Xcenta v1.0</span>
            <h1 class="text-4xl md:text-6xl font-black mt-4 tracking-tight leading-tight">
                Manajemen Logistik <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-teal-300">Gudang Elektronik</span>
            </h1>
            <p class="mt-6 text-gray-300 text-lg md:text-xl font-light max-w-2xl mx-auto">
                Kami menjual berbagai macam gawai, peralatan rumah tangga, dan aksesori pintar dengan performa tinggi.
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="#katalog" class="bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold px-8 py-3.5 rounded-lg transition shadow-lg shadow-cyan-500/25">
                    Lihat Inventaris
                </a>
                
                <!-- DINAMIS HERO BUTTON -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-lg transition">
                        Kembali ke Dashboard Kontrol
                    </a>
                <?php else: ?>
                    <a href="login.php" class="bg-slate-800/80 hover:bg-slate-800 text-white font-medium px-8 py-3.5 rounded-lg border border-slate-700 transition">
                        Dashboard Kontrol
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Mini Stats Showcase -->
    <section class="max-w-7xl mx-auto px-4 -mt-12 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase">Total Komoditas</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?php echo number_format($totalStok, 0, ',', '.'); ?> Unit</h3>
                </div>
                <div class="w-12 h-12 bg-cyan-50 rounded-lg flex items-center justify-center text-cyan-500 text-xl font-bold">📦</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase">Kategori Aktif</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">Taksonomi Lengkap</h3>
                </div>
                <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center text-teal-500 text-xl font-bold">⚡</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400 font-medium uppercase">Varian Item</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1"><?php echo $totalRagam; ?> Model</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500 text-xl font-bold">🏷️</div>
            </div>
        </div>
    </section>

    <!-- Katalog Section -->
    <main id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Inventaris Terbaru</h2>
            <p class="text-gray-500 mt-1">Daftar item real-time berdasarkan 5 pilar klasifikasi perangkat komputer dan elektronik.</p>
        </div>

        <!-- Grid Barang Dinamis -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php if(count($daftar_barang) > 0): ?>
                <?php foreach($daftar_barang as $row): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div class="h-48 bg-slate-100 flex items-center justify-center text-gray-400 text-5xl select-none">
                        <?php 
                        $sub = strtolower($row['jenis_komoditas']);
                        if (str_contains($sub, 'ponsel') || str_contains($sub, 'smart')) echo "📱";
                        elseif (str_contains($sub, 'komputer') || str_contains($sub, 'komputasi')) echo "💻";
                        elseif (str_contains($sub, 'audio') || str_contains($sub, 'video')) echo "📺";
                        elseif (str_contains($sub, 'dapur')) echo "🍳";
                        elseif (str_contains($sub, 'besar')) echo "🧊";
                        elseif (str_contains($sub, 'suku cadang')) echo "🔌";
                        elseif (str_contains($sub, 'jasa')) echo "🛠️";
                        else echo "📦";
                        ?>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <span class="text-xs bg-slate-100 text-slate-700 font-semibold px-2 py-0.5 rounded border border-slate-200"><?php echo htmlspecialchars($row['merk']); ?></span>
                                <span class="text-[10px] text-gray-400 font-mono">ID: <?php echo htmlspecialchars($row['kode_barang']); ?></span>
                            </div>
                            <h4 class="text-base font-bold text-slate-800 mt-2.5 truncate"><?php echo htmlspecialchars($row['nama_barang']); ?></h4>
                            <p class="text-[11px] text-gray-400 mt-0.5"><?php echo htmlspecialchars($row['jenis_komoditas']); ?></p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-cyan-600 font-extrabold text-sm">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                            <span class="text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded">
                                Stok: <?php echo $row['stok']; ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full bg-white text-center py-12 text-gray-400 border border-gray-200 rounded-xl shadow-sm">
                    📭 Belum ada data komoditas yang terekam di database.
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-slate-900 text-gray-400 text-center py-6 border-t border-slate-800 text-sm">
        <p>&copy; 2026 MantisPanel. All rights reserved.</p>
    </footer>
</body>
</html>