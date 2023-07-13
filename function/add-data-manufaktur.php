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

// Periksa apakah data manufaktur telah dikirimkan
if (isset($_POST['add-data-manufaktur'])) {
    // Ambil data dari form
    $nama_manufaktur = $_POST['nama_manufaktur'];
    $alamat_manufaktur = $_POST['alamat_manufaktur'];
    $kontak_manufaktur = $_POST['kontak_manufaktur'];
    $email_manufaktur = $_POST['email_manufaktur'];
    $kode_pos_manufaktur = $_POST['kode_pos_manufaktur'];
    $negara_manufaktur = $_POST['negara_manufaktur'];
    $kota_manufaktur = $_POST['kota_manufaktur'];
    $website_manufaktur = $_POST['website_manufaktur'];

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';
    
    // Insert data 
    $query_insert = "INSERT INTO tb_manufaktur (nama_manufaktur, alamat_manufaktur, kontak_manufaktur, email_manufaktur, kode_pos_manufaktur, negara_manufaktur, kota_manufaktur, website_manufaktur) 
                     VALUES ('$nama_manufaktur', '$alamat_manufaktur', '$kontak_manufaktur', '$email_manufaktur', '$kode_pos_manufaktur', '$negara_manufaktur', '$kota_manufaktur', '$website_manufaktur')";

    if ($conn->query($query_insert) === true) {
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
