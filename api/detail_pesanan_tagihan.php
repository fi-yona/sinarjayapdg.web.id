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
        $dataPesananQuery = "SELECT 
                                    tb_pesanan.tanggal_pesanan,
                                    tb_pesanan.waktu_pesanan,
                                    tb_pesanan.id_toko,
                                    tb_toko.nama_toko,
                                    tb_pesanan.cara_penagihan,
                                    tb_pesanan.jatuh_tempo,
                                    tb_pesanan.total_harga_pesanan,
                                    tb_pesanan.status_bayar_pesanan,
                                    tb_pesanan.sisa_pembayaran_pesanan
                                FROM
                                    tb_pesanan
                                INNER JOIN
                                    tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
                                WHERE
                                tb_pesanan.id_pesanan = '$id_pesanan'";
        $dataPesananResult = $conn->query($dataPesananQuery);

        $rows = array();
        while ($row = $dataPesananResult->fetch_assoc()) {
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
