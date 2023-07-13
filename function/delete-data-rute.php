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
if (isset($_GET['id_rute'])) {
    // Ambil data dari form
    $id_rute = $_GET['id_rute'];

    // Lakukan proses penghapusan data ke database
    require_once 'dbconfig.php';

    // Delete data penugasan
    $query_delete = "DELETE FROM tb_rute 
                     WHERE id_rute = '$id_rute'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/toko/rute.php?status=success-delete");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data rute: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
