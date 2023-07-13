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
                tb_toko.id_rute,
                tb_toko.kontak_toko,
                tb_toko.alamat_toko,
                tb_toko.latitude_toko,
                tb_toko.longitude_toko,
                tb_toko.link_gmaps,
                tb_toko.gambar_toko
            FROM
                tb_toko
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

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Toko</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
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
            <div class = "title-page">
                Edit Toko
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-toko" class="table-form-add" action="../../../function/edit-data-toko.php?id_toko=<?php echo $id_toko; ?>" method="POST">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Toko</th>
                                <td><input type="text" placeholder="Nama Toko" name="nama_toko" id="nama_toko" class="input-text-add" value="<?php echo $row['nama_toko']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Rute</th>
                                <td>
                                    <select name="id_rute" id="id_rute" class="input-text-add">
                                        <?php require_once '../../../function/edit-select-rute-toko.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td><input type="text" placeholder="Kontak Toko" name="kontak_toko" id="kontak_toko" class="input-text-add" value="<?php echo $row['kontak_toko']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>
                                    <textarea placeholder="Alamat Toko" name="alamat_toko" id="alamat_toko" class="input-text-add" rows="4"><?php echo $row['alamat_toko']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Latitude</th>
                                <td><input type="text" placeholder="Pakai Titik, Tanpa Koma" name="latitude_toko" id="latitude_toko" class="input-text-add" value="<?php echo $row['latitude_toko']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Longitude</th>
                                <td><input type="text" placeholder="Pakai Titik, Tanpa Koma" name="longitude_toko" id="longitude_toko" class="input-text-add" value="<?php echo $row['longitude_toko']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Link Gmaps</th>
                                <td><input type="text" placeholder="Dari Google Maps" name="link_gmaps" id="link_gmaps" class="input-text-add" value="<?php echo $row['link_gmaps']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Link Gambar</th>
                                <td><input type="text" placeholder="Masukkan Link Gambar" name="gambar_toko" id="gambar_toko" class="input-text-add" value="<?php echo $row['gambar_toko']; ?>"></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-toko" class="button-submit-add" value="Submit">
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