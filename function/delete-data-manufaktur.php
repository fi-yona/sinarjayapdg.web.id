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

// Periksa apakah data manufaktur telah dikirimkan
if (isset($_GET['id_manufaktur'])) {
    // Ambil data dari form
    $id_manufaktur = $_GET['id_manufaktur'];

    // Lakukan proses penghapusan data
    require_once 'dbconfig.php';

    // Delete data
    $query_delete = "DELETE FROM tb_manufaktur 
                     WHERE id_manufaktur = '$id_manufaktur'";

    if ($conn->query($query_delete) === true) {
        // Jika penghapusan berhasil
        header("Location: ../staff/manajer/barang/manufaktur.php?status=success-delete");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data manufaktur: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
