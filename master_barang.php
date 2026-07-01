<?php
require_once 'config/database.php';
require_once 'classes/Auth.php';
require_once 'classes/Barang.php';

Auth::checkSession();

$database = new Database();
$db = $database->getConnection();
$barangManager = new Barang($db);

// Proses Hapus Data
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if ($barangManager->delete(intval($_GET['id']))) {
        header("Location: master_barang.php?status=deleted");
        exit();
    }
}

$semua_barang = $barangManager->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Master Barang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans text-slate-800 antialiased flex">

    <?php include 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <?php include 'components/topbar.php'; ?>

        <main class="flex-1 p-6 space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Master Komoditas Barang</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola data taksonomi logistik gudang secara berkala.</p>
                </div>
                <a href="#form-input" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition shadow-md">➕ Tambah Item Baru</a>
            </div>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
                <div class="bg-red-500/10 border border-red-200 text-red-600 text-xs p-3 rounded-xl">Sukses menghapus item komoditas.</div>
            <?php endif; ?>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div class="bg-emerald-500/10 border border-emerald-200 text-emerald-600 text-xs p-3 rounded-xl">Sukses menyimpan/memperbarui data komoditas.</div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs font-bold uppercase text-gray-400 bg-slate-50/50">
                                <th class="px-6 py-3.5">Kode</th>
                                <th class="px-6 py-3.5">Nama & Tipe Unit</th>
                                <th class="px-6 py-3.5">Sub-Kategori</th>
                                <th class="px-6 py-3.5">Merk</th>
                                <th class="px-6 py-3.5 text-right">Harga</th>
                                <th class="px-6 py-3.5 text-center">Stok</th>
                                <th class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(count($semua_barang) > 0): ?>
                                <?php foreach($semua_barang as $row): ?>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 font-mono text-xs font-semibold text-cyan-600"><?php echo htmlspecialchars($row['kode_barang']); ?></td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800"><?php echo htmlspecialchars($row['nama_barang']); ?></div>
                                        <div class="text-[10px] text-gray-400 font-medium"><?php echo htmlspecialchars($row['kategori']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-slate-600"><?php echo htmlspecialchars($row['jenis_komoditas']); ?></td>
                                    <td class="px-6 py-4"><span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-0.5 rounded border border-slate-200/60"><?php echo htmlspecialchars($row['merk']); ?></span></td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-700">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-4 text-center"><span class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-50 text-emerald-700"><?php echo $row['stok']; ?> Pcs</span></td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="edit_laptop.php?id=<?php echo $row['id']; ?>" class="text-xs font-bold text-cyan-600 hover:text-cyan-700 bg-cyan-50 px-2 py-1 rounded transition">Edit</a>
                                        <a href="master_barang.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Hapus item ini?')" class="text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 px-2 py-1 rounded transition">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Belum ada data terekam di PostgreSQL.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="form-input" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 scroll-mt-24">
                <div class="border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-sm font-bold text-slate-800">📥 Formulir Pendaftaran Komoditas Baru</h3>
                    <p class="text-xs text-gray-400">Gunakan pembagian kategori komoditas lengkap untuk mendaftarkan aset baru.</p>
                </div>

                <form action="actions/barang_action.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action_type" value="insert">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kode Barang</label>
                            <input type="text" name="kode_barang" required placeholder="Contoh: CE-04" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50 font-mono">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori Utama</label>
                            <select id="select-kategori" name="kategori" required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                <option value="">-- Pilih Kategori Utama --</option>
                                <option value="Consumer Electronics (Elektronik Konsumen)">1. Consumer Electronics</option>
                                <option value="Home Appliances (Peralatan Rumah Tangga)">2. Home Appliances</option>
                                <option value="Komponen, Periferal & Aksesori">3. Komponen, Periferal & Aksesori</option>
                                <option value="Smart Home & IoT (Internet of Things)">4. Smart Home & IoT</option>
                                <option value="Jasa & Layanan Pendukung">5. Jasa & Layanan Pendukung</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sub-Kategori / Jenis Komoditas</label>
                            <select id="select-jenis" name="jenis_komoditas" required disabled class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-100 text-gray-400 cursor-not-allowed">
                                <option value="">-- Pilih Kategori Utama Dulu --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama / Tipe Unit Spesifik</label>
                            <input type="text" name="nama_barang" required placeholder="Contoh: MacBook Pro M3 / Galaxy S24" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Merk / Brand</label>
                            <select name="merk" required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                <option value="Google">Google</option>
                                <option value="Iphone">Iphone</option>
                                <option value="Xiaomi">Xiaomi</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Huawei">Huawei</option>
                                <option value="Asus">Asus</option>
                                <option value="Infinix">Infinix</option>
                                <option value="Lenovo">Lenovo</option>
                                <option value="Panasonic">Panasonic</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Volume Stok (Pcs)</label>
                            <input type="number" name="stok" required min="0" placeholder="0" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Harga Pasar Terkini (Rp)</label>
                            <input type="number" name="harga" required min="0" placeholder="Contoh: 15000000" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold px-6 py-2.5 rounded-lg text-xs uppercase tracking-wider shadow-md transition cursor-pointer">Simpan Komoditas</button>
                    </div>
                </form>
            </div>

        </main>
        <?php include 'components/footer.php'; ?>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const kategoriSelect = document.getElementById("select-kategori");
        const jenisSelect = document.getElementById("select-jenis");

        const dataTaksonomi = {
            "1. Consumer Electronics (Elektronik Konsumen)": ["Ponsel & Komunikasi", "Komputer & Komputasi", "Perangkat Wearable", "Audio & Video", "Fotografi & Videografi", "Gaming"],
            "2. Home Appliances (Peralatan Rumah Tangga)": ["Peralatan Besar (Major Appliances)", "Peralatan Dapur (Kitchen Appliances)", "Peralatan Kebersihan & Perawatan", "Kesehatan & Perawatan Tubuh"],
            "3. Komponen, Periferal & Aksesori": ["Suku Cadang Komputer", "Aksesori Gadget & PC", "Audio Portabel"],
            "4. Smart Home & IoT (Internet of Things)": ["Keamanan", "Kontrol & Pencahayaan"],
            "5. Jasa & Layanan Pendukung": ["Garansi Tambahan", "Jasa Instalasi", "Jasa Perbaikan"]
        };

        kategoriSelect.addEventListener("change", function() {
            const val = this.value;
            jenisSelect.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';
            
            if (val && dataTaksonomi[val]) {
                jenisSelect.disabled = false;
                jenisSelect.classList.remove("bg-gray-100", "text-gray-400", "cursor-not-allowed");
                jenisSelect.classList.add("bg-gray-50/50");

                dataTaksonomi[val].forEach(function(sub) {
                    const opt = document.createElement("option");
                    opt.value = sub; opt.textContent = sub;
                    jenisSelect.appendChild(opt);
                });
            } else {
                jenisSelect.disabled = true;
                jenisSelect.classList.add("bg-gray-100", "text-gray-400", "cursor-not-allowed");
                jenisSelect.classList.remove("bg-gray-50/50");
            }
        });
    });
    </script>
</body>
</html>
