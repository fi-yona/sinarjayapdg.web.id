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

// Periksa apakah data toko telah dikirimkan
if (isset($_GET['id_toko'])) {
    // Ambil data dari form
    $id_toko = $_GET['id_toko'];

    // Lakukan proses penghapusan data
    require_once 'dbconfig.php';

    // Delete data
    $query_delete = "DELETE FROM tb_toko 
                     WHERE id_toko = '$id_toko'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/toko/toko.php?status=success-delete-toko");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data toko: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
