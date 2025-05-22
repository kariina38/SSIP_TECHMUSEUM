<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "techmuseum");
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

$sql = "SELECT quote, author FROM quotes WHERE status='approved' ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'quote' => $row['quote'],
        'author' => $row['author']
    ]);
} else {
    echo json_encode([
        'quote' => 'Hardships often prepare ordinary people for an extraordinary destiny.',
        'author' => 'C.S. Lewis'
    ]);
}

$conn->close();
?>