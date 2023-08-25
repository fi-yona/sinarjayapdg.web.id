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

$id_absensi = $_GET['id_absensi'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
            tb_absensi.id_absensi, 
            tb_karyawan.nama_lengkap, 
            tb_user.username, 
            tb_absensi.tanggal_absensi, 
            tb_absensi.waktu_masuk, 
            tb_absensi.latitude_masuk, 
            tb_absensi.longitude_masuk, 
            tb_absensi.lokasi_masuk, 
            tb_absensi.keterangan_masuk,
            tb_absensi.gambar_masuk, 
            tb_absensi.waktu_pulang, 
            tb_absensi.latitude_pulang, 
            tb_absensi.longitude_pulang, 
            tb_absensi.lokasi_pulang, 
            tb_absensi.keterangan_pulang,
            tb_absensi.gambar_pulang
          FROM 
            tb_absensi
          INNER JOIN 
            tb_karyawan ON tb_absensi.username = tb_karyawan.username
          INNER JOIN 
            tb_user ON tb_karyawan.username = tb_user.username
          WHERE 
            tb_absensi.id_absensi = '$id_absensi'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data absensi tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Absensi</title>
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
                    <li><a href="./absensi.php">Absensi</a></li>
                    <li><a href="../kunjungan/kunjungan.php">Kunjungan</a></li>
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
                <a href="./absensi.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Absensi
            </div>
            <div class = "detail-data-umum">
                <table class = "table-detail-data">
                    <tr>
                        <td>Id Absensi</td>
                        <td> : </td>
                        <?php 
                        echo "<td>".$id_absensi."</th>";
                        ?>
                    </tr>
                    <tr>
                        <td>Tanggal Absensi</td>
                        <td> : </td>
                        <td><?php echo $row['tanggal_absensi']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td> : </td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                    </tr>
                    <tr>
                        <td>Usename</td>
                        <td> : </td>
                        <td><?php echo $row['username']; ?></td>
                    </tr>
                </table>
            </div>
            <div class = "detail-data-absensi">
                <table class="table-layout-absensi">
                    <tr>
                        <td>
                            <div class="box-green">
                                <div class = "title-jenis-absensi">
                                    Masuk
                                </div>
                                <div class = "layout-table-absensi">
                                    <table class = "table-data-absensi">
                                        <tr>
                                            <th>Waktu</th>
                                            <td> : </td>
                                            <td><?php echo $row['waktu_masuk']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td> : </td>
                                            <td><?php echo $row['lokasi_masuk']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Latitude</th>
                                            <td> : </td>
                                            <td><?php echo $row['latitude_masuk']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td> : </td>
                                            <td><?php echo $row['longitude_masuk']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td> : </td>
                                            <td><?php echo $row['keterangan_masuk']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class = "layout-button-lihat-foto">
                                <a href="<?php echo $row['gambar_masuk']; ?>"><button type="button" class="button-lihat-foto">Lihat Foto</button></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="box-green">
                                <div class = "title-jenis-absensi">
                                    Pulang
                                </div>
                                <div class = "layout-table-absensi">
                                    <table class = "table-data-absensi">
                                        <tr>
                                            <th>Waktu</th>
                                            <td> : </td>
                                            <td><?php
                                                $waktu_pulang = $row['waktu_pulang'];
                                                if($waktu_pulang==NULL || $waktu_pulang=="00:00:00"){
                                                    echo "(No Data)";
                                                }else{
                                                    echo $waktu_pulang;
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td> : </td>
                                            <td><?php
                                                $lokasi_pulang = $row['lokasi_pulang'];
                                                if($lokasi_pulang==NULL){
                                                    echo "(No Data)";
                                                }else{
                                                    echo $lokasi_pulang;
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Latitude</th>
                                            <td> : </td>
                                            <td><?php
                                                $latitude_pulang = $row['latitude_pulang'];
                                                if($latitude_pulang==NULL){
                                                    echo "(No Data)";
                                                }else{
                                                    echo $latitude_pulang;
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td> : </td>
                                            <td><?php
                                                $longitude_pulang = $row['longitude_pulang'];
                                                if($longitude_pulang==NULL){
                                                    echo "(No Data)";
                                                }else{
                                                    echo $longitude_pulang;
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td> : </td>
                                            <td><?php
                                                $keterangan_pulang = $row['keterangan_pulang'];
                                                if($keterangan_pulang==NULL){
                                                    echo "(No Data)";
                                                }else{
                                                    echo $keterangan_pulang;
                                                }
                                            ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class = "layout-button-lihat-foto">
                                <a href="<?php echo $row['gambar_pulang']; ?>"><button type="button" class="button-lihat-foto">Lihat Foto</button></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class = "layout-button-data">
                <button type="button" class="button-hapus-data" onclick="hapusData(<?php echo $id_absensi; ?>)">Hapus</button>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-absensi.php?id_absensi=" + id;
                }
            }
        </script>
    </body>
</html>