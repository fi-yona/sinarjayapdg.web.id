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

// Periksa apakah data menufaktur telah dikirimkan
if (isset($_POST['edit-data-manufaktur'])) {
    // Ambil data dari form
    $nama_manufaktur = $_POST['nama_manufaktur'];
    $alamat_manufaktur = $_POST['alamat_manufaktur'];
    $kontak_manufaktur = $_POST['kontak_manufaktur'];
    $email_manufaktur = $_POST['email_manufaktur'];
    $kode_pos_manufaktur = $_POST['kode_pos_manufaktur'];
    $negara_manufaktur = $_POST['negara_manufaktur'];
    $kota_manufaktur = $_POST['kota_manufaktur'];
    $website_manufaktur = $_POST['website_manufaktur'];

    // Mengambil tanggal dan waktu saat ini
    $dateTime = date('Y-m-d H:i:s');

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Update data 
    $id_manufaktur = $_GET['id_manufaktur'];
    $query_update = "UPDATE tb_manufaktur 
                     SET nama_manufaktur = '$nama_manufaktur', 
                         alamat_manufaktur = '$alamat_manufaktur', 
                         kontak_manufaktur = '$kontak_manufaktur', 
                         email_manufaktur = '$email_manufaktur',
                         kode_pos_manufaktur = '$kode_pos_manufaktur', 
                         negara_manufaktur = '$negara_manufaktur', 
                         kota_manufaktur = '$kota_manufaktur', 
                         website_manufaktur = '$website_manufaktur',
                         update_at = '$dateTime'
                     WHERE id_manufaktur = '$id_manufaktur'";

    if ($conn->query($query_update) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/barang/manufaktur.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data manufaktur: " . $conn->error;
    }

    $conn->close();
}
?>
