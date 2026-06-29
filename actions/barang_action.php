<?php
require_once '../config/database.php';
require_once '../classes/Auth.php';
require_once '../classes/Barang.php';

Auth::checkSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_type'])) {
    $database = new Database();
    $db = $database->getConnection();
    $barangManager = new Barang($db);

    $kode  = trim($_POST['kode_barang']);
    $nama  = trim($_POST['nama_barang']); 
    $jenis = trim($_POST['jenis_komoditas']); 
    $kat   = trim($_POST['kategori']);
    $merk  = trim($_POST['merk']);
    $stok  = intval($_POST['stok']);
    $hrg   = floatval($_POST['harga']);
    $foto  = "default.jpg";

    if ($_POST['action_type'] == 'insert') {
        $barangManager->create($kode, $nama, $jenis, $kat, $merk, $stok, $hrg, $foto);
    } elseif ($_POST['action_type'] == 'update' && isset($_POST['id'])) {
        $barangManager->update(intval($_POST['id']), $kode, $nama, $jenis, $kat, $merk, $stok, $hrg, $foto);
    }
    header("Location: ../master_barang.php?status=success");
    exit();
} else {
    header("Location: ../master_barang.php");
    exit();
}