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
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_barang = $_POST['id_barang'];
    $banyak_barang_bayar = $_POST['banyak_barang_bayar'];
    $harga_barang = $_POST['harga_barang'];
    $total_harga_barang = $_POST['total_harga_barang'];

    $id_pesanan = $_POST['id_pesanan'];
    date_default_timezone_set('Asia/Jakarta');
    $dateTime = date('Y-m-d H:i:s');

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahDetailPembayaranQuery = "INSERT INTO tb_detail_pembayaran 
                                            (id_pembayaran, 
                                            id_barang, 
                                            banyak_barang, 
                                            harga_barang, 
                                            total_harga_barang) 
                                VALUES 
                                    ('$id_pembayaran', 
                                    '$id_barang', 
                                    '$banyak_barang_bayar', 
                                    '$harga_barang', 
                                    '$total_harga_barang')";
        $tambahDetailPembayaranResult = $conn->query($tambahDetailPembayaranQuery);
        
        if ($tambahDetailPembayaranResult) {
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
