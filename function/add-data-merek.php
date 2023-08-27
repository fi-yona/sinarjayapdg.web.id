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
if (isset($_POST['add-data-merek'])) {
    // Ambil data dari form
    $id_manufaktur = $_POST['id_manufaktur'];
    $nama_merek = $_POST['nama_merek'];
    $website_merek = $_POST['website_merek'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah merek penugasan valid
    $query_check_manufaktur = "SELECT id_manufaktur FROM tb_manufaktur WHERE id_manufaktur = '$id_manufaktur'";
    $result_check_manufaktur = $conn->query($query_check_manufaktur);
    if ($result_check_manufaktur->num_rows === 0) {
        echo "Manufaktur tidak valid.";
        exit();
    }

    // Insert data penugasan
    $query_insert = "INSERT INTO tb_merek (id_manufaktur, nama_merek, website_merek) 
                     VALUES ('$id_manufaktur', '$nama_merek', '$website_merek')";

    if ($conn->query($query_insert) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/barang/merek.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data merek: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
