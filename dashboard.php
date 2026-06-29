<?php
require_once 'config/database.php';
require_once 'classes/Auth.php';

// Proteksi Halaman: Jika belum login, tendang balik ke login.php
Auth::checkSession();

// Ambil data statistik dari database untuk ditampilkan di dashboard
$database = new Database();
$db = $database->getConnection();

try {
    // 1. Hitung Total Stok Seluruh Barang
    $stmtStok = $db->query("SELECT SUM(stok) as total_stok FROM barang");
    $totalStok = $stmtStok->fetch()['total_stok'] ?? 0;

    // 2. Hitung Total Ragam Produk (Jumlah Baris)
    $stmtRagam = $db->query("SELECT COUNT(id) as total_ragam FROM barang");
    $totalRagam = $stmtRagam->fetch()['total_ragam'] ?? 0;

    // 3. Hitung Total Estimasi Nilai Aset (Harga * Stok)
    $stmtAset = $db->query("SELECT SUM(harga * stok) as total_aset FROM barang");
    $totalAset = $stmtAset->fetch()['total_aset'] ?? 0;

    // 4. Ambil 3 Barang dengan Stok Paling Sedikit (Peringatan Re-stock)
    $stmtLimit = $db->query("SELECT * FROM barang ORDER BY stok ASC LIMIT 3");
    $barangLimit = $stmtLimit->fetchAll();

} catch (PDOException $e) {
    echo "Gagal mengambil data statistik: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans text-slate-800 antialiased flex">

    <?php include 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <?php include 'components/topbar.php'; ?>

        <main class="flex-1 p-6 space-y-6">
            
            <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-cyan-950 p-6 rounded-2xl text-white shadow-lg border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold tracking-tight">Ringkasan Sistem Kontrol Gudang</h2>
                    <p class="text-xs text-slate-400 mt-1">Gunakan panel ini untuk mengawasi arus keluar masuk barang, sisa komoditas, dan total nilai aset.</p>
                </div>
                <a href="master_barang.php" class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold px-4 py-2 rounded-lg text-xs transition uppercase tracking-wider text-center">
                    Kelola Data Barang &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Nilai Kapital Aset</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Rp <?php echo number_format($totalAset, 0, ',', '.'); ?></h3>
                        <span class="text-[10px] text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded mt-2 inline-block">Kalkulasi Otomatis</span>
                    </div>
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center text-xl font-bold">💰</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Volume Stok Barang</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1"><?php echo number_format($totalStok, 0, ',', '.'); ?> <span class="text-sm font-normal text-gray-400">Unit</span></h3>
                        <span class="text-[10px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded mt-2 inline-block">Elektronik Terbanyak</span>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center text-xl font-bold">📦</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ragam Varian Item</p>
                        <h3 class="text-2xl font-black text-slate-900 mt-1"><?php echo $totalRagam; ?> <span class="text-sm font-normal text-gray-400">Model</span></h3>
                        <span class="text-[10px] text-amber-600 font-medium bg-amber-50 px-2 py-0.5 rounded mt-2 inline-block">Tersebar di 9 Brand</span>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl font-bold">🏷️</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">⚠️ Peringatan Restock (Stok Paling Tipis)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Segera lakukan penambahan unit untuk komoditas di bawah ini.</p>
                    </div>
                    <span class="text-[11px] bg-red-50 text-red-600 px-2.5 py-1 rounded-full font-semibold border border-red-200">Tindakan Diperlukan</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs font-semibold uppercase text-gray-400 bg-slate-50/50">
                                <th class="px-6 py-3">Kode</th>
                                <th class="px-6 py-3">Nama Barang</th>
                                <th class="px-6 py-3">Merk</th>
                                <th class="px-6 py-3">Harga Satuan</th>
                                <th class="px-6 py-3 text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(count($barangLimit) > 0): ?>
                                <?php foreach($barangLimit as $row): ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-3.5 font-mono text-xs text-slate-500"><?php echo htmlspecialchars($row['kode_barang']); ?></td>
                                    <td class="px-6 py-3.5 font-semibold text-slate-800"><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                    <td class="px-6 py-3.5 text-gray-600"><span class="bg-gray-100 px-2 py-0.5 rounded text-xs"><?php echo htmlspecialchars($row['merk']); ?></span></td>
                                    <td class="px-6 py-3.5 text-slate-700">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="px-2.5 py-1 rounded text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <?php echo $row['stok']; ?> Unit
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data komoditas terdeteksi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <?php include 'components/footer.php'; ?>
    </div>

</body>
</html>