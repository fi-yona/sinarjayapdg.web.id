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
    $username = $_POST['username'];
    $id_toko = $_POST['id_toko'];
    $latitude_kunjungan = $_POST['latitude_kunjungan'];
    $longitude_kunjungan = $_POST['longitude_kunjungan'];
    $lokasi_kunjungan = $_POST['lokasi_kunjungan'];
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $waktu_kunjungan = $_POST['waktu_kunjungan'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahKunjunganQuery = "INSERT INTO 
                                        tb_kunjungan 
                                        (username, 
                                        id_toko, 
                                        latitude_kunjungan, 
                                        longitude_kunjungan, 
                                        lokasi_kunjungan, 
                                        tanggal_kunjungan, 
                                        waktu_kunjungan) 
                                    VALUES 
                                        ('$username', 
                                        '$id_toko', 
                                        '$latitude_kunjungan', 
                                        '$longitude_kunjungan', 
                                        '$lokasi_kunjungan', 
                                        '$tanggal_kunjungan', 
                                        '$waktu_kunjungan')";
        $tambahKunjunganResult = $conn->query($tambahKunjunganQuery);

        if ($tambahKunjunganResult) {
            $response = array('status' => 'Berhasil');
            echo json_encode($response);
        } else {
            $response = array('status' => 'Gagal');
            echo json_encode($response);
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}
$conn->close();
?>
