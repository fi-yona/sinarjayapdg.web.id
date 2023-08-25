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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Toko</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.6">
        <link rel="stylesheet" href="../../../assets/style/style-img.css?v1.2">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.3">
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
            <div class = "title-page">
                Tambah Toko
            </div>
            <div class = "detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-toko" class="table-form-add" action="../../../function/add-data-toko.php" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Toko</th>
                                <td><input type="text" placeholder="Nama Toko" name="nama_toko" id="nama_toko" class="input-text-add"></td>
                                </td>
                            </tr>
                            <tr>
                                <th>Rute</th>
                                <td>
                                    <select name="id_rute" id="id_rute" class="input-text-add">
                                        <?php require_once '../../../function/select-rute.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><textarea placeholder="Alamat Toko" name="alamat_toko" id="alamat_toko" class="input-text-add" rows="4"></textarea></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td><input type="text" placeholder="Kontak Toko" name="kontak_toko" id="kontak_toko" class="input-text-add"></td>
                                </td>
                            </tr>
                            <tr>
                                <th>Latitude</th>
                                <td><input type="text" placeholder="Pakai Titik, Tanpa Koma" name="latitude_toko" id="latitude_toko" class="input-text-add"></td>
                                </td>
                            </tr>
                            <tr>
                                <th>Longitude</th>
                                <td><input type="text" placeholder="Pakai Titik, Tanpa Koma" name="longitude_toko" id="longitude_toko" class="input-text-add"></td>
                                </td>
                            </tr>
                            <tr>
                                <th>Link GMaps</th>
                                <td><input type="text" placeholder="Dari Google Maps" name="link_gmaps" id="link_gmaps" class="input-text-add"></td>
                                </td>
                            </tr>
                            <tr>
                                <th>Link Gambar</th>
                                <td><input type="text" placeholder="Masukkan Link Gambar" name="gambar_toko" id="gambar_toko" class="input-text-add"></td>
                                </td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-toko" class="button-submit-add" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function validateForm() {
                var namaToko = document.getElementById('nama_toko').value;

                if (namaToko.trim() === '') {
                    alert('Nama toko tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }

                // Lanjutkan dengan pengiriman formulir jika nama toko tidak kosong
                return true;
            }
        </script>
    </body>
</html>