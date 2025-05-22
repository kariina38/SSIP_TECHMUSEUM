<?php
include 'db.php';

$username = $_POST['username'];
$raw_password = $_POST['password']; // Password belum di-hash
$hashed_password = password_hash($raw_password, PASSWORD_BCRYPT); // Enkripsi

// Hanya izinkan pendaftaran sebagai 'user' (bukan admin)
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Pendaftaran berhasil! <a href='login-user.php'>Login di sini</a>.";
} else {
    echo "Gagal mendaftar. Username mungkin sudah digunakan.";
}
?>