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

$id_pesanan = $_GET['id_pesanan'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_pesanan.tanggal_pesanan,
                tb_pesanan.waktu_pesanan,
                tb_karyawan.nama_lengkap,
                tb_pesanan.username,
                tb_toko.nama_toko,
                tb_pesanan.total_harga_pesanan,
                tb_pesanan.sisa_pembayaran_pesanan,
                tb_pesanan.status_bayar_pesanan,
                tb_pesanan.cara_penagihan,
                tb_pesanan.jatuh_tempo
            FROM 
                tb_pesanan
            INNER JOIN
                tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
            INNER JOIN
                tb_karyawan ON tb_pesanan.username = tb_karyawan.username
            WHERE 
                id_pesanan = '$id_pesanan'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . print_r($conn->errorInfo(), true));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data toko tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Pesanan</title>
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
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="./riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="./riwayat-pesanan.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Pesanan
            </div>
            <div class = "detail-data">
                <div class="box-white">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Id Pesanan</th>
                                <td> : </td>
                                <td><?php echo $id_pesanan; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Pesanan</th>
                                <td> : </td>
                                <td><?php echo $row['tanggal_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Waktu Pesanan</th>
                                <td> : </td>
                                <td><?php echo $row['waktu_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Sales</th>
                                <td> : </td>
                                <td><?php echo $row['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <th>Username Sales</th>
                                <td> : </td>
                                <td><?php echo $row['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Toko</th>
                                <td> : </td>
                                <td><?php echo $row['nama_toko']; ?></td>
                            </tr>
                            <tr>
                                <th>Total Harga Pesanan</th>
                                <td> : </td>
                                <td><?php echo number_format($row['total_harga_pesanan'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Sisa Pembayaran</th>
                                <td> : </td>
                                <td><?php echo number_format($row['sisa_pembayaran_pesanan'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Status Bayar</th>
                                <td> : </td>
                                <td><?php echo $row['status_bayar_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Cara Penagihan</th>
                                <td> : </td>
                                <td><?php echo $row['cara_penagihan']; ?></td>
                            </tr>
                            <tr>
                                <th>Jatuh Tempo</th>
                                <td> : </td>
                                <td><?php echo $row['jatuh_tempo']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- data detail barang pesanan -->
            <div class = "search-result">
                <?php require_once '../../../function/data-detail-barang-pesanan.php'; ?>
            </div>
            <div class = "layout-button-data">
                <a href=""><button type="button" class="button-hapus-data">Hapus</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>