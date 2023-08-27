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
    $update_token = $_POST['update_token'];
    $id_pesanan = $_POST['id_pesanan'];
    $jatuh_tempo = $_POST['jatuh_tempo'];
    date_default_timezone_set('Asia/Jakarta');
    $dateTime = date('Y-m-d H:i:s');

    $tokenQuery = "SELECT * FROM token WHERE update_token = '$update_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $updatePesananQuery = "UPDATE tb_pesanan 
                                        SET jatuh_tempo = '$jatuh_tempo',
                                            update_at = '$dateTime'
                                        WHERE id_pesanan = '$id_pesanan'";
        $updatePesananResult = $conn->query($updatePesananQuery);
        if($updatePesananResult){
            $response = array('status' => 'Berhasil');
            echo json_encode($response);
        }else{
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
