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
    $nama_toko = $_POST['nama_toko'];
    $id_rute = $_POST['id_rute'];
    $alamat_toko = $_POST['alamat_toko'];
    $kontak_toko = $_POST['kontak_toko'];
    $link_gmaps = $_POST['link_gmaps'];
    $latitude_toko = $_POST['latitude_toko'];
    $longitude_toko = $_POST['longitude_toko'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahTokoQuery = "INSERT INTO tb_toko (nama_toko, id_rute, alamat_toko, kontak_toko, latitude_toko, longitude_toko, link_gmaps) VALUES ('$nama_toko', '$id_rute', '$alamat_toko', '$kontak_toko', '$latitude_toko', '$longitude_toko', '$link_gmaps')";
        $tambahTokoResult = $conn->query($tambahTokoQuery);

        if ($tambahTokoResult) {
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
