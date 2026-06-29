<?php
require_once 'config/database.php';
require_once 'classes/Auth.php';
require_once 'classes/Barang.php';

// Proteksi Halaman
Auth::checkSession();

$database = new Database();
$db = $database->getConnection();
$barangManager = new Barang($db);

// Ambil data barang dari DB untuk dijadikan pilihan simulasi transaksi
$daftar_barang = $barangManager->getAll();

// Simulasi Data Log Transaksi (Khas praktikum agar langsung tampil estetik tanpa buat tabel baru lagi)
$log_transaksi = [
    [
        "nota" => "TRX-20260629-001",
        "tanggal" => "2026-06-29 09:15",
        "barang" => "iPhone 15 Pro Max",
        "tipe" => "KELUAR",
        "jumlah" => 5,
        "operator" => $_SESSION['username']
    ],
    [
        "nota" => "TRX-20260628-004",
        "tanggal" => "2026-06-28 14:20",
        "barang" => "Laptop ThinkPad X1",
        "tipe" => "MASUK",
        "jumlah" => 25,
        "operator" => "System Auto"
    ],
    [
        "nota" => "TRX-20260628-002",
        "tanggal" => "2026-06-28 10:00",
        "barang" => "AirBuds Pro",
        "tipe" => "KELUAR",
        "jumlah" => 12,
        "operator" => $_SESSION['username']
    ],
    [
        "nota" => "TRX-20260627-011",
        "tanggal" => "2026-06-27 16:45",
        "barang" => "Smart TV 4K 55\"",
        "tipe" => "MASUK",
        "jumlah" => 10,
        "operator" => "Admin_Gudang2"
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Log Transaksi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans text-slate-800 antialiased flex">

    <?php include 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <?php include 'components/topbar.php'; ?>

        <main class="flex-1 p-6 space-y-6">
            
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Log Transaksi & Arus Stok</h2>
                <p class="text-xs text-gray-500 mt-0.5">Memantau mutasi kuantitas barang masuk (Suplai) dan barang keluar (Penjualan/Distribusi).</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-fit">
                    <div class="border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-slate-800">⚡ Input Mutasi Stok Cepat</h3>
                        <p class="text-[11px] text-gray-400">Simulasi manipulasi kuantitas item langsung.</p>
                    </div>

                    <form action="#" method="POST" onsubmit="alert('Simulasi Berhasil! Log transaksi baru telah dicatat.'); return false;" class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Pilih Komoditas</label>
                            <select required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                <?php foreach($daftar_barang as $b): ?>
                                    <option value="<?php echo $b['id']; ?>">
                                        [<?php echo $b['kode_barang']; ?>] <?php echo htmlspecialchars($b['nama_barang']); ?> (Sisa: <?php echo $b['stok']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Jenis Mutasi</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="border border-gray-200 rounded-lg p-3.5 flex items-center justify-center gap-2 cursor-pointer bg-emerald-50/20 text-emerald-600 font-bold text-xs hover:bg-emerald-50 transition">
                                    <input type="radio" name="type" value="IN" checked class="text-emerald-500 focus:ring-0"> 📥 MASUK
                                </label>
                                <label class="border border-gray-200 rounded-lg p-3.5 flex items-center justify-center gap-2 cursor-pointer bg-rose-50/20 text-rose-600 font-bold text-xs hover:bg-rose-50 transition">
                                    <input type="radio" name="type" value="OUT" class="text-rose-500 focus:ring-0"> 📤 KELUAR
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Jumlah Volume (Pcs)</label>
                            <input type="number" required min="1" placeholder="0" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-lg text-xs uppercase tracking-wider shadow-md transition">
                            Eksekusi Transaksi
                        </button>