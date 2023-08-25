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

// Set zona waktu sesuai dengan lokasi
date_default_timezone_set('Asia/Jakarta');

// Mendapatkan tanggal dan waktu saat ini
$currentDate = date('Y-m-d H:i:s'); 

// Periksa apakah data barang telah dikirimkan
if (isset($_POST['add-data-konf-pembayaran'])) {
    // Ambil data dari form
    $username = $_SESSION['username'];
    $status_konf = $_POST['status_konf'];
    $id_pembayaran = $_GET['id_pembayaran'];

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    $query_cek = "SELECT * FROM tb_konf_pembayaran WHERE id_pembayaran = $id_pembayaran AND status_konf = 'Belum Terkonfirmasi'";
    $result_check = $conn->query($query_cek);
    if ($result_check->num_rows > 0) {
        $query_update = "UPDATE tb_konf_pembayaran 
                            SET status_konf = 'Terkonfirmasi',
                                create_at = '$currentDate'
                            WHERE id_pembayaran = '$id_pembayaran'";

        if ($conn->query($query_update) === true) {
            // Jika penyimpanan berhasil
            header("Location: ../staff/manajer/riwayat-pembayaran/detail-pembayaran.php?id_pembayaran=$id_pembayaran&status=success");
            exit();
        } else {
            // Jika terjadi kesalahan saat penyimpanan
            echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        }
    }else{
        $query = "INSERT INTO tb_konf_pembayaran (id_pembayaran, username, status_konf) 
                    VALUES ('$id_pembayaran', '$username', '$status_konf')";

        if ($conn->query($query) === true) {
            // Jika penyimpanan berhasil
            header("Location: ../staff/manajer/riwayat-pembayaran/detail-pembayaran.php?id_pembayaran=$id_pembayaran&status=success");
            exit();
        } else {
            // Jika terjadi kesalahan saat penyimpanan
            echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        }
    }    

    $conn->close();
}
?>
