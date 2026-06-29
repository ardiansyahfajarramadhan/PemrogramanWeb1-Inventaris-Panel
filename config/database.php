<?php
class Database {
    private $host = "localhost";
    private $port = "5432"; // Port default PostgreSQL
    private $db_name = "panel_inventory"; // Sesuaikan nama DB di DBeaver-mu
    private $username = "postgres"; // Username default Postgres, sesuaikan jika beda
    private $password = "223456"; // Isikan password PostgreSQL kamu di sini
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Menggunakan PDO dengan driver pgsql
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Set error mode ke exception untuk mempermudah debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Koneksi Database Gagal: " . $exception->getMessage();
        }
        return $this->conn;
    }
}