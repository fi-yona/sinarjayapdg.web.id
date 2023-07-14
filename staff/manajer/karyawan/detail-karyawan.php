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

$id_karyawan = $_GET['id_karyawan'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_karyawan.foto_karyawan,
                tb_karyawan.no_ktp,
                tb_karyawan.nama_lengkap,
                tb_karyawan.nama_panggilan,
                tb_karyawan.username,
                tb_karyawan.tempat_lahir,
                tb_karyawan.tanggal_lahir,
                tb_karyawan.jk,
                tb_karyawan.agama,
                tb_karyawan.status,
                tb_karyawan.no_telp,
                tb_karyawan.email,
                tb_karyawan.domisili,
                tb_karyawan.jabatan,
                tb_karyawan.tanggal_diterima,
                tb_karyawan.tanggal_berhenti,
                tb_karyawan.pendidikan_terakhir
            FROM
                tb_karyawan
            WHERE
                id_karyawan = '$id_karyawan'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->connect_error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data karyawan tidak ditemukan";
    exit();
}

// Ambil data
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Karyawan</title>
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
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="./karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="./karyawan.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Karyawan
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class="layout-img-karyawan">
                        <?php $foto_karyawan = $row['foto_karyawan'];
                            if($foto_karyawan==NULL){
                                echo "(No Gambar)";
                            }else{
                                echo '<img src="'.$foto_karyawan.'" alt="'.$row['nama_lengkap'].'" class="img-karyawan">';
                            } ?>
                    </div>
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>No KTP</th>
                                <td> : </td>
                                <td><?php echo $row['no_ktp']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td> : </td>
                                <td><?php echo $row['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Panggilan</th>
                                <td> : </td>
                                <td><?php echo $row['nama_panggilan']; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td> : </td>
                                <td><?php echo $row['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td> : </td>
                                <td><?php echo $row['tempat_lahir'].", ".$row['tanggal_lahir']; ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td> : </td>
                                <td><?php 
                                        $jk = $row['jk'];
                                        if($jk=="P"){
                                            echo "Pria";
                                        }elseif($jk=="W"){
                                            echo "Wanita";
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td> : </td>
                                <td><?php echo $row['agama']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td> : </td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td> : </td>
                                <td><?php 
                                        $no_telp = $row['no_telp'];
                                        if($no_telp==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $no_telp;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td> : </td>
                                <td><?php 
                                        $email = $row['email'];
                                        if($email==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $email;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Domisili</th>
                                <td> : </td>
                                <td><?php 
                                        $domisili = $row['domisili'];
                                        if($domisili==NULL){
                                            echo "(No Data)";
                                        }else{
                                            echo $domisili;
                                        } 
                                ?></td>
                            </tr>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <td> : </td>
                                <td><?php echo $row['pendidikan_terakhir']; ?></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td> : </td>
                                <td><?php echo $row['jabatan']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Diterima</th>
                                <td> : </td>
                                <td><?php echo $row['tanggal_diterima']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Berhenti</th>
                                <td> : </td>
                                <td><?php 
                                        $tanggal_berhenti = $row['tanggal_berhenti'];
                                        if($tanggal_berhenti==NULL){
                                            echo "(MASIH BEKERJA)";
                                        }else{
                                            echo $tanggal_berhenti;
                                        } 
                                ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="edit-karyawan.php?id_karyawan=<?php echo $id_karyawan; ?>"><button type="button" class="button-edit-data">Edit</button></a><button type="button" class="button-hapus-data" onclick="hapusData(<?php echo $id_karyawan; ?>)">Hapus</button>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-karyawan.php?id_karyawan=" + id;
                }
            }
        </script>
    </body>
</html>