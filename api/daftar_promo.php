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
    $tanggal = $_GET['tanggal'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $daftarPromoQuery = "SELECT 
                                tb_promo.id_promo, 
                                tb_promo.nama_promo, 
                                tb_promo.bentuk_promo 
                            FROM 
                                `tb_promo` 
                            WHERE tb_promo.mulai_berlaku <= '$tanggal' AND tb_promo.akhir_berlaku >= '$tanggal' AND tb_promo.status_promo = 'Aktif'";
        $daftarPromoResult = $conn->query($daftarPromoQuery);

        $rows = array();
        while ($row = $daftarPromoResult->fetch_assoc()) {
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
