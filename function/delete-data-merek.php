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

// Periksa apakah data merek telah dikirimkan
if (isset($_GET['id_merek'])) {
    // Ambil data dari form
    $id_merek = $_GET['id_merek'];

    // Lakukan proses penghapusan data ke database
    require_once 'dbconfig.php';

    // Delete data penugasan
    $query_delete = "DELETE FROM tb_merek 
                     WHERE id_merek = '$id_merek'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/barang/merek.php?status=success-delete");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data merek: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
