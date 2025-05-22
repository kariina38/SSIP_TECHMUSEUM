<?php
session_start();
include 'db.php';

// Validasi input
$name = $_POST['name'];
$rating = intval($_POST['rating']);
$review = $_POST['review'];
$status = 'pending'; // Status default

// Upload gambar
$target_dir = "uploads/testimonials/";
$image = basename($_FILES["image"]["name"]);
$target_file = $target_dir . uniqid() . "_" . $image;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    // Simpan ke database dengan status pending
    $stmt = $conn->prepare("INSERT INTO testimonials (name, image, review, rating, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $target_file, $review, $rating, $status);
    
    if ($stmt->execute()) {
        header("Location: index.php?review_submitted=1");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error uploading image.";
}
?>