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

$id_barang = $_GET['id_barang'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_barang.gambar_barang,
                tb_merek.nama_merek, 
                tb_barang.nama_barang, 
                tb_barang.banyak_barang, 
                tb_barang.harga_barang, 
                tb_barang.kode_bpom, 
                tb_barang.keterangan
            FROM 
                tb_barang
            INNER JOIN 
                tb_merek ON tb_barang.id_merek = tb_merek.id_merek
            WHERE 
                tb_barang.id_barang = '$id_barang'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . print_r($conn->errorInfo(), true));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data barang tidak ditemukan";
    exit();
}

// Ambil data barang
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Barang</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-img.css?v1.1">
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
                <a href="./barang.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Barang
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class="layout-img-barang">
                        <?php $gambar_barang = $row['gambar_barang'];
                            if($gambar_barang==NULL){
                                echo "(No Gambar)";
                            }else{
                                echo '<img src="'.$gambar_barang.'" alt="'.$row['nama_merek']." ".$row['nama_barang'].'" class="img-barang">';
                            } ?>
                    </div>
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Nama Merek</th>
                                <td> : </td>
                                <td><?php echo $row['nama_merek']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td> : </td>
                                <td><?php echo $row['nama_barang']; ?></td>
                            </tr>
                            <tr>
                                <th>Banyak Barang</th>
                                <td> : </td>
                                <td><?php echo number_format($row['banyak_barang'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Harga Barang</th>
                                <td> : </td>
                                <td><?php echo number_format($row['harga_barang'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Kode BPOM</th>
                                <td> : </td>
                                <td><?php 
                                        $kode_bpom = $row['kode_bpom'];
                                        if($kode_bpom==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $row['kode_bpom'];
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td> : </td>
                                <td><?php 
                                        $keterangan = $row['keterangan'];
                                        if($keterangan==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $row['keterangan'];
                                        } 
                                ?></td>
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