<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

// Periksa apakah data rute telah dikirimkan
if (isset($_POST['add-data-rute'])) {
    // Ambil data dari form
    $nama_rute = $_POST['nama_rute'];
    $keterangan_rute = $_POST['keterangan_rute'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';
    
    // Insert data rute
    $query_insert = "INSERT INTO tb_rute (nama_rute, keterangan_rute) 
                     VALUES ('$nama_rute', '$keterangan_rute')";

    if ($conn->query($query_insert) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/toko/rute.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data toko: " . $conn->error;
    }

    $conn->close();
}
?>
