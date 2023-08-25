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
		<title>Data Karyawan</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v3">
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
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="./karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        </header>
        <main>
            <div class = "title-page">
                Data Karyawan
            </div>
            <div class = "search-column">
                <form id="form-search-karyawan" class="form-search" action="../../../function/do-search-karyawan.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Masukkan Nama atau Jabatan" name="kata_kunci" id="kata_kunci" class="input-kata-kunci-long">
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data Karyawan">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "add-data">
                <a href="./add-karyawan.php"><button type="button" class="button-add-data">Tambah Karyawan</button></a>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-karyawan.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $("#form-search-karyawan").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataKaryawan(); // Panggil fungsi cariDataKaryawan() untuk melakukan AJAX request
                });

                function cariDataKaryawan() {
                    // Ambil nilai dari elemen input
                    const kataKunci = $("#kata_kunci").val();

                    // Lakukan request AJAX ke halaman do-search-karyawan.php
                    $.ajax({
                        url: '../../../function/do-search-karyawan.php',
                        type: 'POST',
                        data: {
                            kata_kunci: kataKunci
                        },
                        success: function (response) {
                            console.log(response); // Cek respon dari server sebelum ditampilkan di halaman
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data karyawan');
                        }
                    });
                }
            });
        </script>
    </body>
</html>