<?php

require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menerima data dari permintaan POST
$username = $_POST["username"];
$password = $_POST["password"];

// Mengecek keberadaan username dan password di tabel pengguna dengan prepared statements
$query = "SELECT * FROM tb_user WHERE username = ? AND password = ? AND status_akun = 'Aktif' AND role = 'Sales'";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Data pengguna ditemukan, login berhasil
    $response["success"] = true;
    $response["message"] = "Login berhasil";
} else {
    // Data pengguna tidak ditemukan, login gagal
    $response["success"] = false;
    $response["message"] = "Username atau password tidak valid";
}

// Menutup prepared statement dan koneksi database
$stmt->close();
$conn->close();

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);


?>