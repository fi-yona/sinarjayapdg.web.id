<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../../../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

$id_status_konf = $_GET['id_status_konf'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_konf_pembayaran.id_pembayaran,
                tb_pembayaran.id_pesanan,
                tb_konf_pembayaran.status_konf,
                tb_karyawan.nama_lengkap,
                tb_konf_pembayaran.username,
                tb_konf_pembayaran.create_at
            FROM
                tb_konf_pembayaran
            INNER JOIN
                tb_pembayaran ON tb_konf_pembayaran.id_pembayaran = tb_pembayaran.id_pembayaran 
            INNER JOIN
                tb_karyawan ON tb_konf_pembayaran.username = tb_karyawan.username
            WHERE 
                id_status_konf = '$id_status_konf'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data konfirmasi pembayaran tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Konfirmasi Pembayaran</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
    </head>
    <body>
        <header>
            <center>
                <h1><img src="../../../assets/img/logo-horizontal.png" class="logo-header"></h1>
            </center>
            <nav class="nav-home">
                <ul class="nav-home-ul">
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../absensi/absensi.php">Absensi</a></li>
                    <li><a href="../kunjungan/kunjungan.php">Kunjungan</a></li>
                    <li><a href="./toko.php">Toko</a></li>
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="javascript:history.back()"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Konfirmasi Pembayaran
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Id Pembayaran</th>
                                <td> : </td>
                                <td><?php echo $row['id_pembayaran']; ?></td>
                            </tr>
                            <tr>
                                <th>Id Pesanan</th>
                                <td> : </td>
                                <td><?php echo $row['id_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal dan Waktu Konfirmasi</th>
                                <td> : </td>
                                <td><?php echo $row['create_at']; ?></td>
                            </tr>
                            <tr>
                                <th>Status Konfirmasi Pembayaran</th>
                                <td> : </td>
                                <td><?php echo $row['status_konf']; ?></td>
                            </tr>
                            <tr>
                                <th>Dikonfirmasi Oleh</th>
                                <td> : </td>
                                <td><?php echo $row['nama_lengkap'] . " (username: " . $row['username'] . ")"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href=""><button type="button" class="button-edit-data">Edit</button></a><a href=""><button type="button" class="button-hapus-data">Hapus</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>