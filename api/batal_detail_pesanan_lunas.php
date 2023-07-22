<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_token = $_POST['delete_token'];
    $id_pesanan = $_POST['id_pesanan'];

    $tokenQuery = "SELECT * FROM token WHERE delete_token = '$delete_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $deleteDetailPesananQuery = "UPDATE tb_detail_pesanan 
                                        SET barang_lunas = '0',
                                            status_bayar = 'Belum Lunas'
                                        WHERE id_pesanan = '$id_pesanan'";
        $deleteDetailPesananResult = $conn->query($deleteDetailPesananQuery);
        if ($deleteDetailPesananResult) {
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
