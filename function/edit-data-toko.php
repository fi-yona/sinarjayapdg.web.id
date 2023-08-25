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
if (isset($_POST['edit-data-toko'])) {
    // Ambil data dari form
    $nama_toko = $_POST['nama_toko'];
    $id_rute = $_POST['id_rute'];
    $alamat_toko = $_POST['alamat_toko'];
    $kontak_toko = $_POST['kontak_toko'];
    $latitude_toko = $_POST['latitude_toko'];
    $longitude_toko = $_POST['longitude_toko'];
    $link_gmaps = $_POST['link_gmaps'];
    $gambar_toko = $_POST['gambar_toko'];

    // Mengambil tanggal dan waktu saat ini
    $dateTime = date('Y-m-d H:i:s');

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah rute valid
    $query_check_rute = "SELECT id_rute FROM tb_rute WHERE id_rute = '$id_rute'";
    $result_check_rute = $conn->query($query_check_rute);
    if ($result_check_rute->num_rows === 0) {
        echo "Rute tidak valid.";
        exit();
    }

    // Update data 
    $id_toko = $_GET['id_toko'];
    $query_update = "UPDATE tb_toko 
                     SET nama_toko = '$nama_toko', 
                         id_rute = '$id_rute', 
                         alamat_toko = '$alamat_toko', 
                         kontak_toko = '$kontak_toko',
                         latitude_toko = '$latitude_toko', 
                         longitude_toko = '$longitude_toko', 
                         link_gmaps = '$link_gmaps', 
                         gambar_toko = '$gambar_toko',
                         update_at = '$dateTime'
                     WHERE id_toko = '$id_toko'";

    if ($conn->query($query_update) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/toko/toko.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data toko: " . $conn->error;
    }

    $conn->close();
}
?>
