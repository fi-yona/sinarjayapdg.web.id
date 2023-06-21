<?php
// Pengaturan koneksi database
$server_name = "localhost";
$mysql_username = "root";
$mysql_password = "";
$db_name = "sjpdg";

// Membuat koneksi ke database
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
