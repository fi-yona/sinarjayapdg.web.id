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
    $id_pesanan = $_GET['id_pesanan'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $detailBarangQuery = "SELECT 
                                    tb_detail_pesanan.id_dt_pesanan,
                                    tb_detai_pesanan.id_barang,
                                    tb_barang.nama_barang,
                                    tb_barang.kode_bpom,
                                    tb_barang.banyak_barang,
                                    tb_barang.harga_barang,
                                    tb_barang.keterangan
                                FROM
                                    tb_barang
                                INNER JOIN
                                    tb_merek ON tb_barang.id_merek = tb_merek.id_merek
                                WHERE
                                    tb_barang.id_barang = '$id_barang'";
        $detailBarangResult = $conn->query($detailBarangQuery);

        $rows = array();
        while ($row = $detailBarangResult->fetch_assoc()) {
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
