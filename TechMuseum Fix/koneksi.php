<?php
$host = "localhost";
$user = "root";      // sesuaikan dengan username MySQL Anda
$pass = "";          // sesuaikan dengan password MySQL Anda
$db   = "techmuseum";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
