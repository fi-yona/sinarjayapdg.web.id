<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if (($_SESSION['role'] !== 'Manajer') || ($_SESSION['role'] !== 'Admin Kantor')) {
    header("Location: ../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

require_once 'dbconfig.php';

$id_pembayaran = $_GET['id_pembayaran'];

// Query SQL
$sql = "SELECT 
            tb_konf_pembayaran.id_status_konf, 
            tb_konf_pembayaran.status_konf
        FROM
            tb_konf_pembayaran
        WHERE 
            id_pembayaran = '$id_pembayaran' AND status_konf = 'Terkonfirmasi'";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_status_konf = $row['id_status_konf'];
        echo "<a href='konf-pembayaran.php?id_status_konf=$id_status_konf'><button type='button' class='button-add-data'>Lihat Konfirmasi Pembayaran</button></a>";
    }
} else {
    // Jika query tidak mengembalikan hasil
    echo "<a href='add-konf-pembayaran.php?id_pembayaran=$id_pembayaran'><button type='button' class='button-add-data'>Tambah Konfirmasi Pembayaran</button></a>";
}
?>
