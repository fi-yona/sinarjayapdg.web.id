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

// Dapatkan username dari session
$username = $_SESSION['username'];

// Periksa apakah data penugasan telah dikirimkan
if (isset($_POST['add-data-penugasan'])) {
    // Ambil data dari form
    $tanggal_penugasan = $_POST['tanggal_penugasan'];
    $username_penugasan = $_POST['username_penugasan'];
    $rute_penugasan = $_POST['rute_penugasan'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah username penugasan valid
    $query_check_username = "SELECT username FROM tb_user WHERE username = '$username_penugasan'";
    $result_check_username = $conn->query($query_check_username);
    if ($result_check_username->num_rows === 0) {
        echo "Username penugasan tidak valid. Username: ".$username_penugasan;
        exit();
    }

    // Periksa apakah rute penugasan valid
    $query_check_rute = "SELECT id_rute FROM tb_rute WHERE id_rute = '$rute_penugasan'";
    $result_check_rute = $conn->query($query_check_rute);
    if ($result_check_rute->num_rows === 0) {
        echo "Rute penugasan tidak valid.";
        exit();
    }

    // Insert data penugasan
    $query_insert = "INSERT INTO tb_penugasan (tanggal_penugasan, username_penugasan, rute_penugasan, penanggung_jawab) 
                     VALUES ('$tanggal_penugasan', '$username_penugasan', '$rute_penugasan', '$username')";

    if ($conn->query($query_insert) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/manajer/kunjungan/penugasan.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data penugasan: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
