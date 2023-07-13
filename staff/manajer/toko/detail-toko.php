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

$id_toko = $_GET['id_toko'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
            tb_toko.id_toko,
            tb_toko.nama_toko,
            tb_rute.nama_rute,
            tb_toko.kontak_toko,
            tb_toko.alamat_toko,
            tb_toko.latitude_toko,
            tb_toko.longitude_toko,
            tb_toko.link_gmaps,
            tb_toko.gambar_toko
        FROM
            tb_toko
        JOIN
            tb_rute ON tb_toko.id_rute = tb_rute.id_rute
        WHERE id_toko = '$id_toko'";

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
        <title>Detail Toko</title>
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
                <a href="./toko.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Toko
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class="layout-img-barang">
                        <?php $gambar_toko = $row['gambar_toko'];
                            if($gambar_toko==NULL){
                                echo "(No Gambar)";
                            }else{
                                echo '<img src="'.$gambar_toko.'" alt="'.$row['nama_toko']." ".$row['nama_toko'].'" class="img-barang">';
                            } ?>
                    </div>
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Id Toko</th>
                                <td> : </td>
                                <td><?php echo $row['id_toko']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Toko</th>
                                <td> : </td>
                                <td><?php echo $row['nama_toko']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Rute</th>
                                <td> : </td>
                                <td><?php echo $row['nama_rute']; ?></td>
                            </tr>
                            <tr>
                                <th>Kontak </th>
                                <td> : </td>
                                <td><?php
                                    $kontak_toko = $row['kontak_toko'];
                                    if($kontak_toko==NULL){
                                        echo "(No Data)";
                                    }else{
                                        echo $kontak_toko;
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td> : </td>
                                <td><?php
                                    $alamat_toko = $row['alamat_toko'];
                                    if($alamat_toko==NULL){
                                        echo "(No Data)";
                                    }else{
                                        echo $alamat_toko;
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <th>Latitude</th>
                                <td> : </td>
                                <td><?php
                                    $latitude_toko = $row['latitude_toko'];
                                    if($latitude_toko==NULL){
                                        echo "(No Data)";
                                    }else{
                                        echo $latitude_toko;
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <th>Longitude</th>
                                <td> : </td>
                                <td><?php
                                    $longitude_toko = $row['longitude_toko'];
                                    if($longitude_toko==NULL){
                                        echo "(No Data)";
                                    }else{
                                        echo $longitude_toko;
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <th>Link GMaps</th>
                                <td> : </td>
                                <td><?php
                                    $link_gmaps = $row['link_gmaps'];
                                    if($link_gmaps==NULL){
                                        echo "(No Data)";
                                    }else{
                                        echo $link_gmaps;
                                    }
                                ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class = "layout-button-lihat-foto">
                        <center><a href=""><button type="button" class="button-lihat-foto">Lihat QR Code</button></a></center>
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