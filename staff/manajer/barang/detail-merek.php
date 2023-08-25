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

$id_merek = $_GET['id_merek'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_merek.nama_merek,
                tb_manufaktur.nama_manufaktur,
                tb_merek.website_merek
            FROM
                tb_merek
            JOIN
                tb_manufaktur ON tb_merek.id_manufaktur = tb_manufaktur.id_manufaktur
            WHERE 
                tb_merek.id_merek = '$id_merek'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->connect_error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data merek tidak ditemukan";
    exit();
}

// Ambil data barang
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Merek</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v3">
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
                <a href="javascript:history.back()"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Merek
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Nama Merek</th>
                                <td> : </td>
                                <td><?php echo $row['nama_merek']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Manufaktur</th>
                                <td> : </td>
                                <td><?php echo $row['nama_manufaktur']; ?></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td> : </td>
                                <td><?php 
                                        $website = $row['website_merek'];
                                        if($website==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $website;
                                        } 
                                ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="edit-merek.php?id_merek=<?php echo $id_merek; ?>"><button type="button" class="button-edit-data">Edit</button></a><button type="button" class="button-hapus-data" onclick="hapusData(<?php echo $id_merek; ?>)">Hapus</button>
            </div>
            <hr>
            <div class = "sub-title-page">
                Data Barang Merek <?php echo $row['nama_merek']?>
            </div>
            <div class = "search-result">
                <?php require_once '../../../function/data-barang-merek.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-merek.php?id_merek=" + id;
                }
            }
        </script>
    </body>
</html>