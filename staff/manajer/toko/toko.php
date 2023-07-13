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
		<title>Data Toko</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
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
                <a href="./rute.php"><button type="button" class="button-sub-menu">Lihat Rute</button></a>
            </div>
            <div class = "title-page">
                Data Toko
            </div>
            <div class = "search-column">
                <form id="form-search-absensi" class="form-search" action="../function/do-search-absensi.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Masukkan Kata Kunci" name="kata-kunci" id="kata-kunci" class="input-kata-kunci">
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Toko">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "add-data">
                <a href="./add-toko.php"><button type="button" class="button-add-data">Tambah Toko</button></a>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-toko.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>