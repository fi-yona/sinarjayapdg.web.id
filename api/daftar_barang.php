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

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $daftarBarangQuery = "SELECT
                                tb_barang.id_barang,
                                tb_merek.nama_merek,
                                tb_barang.nama_barang,
                                tb_barang.banyak_barang,
                                tb_barang.harga_barang
                            FROM
                                tb_barang
                            JOIN
                                tb_merek ON tb_barang.id_merek = tb_merek.id_merek
                            WHERE 
                                tb_barang.banyak_barang > 0
                            ORDER BY
                                tb_merek.nama_merek ASC, tb_barang.nama_barang ASC";
        $daftarBarangResult = $conn->query($daftarBarangQuery);

        $rows = array();
        while ($row = $daftarBarangResult->fetch_assoc()) {
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
