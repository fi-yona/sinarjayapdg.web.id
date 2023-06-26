<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk mendapatkan data rute berdasarkan token, username, dan tanggal penugasan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get_token = $_GET['get_token'];
    $username = $_GET['username'];
    $tanggal_penugasan = $_GET['tanggal_penugasan'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $penugasanQuery = "SELECT tb_penugasan.rute_penugasan, tb_rute.nama_rute FROM tb_penugasan INNER JOIN tb_rute ON tb_penugasan.rute_penugasan = tb_rute.id_rute WHERE tb_penugasan.tanggal_penugasan = '$tanggal_penugasan' AND tb_penugasan.username_penugasan = '$username'";
        $penugasanResult = $conn->query($penugasanQuery);

        $rows = array();
        while ($row = $penugasanResult->fetch_assoc()) {
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
