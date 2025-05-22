<?php 
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password']; // Tidak di-hash

    // Gunakan prepared statement
    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt  = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect ke index.html jika berhasil
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
