<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    if ($_SESSION['role'] !== 'Admin Kantor'){
        header("Location: ../staff/login.html");
        echo "Anda tidak memiliki akses ke halaman ini!";
        exit();
    }
}

// Periksa apakah data rute telah dikirimkan
if (isset($_POST['edit-data-rute'])) {
    // Ambil data dari form
    $nama_rute = $_POST['nama_rute'];
    $keterangan_rute = $_POST['keterangan_rute'];

    date_default_timezone_set('Asia/Jakarta');
    // Mengambil tanggal dan waktu saat ini
    $dateTime = date('Y-m-d H:i:s');

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Update data 
    $id_rute = $_GET['id_rute'];
    $query_update = "UPDATE tb_rute 
                     SET nama_rute = '$nama_rute', 
                         keterangan_rute = '$keterangan_rute',
                         update_at = '$dateTime'
                     WHERE id_rute = '$id_rute'";

    if ($conn->query($query_update) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/toko/rute.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data rute: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
