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
                    <li><a href="./home.php">Home</a></li>
                    <li><a href="./absensi/absensi.php">Absensi</a></li>
                    <li><a href="./kunjungan/kunjungan.php">Kunjungan</a></li>
                    <li><a href="./toko/toko.php">Toko</a></li>
                    <li><a href="./barang/barang.php">Barang</a></li>
                    <li><a href="./riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="./riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="./karyawan/karyawan.php">Karyawan</a></li>
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
            <table class="table-layout-home">
                <tr>
                    <td>
                        <div class="box-white-black-stroke-3">
                            <div class="title-data-home">
                                Total Kunjungan Toko
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Hari Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Kunjungan)
                                </div>
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Bulan Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Kunjungan)
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="box-white-black-stroke-4">
                            <div class="title-data-home">
                                Total Toko Terdaftar
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Penambahan Bulan Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Toko)
                                </div>
                                </div>
                                <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Bulan Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Toko)
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table-layout-home">
                <tr>
                    <td>
                        <div class="box-white-black-stroke-3">
                            <div class="title-data-home">
                                Total Pesanan
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Hari Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Pesanan)
                                </div>
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Bulan Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Pesanan)
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="box-white-black-stroke-4">
                            <div class="title-data-home">
                                Total Pembayaran
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Hari Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Pembayaran)
                                </div>
                                </div>
                                <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Bulan Ini
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Pembayaran)
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </main>
        <?php include '../../function/footer.php'; ?>
    </body>
</html>