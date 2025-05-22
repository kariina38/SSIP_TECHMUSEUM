<?php
session_start();
include 'db.php';

// Validasi role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-admin.php");
    exit();
}

// Validasi input
$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    header("Location: admin-dashboard.php?status=error&message=Username+atau+password+kosong");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Cek apakah username sudah ada
$check_sql = "SELECT * FROM admins WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    header("Location: admin-dashboard.php?status=error&message=Username+sudah+digunakan");
    exit();
}

// Tambahkan admin baru
$insert_sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("ss", $username, $hashed_password);

if ($insert_stmt->execute()) {
    header("Location: admin-dashboard.php?status=success");
} else {
    header("Location: admin-dashboard.php?status=error&message=Gagal+menyimpan+ke+database");
}
exit();
?>