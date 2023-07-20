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
    $qris_invoiceid = $_POST['qris_invoiceid'];
    $id_pembayaran = $_POST['id_pembayaran'];
    $qris_request_date = $_POST['qris_request_date'];
    $qris_payment_customername = $_POST['qris_payment_customername'];
    $qris_payment_methodby = $_POST['qris_payment_methodby'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahTransaksiQrisQuery = "INSERT INTO tb_tr_qris 
                                            (qris_invoiceid, 
                                            id_pembayaran, 
                                            qris_request_date, 
                                            qris_payment_customername, 
                                            qris_payment_methodby) 
                                VALUES 
                                    ('$qris_invoiceid', 
                                    '$id_pembayaran', 
                                    '$qris_request_date', 
                                    '$qris_payment_customername', 
                                    '$qris_payment_methodby')";
        $tambahTransaksiQrisResult = $conn->query($tambahTransaksiQrisQuery);

        if ($tambahTransaksiQrisResult) {
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
