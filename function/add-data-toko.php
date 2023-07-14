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

// Periksa apakah data toko telah dikirimkan
if (isset($_POST['add-data-toko'])) {
    // Ambil data dari form
    $nama_toko = $_POST['nama_toko'];
    $id_rute = $_POST['id_rute'];
    $alamat_toko = $_POST['alamat_toko'];
    $kontak_toko = $_POST['kontak_toko'];
    $latitude_toko = $_POST['latitude_toko'];
    $longitude_toko = $_POST['longitude_toko'];
    $link_gmaps = $_POST['link_gmaps'];
    $gambar_toko = $_POST['gambar_toko'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah rute penugasan valid
    $query_check_rute = "SELECT id_rute FROM tb_rute WHERE id_rute = '$id_rute'";
    $result_check_rute = $conn->query($query_check_rute);
    if ($result_check_rute->num_rows === 0) {
        echo "Rute tidak valid.";
        exit();
    }

    // Insert data penugasan
    $query_insert = "INSERT INTO tb_toko (nama_toko, id_rute, alamat_toko, kontak_toko, latitude_toko, longitude_toko, link_gmaps, gambar_toko) 
                     VALUES ('$nama_toko', '$id_rute', '$alamat_toko', '$kontak_toko', '$latitude_toko', '$longitude_toko', '$link_gmaps', '$gambar_toko')";

    if ($conn->query($query_insert) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/toko/toko.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data toko: " . $conn->connect_error;
    }

    $conn->close();
}
?>
