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

// Periksa apakah data promo telah dikirimkan
if (isset($_GET['id_promo'])) {
    // Ambil data dari form
    $id_promo = $_GET['id_promo'];

    // Lakukan proses penghapusan data
    require_once 'dbconfig.php';

    // Delete data
    $query_delete_detail = "DELETE FROM tb_detail_promo 
                            WHERE id_promo = '$id_promo'";

    if ($conn->query($query_delete_detail) === true) {
        // Jika penghapusan berhasil
        $query_delete_promo = "DELETE FROM tb_promo 
                                WHERE id_promo = '$id_promo'";
        if ($conn->query($query_delete_promo) === true) {
            header("Location: ../staff/manajer/barang/promo.php?status=success-delete");
            exit();
        }else{
            // Jika terjadi kesalahan saat penghapusan
            echo "Terjadi kesalahan saat menghapus data promo: " . mysqli_error($conn);
        }
    } else {
        // Jika terjadi kesalahan saat penghapusan
        echo "Terjadi kesalahan saat menghapus data detail promo: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
