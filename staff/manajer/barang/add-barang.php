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

//memuncul data berhasil tersimpan
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo '<script>alert("Data Berhasil Tersimpan");</script>';
}elseif(isset($_GET['status']) && $_GET['status'] === 'success-delete') {
    echo '<script>alert("Data Berhasil Terhapus");</script>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Barang</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
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
            <div class = "title-page">
                Tambah Barang
            </div>
            <div class = "detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-barang" class="table-form-add" action="../../../function/add-data-barang.php" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Merek</th>
                                <td>
                                    <select name="id_merek" id="id_merek" class="input-text-add">
                                        <?php require_once '../../../function/select-merek.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td><input type="text" placeholder="Nama Barang" name="nama_barang" id="nama_barang" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Kode BPOM</th>
                                <td><input type="text" placeholder="Kode BPOM" name="kode_bpom" id="kode_bpom" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Banyak Barang</th>
                                <td><input type="text" placeholder="Tanpa Titik" name="banyak_barang" id="banyak_barang" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td><input type="text" placeholder="Tanpa Titik & Rupiah" name="harga_barang" id="harga_barang" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Link Gambar</th>
                                <td><input type="text" placeholder="Masukkan Link Gambar Barang" name="gambar_barang" id="gambar_barang" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><textarea placeholder="Tulis deskripsi, detail, fungsi, manfaat, cara pakai, dan sebagainya di sini!" name="keterangan" id="keterangan" class="input-text-add" rows="10"></textarea></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-barang" class="button-submit-add" value="Submit">
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
                var namaBarang = document.getElementById('nama_barang').value;
                var banyakBarang = document.getElementById('banyak_barang').value;
                var harga = document.getElementById('harga_barang').value;

                if (namaBarang.trim() === '') {
                    alert('Nama barang tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (banyakBarang.trim() === ''){
                    alert('Banyak barang tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (harga.trim() === ''){
                    alert('Harga barang tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }
                return true;
            }
        </script>
    </body>
</html>