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

$id_manufaktur = $_GET['id_manufaktur'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_manufaktur.nama_manufaktur,
                tb_manufaktur.kontak_manufaktur,
                tb_manufaktur.email_manufaktur,
                tb_manufaktur.alamat_manufaktur,
                tb_manufaktur.kode_pos_manufaktur,
                tb_manufaktur.kota_manufaktur,
                tb_manufaktur.negara_manufaktur,
                tb_manufaktur.website_manufaktur,
                tb_manufaktur.keterangan
            FROM 
                tb_manufaktur
            WHERE 
                tb_manufaktur.id_manufaktur = '$id_manufaktur'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->connect_error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data manufaktur tidak ditemukan";
    exit();
}

// Ambil data barang
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Manufaktur</title>
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
                <a href="./manufaktur.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Manufaktur
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Nama Manufaktur</th>
                                <td> : </td>
                                <td><?php echo $row['nama_manufaktur']; ?></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td> : </td>
                                <td><?php 
                                        $kontak = $row['kontak_manufaktur'];
                                        if($kontak==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $kontak;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td> : </td>
                                <td><?php 
                                        $email = $row['email_manufaktur'];
                                        if($email==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $email;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td> : </td>
                                <td><?php 
                                        $alamat = $row['alamat_manufaktur'];
                                        if($alamat==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $alamat;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td> : </td>
                                <td><?php 
                                        $kode_pos = $row['kode_pos_manufaktur'];
                                        if($kode_pos==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $kode_pos;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td> : </td>
                                <td><?php 
                                        $kota = $row['kota_manufaktur'];
                                        if($kota==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $kota;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Negara</th>
                                <td> : </td>
                                <td><?php 
                                        $negara = $row['negara_manufaktur'];
                                        if($negara==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $negara;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td> : </td>
                                <td><?php 
                                        $website = $row['website_manufaktur'];
                                        if($website==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $website;
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
                                            echo $keterangan;
                                        } 
                                ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="edit-manufaktur.php?id_manufaktur=<?php echo $id_manufaktur; ?>"><button type="button" class="button-edit-data">Edit</button></a><button type="button" class="button-hapus-data" onclick="hapusData(<?php echo $id_manufaktur; ?>)">Hapus</button>
            </div>
            <hr>
            <div class = "sub-title-page">
                Data Merek pada Manufaktur <?php echo $row['nama_manufaktur']?>
            </div>
            <div class = "search-result">
                <?php require_once '../../../function/data-merek-manufaktur.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-manufaktur.php?id_manufaktur=" + id;
                }
            }
        </script>
    </body>
</html>