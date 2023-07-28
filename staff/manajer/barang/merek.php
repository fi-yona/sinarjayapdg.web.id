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
		<title>Data Merek</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v12">
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
            <table class="table-sub-menu">
                <tr>
                    <td>
                        <div class = "column-button-sub-menu">
                            <a href="./barang.php"><button type="button" class="button-sub-menu-back1">Kembali</button></a>
                        </div>
                    </td>
                    <td>
                        <div class = "column-button-sub-menu">
                            <a href="./manufaktur.php"><button type="button" class="button-sub-menu1">Lihat Manufaktur</button></a>
                        </div>
                    </td>
                </tr>
            </table>
            <div class = "title-page">
                Data Merek
            </div>
            <div class = "search-column">
                <form id="form-search-merek" class="form-search" action="../../../function/do-search-merek.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="manufaktur_search" id="manufaktur_search" class="select-manufaktur">
                                        <option value="Semua">Semua Manufaktur</option>
                                        <?php require_once '../../../function/select-manufaktur.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Masukkan Nama Merek" name="merek_search" id="merek_search" class="input-kata-kunci">
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Merek">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "add-data">
                <a href="./add-merek.php"><button type="button" class="button-add-data">Tambah Merek</button></a>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-merek.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $("#form-search-merek").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataMerek(); // Panggil fungsi cariDataBarang() untuk melakukan AJAX request
                });

                function cariDataMerek() {
                    // Ambil nilai dari elemen input
                    const manufaktur = $("#manufaktur_search").val();
                    const merek = $("#merek_search").val();

                    // Lakukan request AJAX ke halaman do-search-barang.php
                    $.ajax({
                        url: '../../../function/do-search-merek.php',
                        type: 'POST',
                        data: {
                            manufaktur_search: manufaktur, 
                            merek_search: merek
                        },
                        success: function (response) {
                            console.log(response); // Cek respon dari server sebelum ditampilkan di halaman
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data merek');
                        }
                    });
                }
            });
        </script>
    </body>
</html>