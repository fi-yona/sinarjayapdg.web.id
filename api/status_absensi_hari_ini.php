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
    $tanggal_hari_ini = $_GET['tanggal_hari_ini'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $statusAbsensiQuery = "SELECT keterangan_masuk, keterangan_pulang FROM tb_absensi WHERE username = '$username' AND tanggal_absensi = '$tanggal_hari_ini'";
        $statusAbsensiResult = $conn->query($statusAbsensiQuery);

        if ($statusAbsensiResult->num_rows > 0) {
            $row = $statusAbsensiResult->fetch_assoc();
            $keterangan_masuk = $row['keterangan_masuk'];
            $keterangan_pulang = $row['keterangan_pulang'];

            $response = array();

            if (empty($keterangan_masuk) && empty($keterangan_pulang)) {
                $response['keterangan_masuk'] = '(No Data)';
                $response['keterangan_pulang'] = '(No Data)';
            } elseif (!empty($keterangan_masuk) && empty($keterangan_pulang)) {
                $response['keterangan_masuk'] = $keterangan_masuk;
                $response['keterangan_pulang'] = '(No Data)';
            } else {
                $response['keterangan_masuk'] = $keterangan_masuk;
                $response['keterangan_pulang'] = $keterangan_pulang;
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            header('Content-Type: application/json');
            $response = array('keterangan_masuk' => '(No Data)', 'keterangan_pulang' => '(No Data)');
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
