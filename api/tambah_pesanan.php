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
    $id_toko = $_POST['id_toko'];
    $username = $_POST['username'];
    $tanggal_pesanan = $_POST['tanggal_pesanan'];
    $waktu_pesanan = $_POST['waktu_pesanan'];
    $total_harga_pesanan = $_POST['total_harga_pesanan'];
    $sisa_pembayaran_pesanan = $_POST['sisa_pembayaran_pesanan'];
    $status_bayar_pesanan = $_POST['status_bayar_pesanan'];
    $cara_penagihan = $_POST['cara_penagihan'];
    $jatuh_tempo = $_POST['jatuh_tempo'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahPesananQuery = "INSERT INTO tb_pesanan 
                                            (id_toko, 
                                            username, 
                                            tanggal_pesanan, 
                                            waktu_pesanan, 
                                            total_harga_pesanan, 
                                            sisa_pembayaran_pesanan,
                                            status_bayar_pesanan,
                                            cara_penagihan,
                                            jatuh_tempo) 
                                VALUES 
                                    ('$id_toko', 
                                    '$username', 
                                    '$tanggal_pesanan', 
                                    '$waktu_pesanan', 
                                    '$total_harga_pesanan', 
                                    '$sisa_pembayaran_pesanan', 
                                    '$status_bayar_pesanan',
                                    '$cara_penagihan',
                                    '$jatuh_tempo')";
        $tambahPesananResult = $conn->query($tambahPesananQuery);
        $id_pesanan = $conn->insert_id;

        if ($tambahPesananResult) {
            $response = array('id_pesanan' => $id_pesanan);
            echo json_encode($response);
        } else {
            $response = array('id_pesanan' => '0');
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
