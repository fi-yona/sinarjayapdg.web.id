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

// Periksa apakah data barang telah dikirimkan
if (isset($_POST['add-data-barang'])) {
    // Ambil data dari form
    $id_merek = $_POST['id_merek'];
    $nama_barang = $_POST['nama_barang'];
    $kode_bpom = $_POST['kode_bpom'];
    $banyak_barang = $_POST['banyak_barang'];
    $harga_barang = $_POST['harga_barang'];
    $gambar_barang = $_POST['gambar_barang'];
    $keterangan = $_POST['keterangan'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah merek penugasan valid
    $query_check_merek = "SELECT id_merek FROM tb_merek WHERE id_merek = '$id_merek'";
    $result_check_merek = $conn->query($query_check_merek);
    if ($result_check_merek->num_rows === 0) {
        echo "Merek tidak valid.";
        exit();
    }

    // Insert data penugasan
    $query_insert = "INSERT INTO tb_barang (id_merek, nama_barang, kode_bpom, banyak_barang, harga_barang, gambar_barang, keterangan) 
                     VALUES ('$id_merek', '$nama_barang', '$kode_bpom', '$banyak_barang', '$harga_barang', '$gambar_barang', '$keterangan')";

    if ($conn->query($query_insert) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/barang/barang.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data barang: " . mysqli_error($error);
    }

    $conn->close();
}
?>
