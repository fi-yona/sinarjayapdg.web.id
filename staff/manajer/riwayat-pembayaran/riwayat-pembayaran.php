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
		<title>Data Riwayat Pembayaran</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js?v3"></script>
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
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="./riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        </header>
        <main>
            <div class = "title-page">
                Data Riwayat Pembayaran
            </div>
            <div class = "search-column">
                <form id="form-search-pembayaran" class="form-search" action="../../../function/do-search-pembayaran.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Dari Tanggal" name="tanggal_dari_search" id="tanggal_dari_search" class="input-text-search-tanggal tanggal-search">
                                </div>
                            </td>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Hingga Tanggal" name="tanggal_hingga_search" id="tanggal_hingga_search" class="input-text-search-tanggal tanggal-search">
                                </div>
                            </td>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Masukkan Nama Toko" name="toko_search" id="toko_search" class="input-kata-kunci">
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="metode_pembayaran_search" id="metode_pembayaran_search" class="select-metode-pembayaran">
                                        <option value='Semua'>Semua Metode Pembayaran</option>
                                        <option value='QRIS'>QRIS</option>
                                        <option value='Tunai'>Tunai</option>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="username_search" id="username_search" class="select-penerima">
                                        <option value='Semua'>Semua Penerima</option>
                                        <?php require_once '../../../function/select-username.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Pembayaran">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-riwayat-pembayaran.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $("#form-search-pembayaran").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataPembayaran(); // Panggil fungsi cariDataPembayaran() untuk melakukan AJAX request
                });

                function cariDataPembayaran() {
                    // Ambil nilai dari elemen input
                    const tanggalDari = $("#tanggal_dari_search").val();
                    const tanggalHingga = $("#tanggal_hingga_search").val();
                    const toko = $("#toko_search").val();
                    const metodePembayaran = $("#metode_pembayaran_search").val();
                    const username = $("#username_search").val();

                    // Lakukan request AJAX ke halaman do-search-pembayaran.php
                    $.ajax({
                        url: '../../../function/do-search-pembayaran.php',
                        type: 'POST',
                        data: {
                            tanggal_dari_search: tanggalDari,
                            tanggal_hingga_search: tanggalHingga, 
                            toko_search: toko, 
                            metode_pembayaran_search: metodePembayaran,
                            username_search: username
                        },
                        success: function (response) {
                            console.log(response);
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data pembayaran');
                        }
                    });
                }
            });
        </script>
    </body>
</html>