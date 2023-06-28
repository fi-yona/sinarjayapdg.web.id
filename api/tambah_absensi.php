<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk mendapatkan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insert_token = $_POST['insert_token'];
    $status = $_POST['status'];
    $username = $_POST['username'];
    $tanggal_absensi = $_POST['tanggal_absensi'];
    $waktu_absensi = $_POST['waktu_absensi'];
    $latitude_absensi = $_POST['latitude_absensi'];
    $longitude_absensi = $_POST['longitude_absensi'];
    $lokasi_absensi = $_POST['lokasi_absensi'];
    $keterangan_absensi = $_POST['keterangan_absensi'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        if ($status == "Masuk") {
            $tambahAbsensiMasukQuery = "INSERT INTO tb_absensi(username, tanggal_absensi, waktu_masuk, latitude_masuk, longitude_masuk, lokasi_masuk, keterangan_masuk) VALUES ('$username','$tanggal_absensi','$waktu_absensi','$latitude_absensi','$longitude_absensi','$lokasi_absensi','$keterangan_absensi')";
            $tambahAbsensiMasukResult = $conn->query($tambahAbsensiMasukQuery);
            if ($tambahAbsensiMasukResult) {
                $response = array('status' => 'Berhasil');
                echo json_encode($response);
            } else {
                $response = array('status' => 'Gagal', 'error' => $conn->error);
                echo json_encode($response);
            }
        } elseif ($status == "Pulang") {
            $tambahAbsensiPulangQuery = "INSERT INTO tb_absensi(username, tanggal_absensi, waktu_pulang, latitude_pulang, longitude_pulang, lokasi_pulang, keterangan_pulang) VALUES ('$username','$tanggal_absensi','$waktu_absensi','$latitude_absensi','$longitude_absensi','$lokasi_absensi','$keterangan_absensi')";
            $tambahAbsensiPulangResult = $conn->query($tambahAbsensiPulangQuery);
            if ($tambahAbsensiPulangResult) {
                $response = array('status' => 'Berhasil');
                echo json_encode($response);
            } else {
                $response = array('status' => 'Gagal', 'error' => $conn->error);
                echo json_encode($response);
            }
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
