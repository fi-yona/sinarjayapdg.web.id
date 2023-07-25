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
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $rows = array();
        // Hitung total kunjungan hari ini
        $kunjunganHariIniQuery = "SELECT COUNT(*) as total_hari_ini FROM tb_kunjungan WHERE username = '$username' AND tanggal_kunjungan = '$tanggal_hari_ini'";
        $kunjunganHariIniResult = $conn->query($kunjunganHariIniQuery);
        if ($kunjunganHariIniResult) {
            $rowHariIni = $kunjunganHariIniResult->fetch_assoc();
            $status_total_hari_ini = "Berhasil";
            $total_kunjungan_hari_ini = $rowHariIni['total_hari_ini'];
        } else {
            $status_total_hari_ini = "Gagal";
            $total_kunjungan_hari_ini = 0;
        }
        // Hitung total kunjungan bulan ini
        $kunjunganBulanIniQuery = "SELECT COUNT(*) as total_bulan_ini FROM tb_kunjungan WHERE username = '$username' AND MONTH(tanggal_kunjungan) = '$bulan' AND YEAR(tanggal_kunjungan) = '$tahun'";
        $kunjunganBulanIniResult = $conn->query($kunjunganBulanIniQuery);
        if ($kunjunganBulanIniResult) {
            $rowBulanIni = $kunjunganBulanIniResult->fetch_assoc();
            $status_total_bulan_ini = "Berhasil";
            $total_kunjungan_bulan_ini = $rowBulanIni['total_bulan_ini'];
        } else {
            $status_total_bulan_ini = "Gagal";
            $total_kunjungan_bulan_ini = 0;
        }

        $row['status_total_hari_ini'] = $status_total_hari_ini;
        $row['status_total_bulan_ini'] = $status_total_bulan_ini;
        $row['total_kunjungan_hari_ini'] = $total_kunjungan_hari_ini;
        $row['total_kunjungan_bulan_ini'] = $total_kunjungan_bulan_ini;
        $rows[] = $row;
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
