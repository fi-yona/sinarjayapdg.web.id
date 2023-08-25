<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
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

$id_kunjungan = $_GET['id_kunjungan'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_karyawan.nama_lengkap,
                tb_kunjungan.username,
                tb_kunjungan.tanggal_kunjungan,
                tb_kunjungan.waktu_kunjungan,
                tb_toko.nama_toko,
                tb_kunjungan.latitude_kunjungan,
                tb_kunjungan.longitude_kunjungan,
                tb_kunjungan.lokasi_kunjungan
            FROM
                tb_kunjungan
            JOIN
                tb_karyawan ON tb_kunjungan.username = tb_karyawan.username
            JOIN
                tb_toko ON tb_kunjungan.id_toko = tb_toko.id_toko
            WHERE 
                id_kunjungan = '$id_kunjungan'";

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
        <title>Detail Kunjungan</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.1">
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
                <a href="./kunjungan.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Kunjungan
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td> : </td>
                                <td><?php echo $row['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td> : </td>
                                <td><?php echo $row['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Kunjungan</th>
                                <td> : </td>
                                <td><?php echo $row['tanggal_kunjungan']; ?></td>
                            </tr>
                            <tr>
                                <th>Waktu Kunjungan</th>
                                <td> : </td>
                                <td><?php echo $row['waktu_kunjungan']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Toko</th>
                                <td> : </td>
                                <td><?php echo $row['nama_toko']; ?></td>
                            </tr>
                            <tr>
                                <th>Latitude Kunjungan</th>
                                <td> : </td>
                                <td><?php echo $row['latitude_kunjungan']; ?></td>
                            </tr>
                            <tr>
                                <th>Longitude Kunjungan</th>
                                <td> : </td>
                                <td><?php echo $row['longitude_kunjungan']; ?></td>
                            </tr>
                            <tr>
                                <th>Lokasi Kunjungan</th>
                                <td> : </td>
                                <td><?php echo $row['lokasi_kunjungan']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <button type="button" class="button-hapus-data" onclick="hapusData(<?php echo $id_kunjungan; ?>)">Hapus</button>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-kunjungan.php?id_kunjungan=" + id;
                }
            }
        </script>
    </body>
</html>