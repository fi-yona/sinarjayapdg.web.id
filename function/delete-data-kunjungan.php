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

// Periksa apakah data kunjungan telah dikirimkan
if (isset($_GET['id_kunjungan'])) {
    // Ambil data dari form
    $id_kunjungan = $_GET['id_kunjungan'];

    // Lakukan proses penghapusan data
    require_once 'dbconfig.php';

    // Delete data
    $query_delete = "DELETE FROM tb_kunjungan 
                     WHERE id_kunjungan = '$id_kunjungan'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/kunjungan/kunjungan.php?status=success-delete");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data kunjungan: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
