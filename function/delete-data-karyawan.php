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

if (isset($_GET['id_karyawan'])) {
    // Ambil data dari form
    $id_karyawan = $_GET['id_karyawan'];

    // Lakukan proses penghapusan data
    require_once 'dbconfig.php';

    // Delete data
    $query_delete = "DELETE FROM tb_karyawan 
                     WHERE id_karyawan = '$id_karyawan'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/karyawan/karyawan.php?status=success-delete-toko");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data karyawan: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
