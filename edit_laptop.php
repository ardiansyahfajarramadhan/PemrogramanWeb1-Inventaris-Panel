<?php
require_once 'config/database.php';
require_once 'classes/Auth.php';
require_once 'classes/Barang.php';

// Proteksi Halaman Admin
Auth::checkSession();

$database = new Database();
$db = $database->getConnection();
$barangManager = new Barang($db);

// Ambil ID dari URL parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: master_barang.php");
    exit();
}

$id = intval($_GET['id']);
$data_barang = $barangManager->getById($id);

// Proteksi jika data tidak ditemukan
if (!$data_barang) {
    header("Location: master_barang.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantis Panel - Edit Komoditas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans text-slate-800 antialiased flex">

    <?php include 'components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <?php include 'components/topbar.php'; ?>

        <main class="flex-1 p-6 max-w-4xl mx-auto w-full space-y-6">
            
            <div class="text-xs text-gray-400 flex items-center gap-2">
                <a href="dashboard.php" class="hover:text-cyan-600">Dashboard</a>
                <span>&rsaquo;</span>
                <a href="master_barang.php" class="hover:text-cyan-600">Master Barang</a>
                <span>&rsaquo;</span>
                <span class="text-slate-800 font-medium">Edit Komoditas</span>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-base font-bold text-slate-800">📝 Perbarui Informasi Komoditas</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Ubah penempatan klasifikasi taksonomi untuk Kode Barang: <span class="font-mono text-cyan-600 font-bold"><?php echo htmlspecialchars($data_barang['kode_barang']); ?></span></p>
                </div>

                <form action="actions/barang_action.php" method="POST" class="space-y-5">
                    <input type="hidden" name="action_type" value="update">
                    <input type="hidden" name="id" value="<?php echo $data_barang['id']; ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kode Barang (Kunci Unik)</label>
                            <input type="text" name="kode_barang" required 
                                value="<?php echo htmlspecialchars($data_barang['kode_barang']); ?>"
                                class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50 font-mono">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori Utama</label>
                            <select id="edit-kategori" name="kategori" required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                <option value="1. Consumer Electronics (Elektronik Konsumen)" <?php echo $data_barang['kategori'] == '1. Consumer Electronics (Elektronik Konsumen)' ? 'selected' : ''; ?>>1. Consumer Electronics</option>
                                <option value="2. Home Appliances (Peralatan Rumah Tangga)" <?php echo $data_barang['kategori'] == '2. Home Appliances (Peralatan Rumah Tangga)' ? 'selected' : ''; ?>>2. Home Appliances</option>
                                <option value="3. Komponen, Periferal & Aksesori" <?php echo $data_barang['kategori'] == '3. Komponen, Periferal & Aksesori' ? 'selected' : ''; ?>>3. Komponen, Periferal & Aksesori</option>
                                <option value="4. Smart Home & IoT (Internet of Things)" <?php echo $data_barang['kategori'] == '4. Smart Home & IoT (Internet of Things)' ? 'selected' : ''; ?>>4. Smart Home & IoT</option>
                                <option value="5. Jasa & Layanan Pendukung" <?php echo $data_barang['kategori'] == '5. Jasa & Layanan Pendukung' ? 'selected' : ''; ?>>5. Jasa & Layanan Pendukung</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sub-Kategori / Jenis Komoditas</label>
                            <select id="edit-jenis" name="jenis_komoditas" required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama / Tipe Unit Spesifik</label>
                            <input type="text" name="nama_barang" required 
                                value="<?php echo htmlspecialchars($data_barang['nama_barang']); ?>"
                                placeholder="Contoh: MacBook Pro M3" class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Merk / Brand</label>
                            <select name="merk" required class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                                <?php 
                                $opsi_merk = ["Google", "Iphone", "Xiaomi", "Samsung", "Huawei", "Asus", "Infinix", "Lenovo", "Panasonic"];
                                foreach($opsi_merk as $m) {
                                    $selected = ($data_barang['merk'] == $m) ? 'selected' : '';
                                    echo "<option value='$m' $selected>$m</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Volume Stok Gudang</label>
                            <input type="number" name="stok" required min="0" 
                                value="<?php echo $data_barang['stok']; ?>"
                                class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Harga Pasar Terkini (Rp)</label>
                            <input type="number" name="harga" required min="0" 
                                value="<?php echo intval($data_barang['harga']); ?>"
                                class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-slate-900 bg-gray-50/50">
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="master_barang.php" class="bg-gray-100 hover:bg-gray-200 text-slate-700 font-bold px-5 py-2.5 rounded-lg text-xs uppercase tracking-wider transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold px-5 py-2.5 rounded-lg text-xs uppercase tracking-wider shadow-md transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </main>

        <?php include 'components/footer.php'; ?>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const katSelect = document.getElementById("edit-kategori");
        const jenSelect = document.getElementById("edit-jenis");

        // Simpan nilai awal dari database PHP
        const nilaiAwalSub = "<?php echo $data_barang['jenis_komoditas']; ?>";

        const dataTaksonomi = {
            "1. Consumer Electronics (Elektronik Konsumen)": [
                "Ponsel & Komunikasi", "Komputer & Komputasi", "Perangkat Wearable", 
                "Audio & Video", "Fotografi & Videografi", "Gaming"
            ],
            "2. Home Appliances (Peralatan Rumah Tangga)": [
                "Peralatan Besar (Major Appliances)", "Peralatan Dapur (Kitchen Appliances)", 
                "Peralatan Kebersihan & Perawatan", "Kesehatan & Perawatan Tubuh"
            ],
            "3. Komponen, Periferal & Aksesori": [
                "Suku Cadang Komputer", "Aksesori Gadget & PC", "Audio Portabel"
            ],
            "4. Smart Home & IoT (Internet of Things)": [
                "Keamanan", "Kontrol & Pencahayaan"
            ],
            "5. Jasa & Layanan Pendukung": [
                "Garansi Tambahan", "Jasa Instalasi", "Jasa Perbaikan"
            ]
        };

        function updateSubKategori(kategori, nilaiTerpilih = "") {
            jenSelect.innerHTML = '';
            if (kategori && dataTaksonomi[kategori]) {
                dataTaksonomi[kategori].forEach(function(sub) {
                    const opt = document.createElement("option");
                    opt.value = sub;
                    opt.textContent = sub;
                    if (sub === nilaiTerpilih) {
                        opt.selected = true;
                    }
                    jenSelect.appendChild(opt);
                });
            }
        }

        // Pemicu 1: Jalankan otomatis saat halaman pertama kali dibuka
        updateSubKategori(katSelect.value, nilaiAwalSub);

        // Pemicu 2: Jalankan jika admin mengubah pilihan Kategori Utama
        katSelect.addEventListener("change", function() {
            updateSubKategori(this.value);
        });
    });
    </script>
</body>
</html>