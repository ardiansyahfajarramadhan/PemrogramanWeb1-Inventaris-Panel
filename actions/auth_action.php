<?php
require_once '../config/database.php';
require_once '../classes/Auth.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Handler POST untuk LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($auth->login($username, $password)) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        header("Location: ../login.php?error=invalid");
        exit();
    }
} 

// Handler POST untuk REGISTER
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username     = trim($_POST['username']);
    $password     = trim($_POST['password']);

    $status = $auth->register($username, $password, $nama_lengkap);

    if ($status == "success") {
        header("Location: ../login.php?msg=register_success");
    } elseif ($status == "username_taken") {
        header("Location: ../register.php?error=username_taken");
    } else {
        header("Location: ../register.php?error=failed");
    }
    exit();
}

// Jika bypass url langsung tanpa form
header("Location: ../login.php");
exit();