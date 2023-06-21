<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Home</title>
		<link rel="stylesheet" href="../../assets/style/style.css">
        <link rel="shortcut icon" href="../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../script/logout.js"></script>
	</head>
    <body>
        <header>
            <center>
                <h1><img src="../../assets/img/logo-horizontal.png" class="logo-header"></h1>
            </center>
            <nav class="nav-home">
                <ul class="nav-home-ul">
                    <li><a href="./home.html">Home</a></li>
                    <li><a href="./absensi/absensi.html">Absensi</a></li>
                    <li><a href="./kunjungan/kunjungan.html">Kunjungan</a></li>
                    <li><a href="./toko/toko.html">Toko</a></li>
                    <li><a href="./barang/barang.html">Barang</a></li>
                    <li><a href="./riwayat-pesanan/riwayat-pesanan.html">Riwayat Pesanan</a></li>
                    <li><a href="./riwayat-pembayaran/riwayat-pembayaran.html">Riwayat Pembayaran</a></li>
                    <li><a href="./karyawan/karyawan.html">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="box-white-black-stroke-1">
                <div class="title-data-home">
                    Data Absensi Terkonfirmasi Hari Ini
                </div>
                <div class="box-white-black-stroke-2">
                    <div class="title-nama-data-home">
                        Masuk
                    </div>
                    <div class="total-data-home">
                        Total: (Data Jumlah Orang)
                    </div>
                    <div>
                        <table class="table-data-home">
                            <tr>
                                <th class=".title-atribut-data-home">Nama Lengkap</td>
                                <th class=".title-atribut-data-home">Username</td>
                                <th class=".title-atribut-data-home">Waktu Masuk</td>
                                <th class=".title-atribut-data-home">Keterangan Masuk</td>
                                <th class=".title-atribut-data-home">Waktu Pulang</td>
                                <th class=".title-atribut-data-home">Keterangan Pulang</td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <center>
                <div class="footer">
                    Copyright UD Sinar Jaya Padang (IT Departement) - 2023
                </div>
            </center>  
        </footer>
    </body>
</html>