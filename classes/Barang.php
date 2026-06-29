<?php
class Barang {
    private $db;
    private $table = "barang";

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    // [READ] Mengambil semua data barang
    public function getAll() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY kode_barang ASC";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    // [READ ONE] Mengambil satu data barang berdasarkan ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    // [CREATE] Menambah barang baru
    public function create($kode, $nama, $jenis, $kategori, $merk, $stok, $harga, $foto) {
        try {
            $query = "INSERT INTO " . $this->table . " (kode_barang, nama_barang, jenis_komoditas, kategori, merk, stok, harga, foto_barang) 
                      VALUES (:kode, :nama, :jenis, :kategori, :merk, :stok, :harga, :foto)";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":kode", $kode);
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":jenis", $jenis);
            $stmt->bindParam(":kategori", $kategori);
            $stmt->bindParam(":merk", $merk);
            $stmt->bindParam(":stok", $stok, PDO::PARAM_INT);
            $stmt->bindParam(":harga", $harga);
            $stmt->bindParam(":foto", $foto);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // [UPDATE] Memperbarui data barang
    public function update($id, $kode, $nama, $jenis, $kategori, $merk, $stok, $harga, $foto) {
        try {
            $query = "UPDATE " . $this->table . " 
                      SET kode_barang = :kode, nama_barang = :nama, jenis_komoditas = :jenis, 
                          kategori = :kategori, merk = :merk, stok = :stok, harga = :harga, foto_barang = :foto 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":kode", $kode);
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":jenis", $jenis);
            $stmt->bindParam(":kategori", $kategori);
            $stmt->bindParam(":merk", $merk);
            $stmt->bindParam(":stok", $stok, PDO::PARAM_INT);
            $stmt->bindParam(":harga", $harga);
            $stmt->bindParam(":foto", $foto);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // [DELETE] Menghapus data barang
    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}