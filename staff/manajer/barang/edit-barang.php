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
            tb_barang.id_merek,
            tb_barang.nama_barang, 
            tb_barang.kode_bpom, 
            tb_barang.banyak_barang, 
            tb_barang.harga_barang, 
            tb_barang.gambar_barang,
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
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data barang tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Barang</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.4">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.5">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.2">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js"></script>
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
            <div class = "title-page">
                Edit Barang
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-barang" class="table-form-add" action="../../../function/edit-data-barang.php?id_barang=<?php echo $id_barang; ?>" method="POST">
                        <table class="table-add-data">
                            <tr>
                                <th>Merek</th>
                                <td>
                                    <select name="id_merek" id="id_merek" class="input-text-add">
                                        <?php require_once '../../../function/edit-select-merek-barang.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td><input type="text" placeholder="Nama Barang" name="nama_barang" id="nama_barang" class="input-text-add" value="<?php echo $row['nama_barang']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Kode BPOM</th>
                                <td><input type="text" placeholder="Kode BPOM" name="kode_bpom" id="kode_bpom" class="input-text-add" value="<?php echo $row['kode_bpom']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Banyak Barang</th>
                                <td><input type="text" placeholder="Tanpa Titik" name="banyak_barang" id="banyak_barang" class="input-text-add" value="<?php echo $row['banyak_barang']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td><input type="text" placeholder="Tanpa Titik & Rupiah" name="harga_barang" id="harga_barang" class="input-text-add" value="<?php echo $row['harga_barang']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Link Gambar</th>
                                <td><input type="text" placeholder="Masukkan Link Gambar Barang" name="gambar_barang" id="gambar_barang" class="input-text-add" value="<?php echo $row['gambar_barang']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><textarea placeholder="Tulis deskripsi, detail, fungsi, manfaat, cara pakai, dan sebagainya di sini!" name="keterangan" id="keterangan" class="input-text-add" rows="10"><?php echo $row['keterangan']; ?></textarea></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-barang" class="button-submit-add" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>