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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Promo</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v5">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js?v2"></script>
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
                Tambah Promo
            </div>
            <form id="form-add-data-promo" class="table-form-add" action="../../../function/add-data-promo.php" method="POST">
                <div class = "detail-data">
                    <div class = "box-green-1">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Promo</th>
                                <td><input type="text" placeholder="Nama Promo" name="nama_promo" id="nama_promo" class="input-text-add"></td>
                            </tr> 
                            <tr>
                                <th>Kategori Promo</th>
                                <td><input type="text" placeholder="Kategori atau Bentuk Promo" name="bentuk_promo" id="bentuk_promo" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Mulai Berlaku</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="mulai_berlaku" id="mulai_berlaku" class="input-text-add tanggal-penugasan"></td>
                            </tr> 
                            <tr>
                                <th>Akhir Berlaku</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="akhir_berlaku" id="akhir_berlaku" class="input-text-add tanggal-penugasan"></td>
                            </tr>
                            <tr>
                                <th>Status Promo</th>
                                <td>
                                    <select name="status_promo" id="status_promo" class="input-text-add">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><textarea placeholder="Tulis deskripsi atau keterangan tentang promo di sini!" name="keterangan" id="keterangan" class="input-text-add" rows="10"></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--table pilih barang-->
                <div class = "search-result">
                    <?php include '../../../function/table-select-data-barang-promo.php'; ?>
                </div>
                <div class="layout-button-submit">
                    <input type="submit" name="add-data-promo" class="button-submit-add" value="Submit">
                </div>
            </form>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>