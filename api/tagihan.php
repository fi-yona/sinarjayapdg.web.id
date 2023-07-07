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
    $id_toko = $_GET['id_toko'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tagihanQuery = "SELECT 
                            tb_pesanan.jatuh_tempo,
                            tb_pesanan.id_pesanan,
                            tb_toko.nama_toko,
                            tb_rute.nama_rute,
                            tb_karyawan.nama_lengkap,
                            tb_pesanan.username,
                            tb_pesanan.tanggal_pesanan,
                            tb_pesanan.total_harga_pesanan,
                            tb_pesanan.cara_penagihan,
                            tb_pesanan.sisa_pembayaran_pesanan
                        FROM 
                            tb_pesanan 
                        INNER JOIN
                            tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
                        INNER JOIN
                            tb_rute ON tb_toko.id_rute = tb_rute.id_rute
                        INNER JOIN 
                            tb_karyawan ON tb_pesanan.username = tb_karyawan.username
                        WHERE 
                            tb_pesanan.id_toko = '$id_toko' AND tb_pesanan.status_bayar_pesanan = 'Belum Lunas'";
        $tagihanResult = $conn->query($tagihanQuery);

        $rows = array();
        while ($row = $tagihanResult->fetch_assoc()) {
            $rows[] = $row;
        }

        if (!empty($rows)) {
            $response['status'] = 'Ada Data';
            $response['data'] = $rows;
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response['status'] = 'Tidak Ada Data';
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        //header('Content-Type: application/json');
        //echo json_encode($rows);
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
