<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Data Riwayat Pesanan</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
	</head>
    <body>
        <header>
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
                    <li><a href="./riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        </header>
        <main>
            <table class="table-sub-menu">
                <tr>
                    <td>
                        <div class = "column-button-sub-menu">
                            <a href="./jatuh-tempo.php"><button type="button" class="button-sub-menu1">Lihat Pesanan Jatuh Tempo</button></a>
                        </div>
                    </td>
                    <td>
                        <div class = "column-button-sub-menu">
                            <a href="./penagihan.php"><button type="button" class="button-sub-menu1">Lihat Penagihan</button></a>
                        </div>
                    </td>
                </tr>
            </table>
            <div class = "title-page">
                Data Riwayat Pesanan
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
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Riwayat Pesanan">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "add-data">
                <a href="./add-barang.php"><button type="button" class="button-add-data">Tambah Barang</button></a>
            </div>
            <div class = "search-result">
                <table class = "table-search-result">
                    <tr>
                        <th class=".title-atribut-data-barang">Nama Merek</td>
                        <th class=".title-atribut-data-barang">Nama Barang</td>
                        <th class=".title-atribut-data-barang">Banyak Barang</td>
                        <th class=".title-atribut-data-barang">Harga Barang</td>
                    </tr>
                </table>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>