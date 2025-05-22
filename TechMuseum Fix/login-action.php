<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$raw_password = $_POST['password'];
$role = $_POST['role'];

$table = ($role === 'admin') ? 'admins' : 'users';
$sql = "SELECT * FROM $table WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($raw_password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        if ($role === 'admin') {
            header("Location: admin-dashboard.php");
        } else {
            header("Location: user-dashboard.php");
        }
        exit();
    } else {
        // Password salah
        header("Location: login-admin.php?error=password");
    }
} else {
    // Username tidak ditemukan
    header("Location: login-admin.php?error=username");
}
exit();
?>