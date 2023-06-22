<?php

require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mendefinisikan endpoint untuk API
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mengambil data dari tabel tb_kantor
    $sql = "SELECT latitude_kantor, longitude_kantor FROM tb_kantor";
    $result = $conn->query($sql);

    // Memeriksa apakah ada data yang ditemukan
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            // Menambahkan data ke array
            $data[] = array(
                'latitude_kantor' => $row['latitude_kantor'],
                'longitude_kantor' => $row['longitude_kantor']
            );
        }

        // Mengubah array ke format JSON
        $response = json_encode($data);
        echo $response;
    } else {
        echo "Tidak ada data kantor yang ditemukan.";
    }
} else {
    echo "Metode HTTP yang diterima harus GET.";
}

// Menutup koneksi database
$conn->close();

?>