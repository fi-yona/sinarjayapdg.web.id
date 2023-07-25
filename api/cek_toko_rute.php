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
    $username = $_GET['username'];
    $id_toko = $_GET['id_toko'];
    $dateNow = date('Y-m-d');

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $cekTokoRuteQuery = "SELECT
                                tb_penugasan.id_penugasan,
                                tb_penugasan.username_penugasan,
                                tb_penugasan.rute_penugasan,
                                tb_rute.nama_rute,
                                tb_toko.id_toko,
                                tb_toko.nama_toko
                            FROM 
                                tb_penugasan
                            INNER JOIN
                                tb_rute ON tb_penugasan.rute_penugasan = tb_rute.id_rute
                            INNER JOIN
                                tb_toko ON tb_toko.id_rute = tb_rute.id_rute
                            WHERE 
                                tb_penugasan.username_penugasan = '$username'
                            AND 
                                tb_penugasan.tanggal_penugasan = '$dateNow'
                            AND 
                                tb_toko.id_toko = '$id_toko'";
        $cekTokoRuteResult = $conn->query($cekTokoRuteQuery);

        $rows = array();
        while ($row = $cekTokoRuteResult->fetch_assoc()) {
            $rows[] = $row;
        }

        if (!empty($rows)) {
            $response['status'] = 'Ada Data';
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
