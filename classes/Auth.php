<?php
class Auth {
    private $db;
    private $table = "users";

    public function __construct($db_conn) {
        $this->db = $db_conn;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Fungsi Log In dengan Verifikasi Password Hash
    public function login($username, $password) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Fungsi Registrasi User Baru
    public function register($username, $password, $nama_lengkap) {
        try {
            $checkQuery = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->bindParam(":username", $username);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                return "username_taken";
            }

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap) VALUES (:username, :password, :nama_lengkap)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":nama_lengkap", $nama_lengkap);

            if ($stmt->execute()) {
                return "success";
            }
            return "failed";
        } catch (PDOException $e) {
            return "failed";
        }
    }

    // Proteksi Halaman Admin
    public static function checkSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php?msg=forbidden");
            exit();
        }
    }

    // Fungsi Log Out 
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        
        // Hapus tanda "../" agar tetap mencari login.php di dalam folder project yang sama
        header("Location: login.php?msg=logout");
        exit();
    }
}