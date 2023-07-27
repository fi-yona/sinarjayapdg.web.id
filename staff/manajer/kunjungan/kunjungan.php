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

if(isset($_GET['status']) && $_GET['status'] === 'success-delete') {
    echo '<script>alert("Data Berhasil Terhapus");</script>';
}

?>

<!DOCTYPE html>
<html>
    <head>
		<title>Data Kunjungan</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v1.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.6">
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
        <main>
            <div class = "column-button-sub-menu">
                <a href="./penugasan.php"><button type="button" class="button-sub-menu">Lihat Penugasan</button></a>
            </div>
            <div class = "title-page">
                Data Kunjungan
            </div>
            <div class = "search-column">
                <form id="form-search-kunjungan" class="form-search" action="../../../function/do-search-kunjungan.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_search" id="tanggal_search" class="input-text-search-tanggal tanggal-search">
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="rute_search" id="rute_search" class="select-rute">
                                        <option value="Semua">Semua Rute</option>
                                        <?php require_once '../../../function/select-rute.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="toko_search" id="toko_search" class="select-toko">
                                        <?php require_once '../../../function/select-toko.php'; ?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="username_search" id="username_search" class="select-sales">
                                        <option value="Semua">Semua Sales</option>
                                        <?php require_once '../../../function/select-username.php';?>
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
                <?php include '../../../function/data-kunjungan.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {

                $("#rute_search").change(function(){
                    const selectedRute = $("#rute_search").val();
                    $.ajax({
                        url: '../../../function/select-toko-rute.php', // Pastikan URL sesuai dengan lokasi file select-toko-rute.php
                        type: 'POST',
                        data: { rute_search: selectedRute },
                        success: function (response) {
                            // Replace semua option di select-toko dengan option hasil dari AJAX response
                            $("#toko_search").html(response);
                        },
                        error: function (error) {
                            console.error('Terjadi kesalahan saat mengambil data toko:', error);
                            alert('Terjadi kesalahan saat mengambil data toko');
                        }
                    });
                });

                $("#form-search-kunjungan").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataKunjungan(); // Panggil fungsi cariDataKunjungan() untuk melakukan AJAX request
                });

                function cariDataKunjungan() {
                    // Ambil nilai dari elemen input
                    const tanggal = $("#tanggal_search").val();
                    const rute = $("#rute_search").val();
                    const toko = $("#toko_search").val();
                    const username = $("#username_search").val();

                    // Lakukan request AJAX ke halaman do-search-kunjungan.php
                    $.ajax({
                        url: '../../../function/do-search-kunjungan.php',
                        type: 'POST',
                        data: {
                            tanggal_search: tanggal,
                            rute_search: rute, 
                            toko_search: toko, 
                            username_search: username
                        },
                        success: function (response) {
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data kunjungan');
                        }
                    });
                }
            });
        </script>
    </body>
</html>