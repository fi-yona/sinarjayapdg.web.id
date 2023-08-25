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
		<title>Data Riwayat Pesanan</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v7">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v3">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v13">
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
                    <li><a href="./riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="./jatuh-tempo.php"><button type="button" class="button-sub-menu">Lihat Pesanan Jatuh Tempo</button></a>
            </div>
            <div class = "title-page">
                Data Riwayat Pesanan
            </div>
            <div class = "search-column">
                <form id="form-search-pesanan" class="form-search" action="../../../function/do-search-pesanan.php" method="POST"> 
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
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="toko_search" id="toko_search" class="select-toko">
                                        <?php require_once '../../../function/select-toko.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="status_bayar_search" id="status_bayar_search" class="select-status-bayar">
                                        <option value='Semua'>Semua Status Bayar</option>
                                        <option value='Belum Lunas'>Belum Lunas</option>
                                        <option value='Lunas'>Lunas</option>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="cara_penagihan_search" id="cara_penagihan_search" class="select-cara-penagihan">
                                        <option value='Semua'>Semua Cara Penagihan</option>
                                        <option value='Cicilan'>Cicilan</option>
                                        <option value='Lunas'>Lunas</option>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Jatuh Tempo" name="jatuh_tempo_search" id="jatuh_tempo_search" class="input-text-search-tanggal tanggal-search">
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="username_search" id="username_search" class="select-sales">
                                        <option value='Semua'>Semua Sales</option>
                                        <?php require_once '../../../function/select-username.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Pesanan">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-riwayat-pesanan.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $("#form-search-pesanan").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataPesanan(); // Panggil fungsi cariDataKunjungan() untuk melakukan AJAX request
                });

                function cariDataPesanan() {
                    // Ambil nilai dari elemen input
                    const tanggalDari = $("#tanggal_dari_search").val();
                    const tanggalHingga = $("#tanggal_hingga_search").val();
                    const toko = $("#toko_search").val();
                    const statusBayar = $("#status_bayar_search").val();
                    const caraPenagihan = $("#cara_penagihan_search").val();
                    const jatuhTempo = $("#jatuh_tempo_search").val();
                    const username = $("#username_search").val();

                    // Lakukan request AJAX ke halaman do-search-kunjungan.php
                    $.ajax({
                        url: '../../../function/do-search-pesanan.php',
                        type: 'POST',
                        data: {
                            tanggal_dari_search: tanggalDari,
                            tanggal_hingga_search: tanggalHingga, 
                            toko_search: toko, 
                            status_bayar_search: statusBayar, 
                            cara_penagihan_search: caraPenagihan, 
                            jatuh_tempo_search: jatuhTempo,
                            username_search: username
                        },
                        success: function (response) {
                            console.log(response);
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data pesanan');
                        }
                    });
                }
            });
        </script>
    </body>
</html>