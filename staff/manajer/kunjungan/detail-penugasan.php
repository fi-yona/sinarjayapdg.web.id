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

$id_penugasan = $_GET['id_penugasan'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_penugasan.tanggal_penugasan,
                tb_karyawan.nama_lengkap,
                tb_penugasan.username_penugasan,
                tb_rute.nama_rute,
                tb_penugasan.penanggung_jawab
            FROM
                tb_penugasan
            JOIN
                tb_karyawan ON tb_penugasan.username_penugasan = tb_karyawan.username
            JOIN
                tb_rute ON tb_penugasan.rute_penugasan = tb_rute.id_rute
            WHERE 
                id_penugasan = '$id_penugasan'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data toko tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Penugasan</title>
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
                    <li><a href="./kunjungan.php">Kunjungan</a></li>
                    <li><a href="../toko/toko.php">Toko</a></li>
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
                <a href="./penugasan.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Penugasan
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Tanggal Penugasan</th>
                                <td> : </td>
                                <td><?php echo $row['tanggal_penugasan']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td> : </td>
                                <td><?php echo $row['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <th>Username Sales</th>
                                <td> : </td>
                                <td><?php echo $row['username_penugasan']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Rute Penugasan </th>
                                <td> : </td>
                                <td><?php echo $row['nama_rute']; ?></td>
                            </tr>
                            <tr>
                                <th>Ditugaskan Oleh</th>
                                <td> : </td>
                                <td><?php echo $row['penanggung_jawab']; ?></td>
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