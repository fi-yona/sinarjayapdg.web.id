<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk mendapatkan data toko (id, nama, alamat) berdasarkan id_rute
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_token = $_GET['get_token'];
    $id_toko = $_GET['id_toko'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $detailTokoQuery = "SELECT tb_rute.nama_rute, tb_toko.id_toko, tb_toko.nama_toko, tb_toko.kontak_toko, tb_toko.alamat_toko, tb_toko.link_gmaps FROM tb_rute JOIN tb_toko ON tb_rute.id_rute = tb_toko.id_rute WHERE tb_toko.id_toko = '$id_toko'";
        $detailTokoResult = $conn->query($detailTokoQuery);

        $rows = array();
        while ($row = $detailTokoResult->fetch_assoc()) {
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
