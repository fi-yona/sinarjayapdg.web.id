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
        <title>Detail Absensi</title>
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
                    <li><a href="./absensi.php">Absensi</a></li>
                    <li><a href="../kunjungan/kunjungan.php">Kunjungan</a></li>
                    <li><a href="../toko/toko.php">Toko</a></li>
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
                <a href="./absensi.php"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail Absensi
            </div>
            <div class = "detail-data-umum">
                <table class = "table-detail-data">
                    <tr>
                        <td>Id Absensi</td>
                        <td> : </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Tanggal Absensi</td>
                        <td> : </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td> : </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Usename</td>
                        <td> : </td>
                        <td> </td>
                    </tr>
                </table>
            </div>
            <div class = "detail-data-absensi">
                <table class="table-layout-absensi">
                    <tr>
                        <td>
                            <div class="box-green">
                                <div class = "title-jenis-absensi">
                                    Masuk
                                </div>
                                <div class = "layout-table-absensi">
                                    <table class = "table-data-absensi">
                                        <tr>
                                            <th>Waktu</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Latitude</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class = "layout-button-lihat-foto">
                                    <a href=""><button type="button" class="button-lihat-foto">Lihat Foto</button></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="box-green">
                                <div class = "title-jenis-absensi">
                                    Pulang
                                </div>
                                <div class = "layout-table-absensi">
                                    <table class = "table-data-absensi">
                                        <tr>
                                            <th>Waktu</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Latitude</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td> : </td>
                                            <td>(No Data)</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class = "layout-button-lihat-foto">
                                    <a href=""><button type="button" class="button-lihat-foto">Lihat Foto</button></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>