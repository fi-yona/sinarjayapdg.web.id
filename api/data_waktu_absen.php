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
    $role = $_GET['role'];

    $tokenQuery = "SELECT * FROM token WHERE get_token = '$get_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $dataWaktuAbsenQuery = "SELECT 
                                    role,
                                    jam_masuk,
                                    awal_masuk,
                                    akhir_masuk,
                                    jam_pulang,
                                    awal_pulang,
                                    akhir_pulang
                                FROM
                                    waktu
                                WHERE
                                    role = '$role'";
        $dataWaktuAbsenResult = $conn->query($dataWaktuAbsenQuery);

        $rows = array();
        while ($row = $dataWaktuAbsenResult->fetch_assoc()) {
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
