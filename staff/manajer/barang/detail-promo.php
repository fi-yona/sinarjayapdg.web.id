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

$id_promo = $_GET['id_promo'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_promo.nama_promo,
                tb_promo.bentuk_promo,
                tb_promo.mulai_berlaku,
                tb_promo.akhir_berlaku,
                tb_promo.status_promo,
                tb_promo.keterangan
            FROM 
                tb_promo
            WHERE 
                id_promo = '$id_promo'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data promo tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Promo</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
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
                    <li><a href="./barang.php">Barang</a></li>
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
                Detail Promo
            </div>
            <div class = "detail-data">
                <div class="box-white">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Nama Promo</th>
                                <td> : </td>
                                <td><?php echo $row['nama_promo']; ?></td>
                            </tr>
                            <tr>
                                <th>Kategori Promo</th>
                                <td> : </td>
                                <td><?php echo $row['bentuk_promo']; ?></td>
                            </tr>
                            <tr>
                                <th>Mulai Berlaku</th>
                                <td> : </td>
                                <td><?php echo $row['mulai_berlaku']; ?></td>
                            </tr>
                            <tr>
                                <th>Akhir Berlaku</th>
                                <td> : </td>
                                <td><?php echo $row['akhir_berlaku']; ?></td>
                            </tr>
                            <tr>
                                <th>Status Promo</th>
                                <td> : </td>
                                <td><?php echo $row['status_promo']; ?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td> : </td>
                                <td><?php echo $row['keterangan']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- data detail barang promo -->
            <div class = "search-result">
                <?php require_once '../../../function/data-detail-barang-promo.php'; ?>
            </div>
            <div class = "layout-button-data">
                <a href=""><button type="button" class="button-edit-data">Edit</button></a><a href=""><button type="button" class="button-hapus-data">Hapus</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>