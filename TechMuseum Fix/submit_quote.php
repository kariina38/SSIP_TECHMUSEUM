<?php
header('Content-Type: application/json');

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "techmuseum";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed']);
    exit;
}

// Ambil data dari POST
$quote = $_POST['quote'] ?? '';
$author = $_POST['author'] ?? 'Unknown';

if (trim($quote) === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Quote is required']);
    exit;
}

// Simpan ke database dengan status pending
$stmt = $conn->prepare("INSERT INTO quotes (quote, author, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("ss", $quote, $author);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

$stmt->close();
$conn->close();
?>