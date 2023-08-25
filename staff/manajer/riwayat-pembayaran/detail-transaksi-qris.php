<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

$qris_invoiceid = $_GET['qris_invoiceid'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                id_pembayaran,
                qris_request_date,
                qris_payment_customername, 
                qris_payment_methodby
            FROM 
                tb_tr_qris
            WHERE 
                qris_invoiceid = '$qris_invoiceid'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data transaksi QRIS tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Transaksi QRIS</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.2">
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
                    <li><a href="../toko/toko.php">Toko</a></li>
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="./riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
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
                Detail Transaksi QRIS
            </div>
            <div class = "detail-data">
                <div class="box-white">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>No Invoice QRIS</th>
                                <td> : </td>
                                <td><?php echo $qris_invoiceid; ?></td>
                            </tr>
                            <tr>
                                <th>Id Pembayaran</th>
                                <td> : </td>
                                <td><?php echo $row['id_pembayaran']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Request QRIS</th>
                                <td> : </td>
                                <td><?php echo $row['qris_request_date']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Akun Customer QRIS</th>
                                <td> : </td>
                                <td><?php echo $row['qris_payment_customername']; ?></td>
                            </tr>
                            <tr>
                                <th>Bank/Dompet Digital</th>
                                <td> : </td>
                                <td><?php echo $row['qris_payment_methodby']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>