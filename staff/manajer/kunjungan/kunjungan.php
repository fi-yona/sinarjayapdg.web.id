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
		<title>Data Kunjungan</title>
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
        <header>
            <center>
                <h1><img src="../../../assets/img/logo-horizontal.png" class="logo-header"></h1>
            </center>
            <nav class="nav-home">
                <ul class="nav-home-ul">
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../absensi/absensi.php">Absensi</a></li>
                    <li><a href="./kunjungan.php">Kunjungan</a></li>
                    <li><a href="../toko/toko.php">Toko</a></li>
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        </header>
        <main>
            <div class = "title-page">
                Data Kunjungan
            </div>
            <div class = "search-column">
                <form id="form-search-absensi" class="form-search" action="../function/do-search-absensi.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Tahun" name="tahun" id="tahun-search" class="input-tahun">/<input type="text" placeholder="Bulan" name="bulan" id="bulan-search" class="input-bulan">/<input type="text" placeholder="Hari" name="hari" id="hari-search" class="input-hari">
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select class = "select-sales">
                                        <option value="option1">Pilihan 1</option>
                                        <option value="option2" selected>Pilihan 2</option>
                                        <option value="option3">Pilihan 3</option>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Kunjungan">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "search-result">
                <table class = "table-search-result">
                    <tr>
                        <th class=".title-atribut-data-kunjungan">Nama Lengkap</td>
                        <th class=".title-atribut-data-kunjungan">Username</td>
                        <th class=".title-atribut-data-kunjungan">Tanggal Kunjungan</td>
                        <th class=".title-atribut-data-kunjungan">Waktu Kunjungan</td>
                        <th class=".title-atribut-data-kunjungan">Nama Toko</td>
                        <th class=".title-atribut-data-kunjungan">Koordinat Kunjungan</td>
                        <th class=".title-atribut-data-kunjungan">Lokasi Kunjungan</td>
                    </tr>
                </table>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>