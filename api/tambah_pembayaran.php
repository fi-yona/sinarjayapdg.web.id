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
    $id_pesanan = $_POST['id_pesanan'];
    $username = $_POST['username'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $waktu_pembayaran = $_POST['waktu_pembayaran'];
    $jumlah_pembayaran = $_POST['jumlah_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahPembayaranQuery = "INSERT INTO tb_pembayaran 
                                            (id_pesanan, 
                                            username, 
                                            tanggal_pembayaran, 
                                            waktu_pembayaran, 
                                            jumlah_pembayaran, 
                                            metode_pembayaran) 
                                VALUES 
                                    ('$id_pesanan', 
                                    '$username', 
                                    '$tanggal_pembayaran', 
                                    '$waktu_pembayaran', 
                                    '$jumlah_pembayaran', 
                                    '$metode_pembayaran')";
        $tambahPembayaranResult = $conn->query($tambahPembayaranQuery);
        $id_pembayaran = $conn->insert_id;

        if ($tambahPembayaranResult) {
            $response = array('id_pembayaran' => $id_pembayaran);
            echo json_encode($response);
        } else {
            $response = array('id_pembayaran' => '0');
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
