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
    $tanggal_absensi = $_GET['tanggal_absensi'];
    $username = $_GET['username'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $cekAbsensiQuery = "SELECT waktu_masuk, waktu_pulang FROM tb_absensi WHERE tanggal_absensi = '$tanggal_absensi' AND username = '$username'";
        $cekAbsensiResult = $conn->query($cekAbsensiQuery);
        
        if ($cekAbsensiResult->num_rows > 0) {
            $row = $cekAbsensiResult->fetch_assoc();
            $waktu_masuk = $row['waktu_masuk'];
            $waktu_pulang = $row['waktu_pulang'];

            if ($waktu_masuk == NULL && $waktu_pulang == NULL) {
                $status = "Masuk";
            } elseif ($waktu_masuk != NULL && $waktu_pulang == NULL) {
                $status = "Pulang";
            } elseif ($waktu_masuk != NULL && $waktu_pulang != NULL) {
                $status = "Selesai";
            }
        } else {
            $status = "Masuk";
        }

        $response = array('status' => $status);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
