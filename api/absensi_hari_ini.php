<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk mendapatkan data 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_token = $_GET['get_token'];
    $username = $_GET['username'];
    $tanggal_absensi = $_GET['tanggal_absensi'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $absensiHariIniQuery = "SELECT waktu_masuk, lokasi_masuk, latitude_masuk, longitude_masuk, keterangan_masuk, waktu_pulang, lokasi_pulang, latitude_pulang, longitude_pulang, keterangan_pulang FROM tb_absensi WHERE tanggal_absensi = '$tanggal_absensi' AND username = '$username'";
        $absensiHariIniResult = $conn->query($absensiHariIniQuery);

        $rows = array();
        while ($row = $absensiHariIniResult->fetch_assoc()) {
            $rows[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($rows);
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
