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

if(isset($_GET['status']) && $_GET['status'] === 'success-delete-absensi') {
    echo '<script>alert("Data Absensi Berhasil Terhapus");</script>';
}

if (isset($_GET['status']) && $_GET['status'] === 'error-delete-absensi') {
    echo '<script>alert("Terjadi kesalahan saat menghapus data absensi");</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Absensi</title>
    <link rel="stylesheet" href="../../../assets/style/style-body.css?v1.5">
    <link rel="stylesheet" href="../../../assets/style/style-button.css">
    <link rel="stylesheet" href="../../../assets/style/style-img.css">
    <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.4">
    <link rel="shortcut icon" href="../../../assets/img/logo.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="./../../../script/logout1.js"></script>
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
    <div class="title-page">
        Data Absensi
    </div>
    <div class="search-column">
        <form id="form-search-absensi" class="form-search" action="../../../function/do-search-absensi.php" method="POST" onsubmit="cariDataAbsensi()">
            <table class="table-layout-search">
                <tr>
                    <td class="td-search-tanggal">
                        <div class="box-white-black-stroke-search">
                            <input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_search" id="tanggal_search"
                                   class="input-text-search-tanggal tanggal-search">
                        </div>
                    </td>
                    <td class="td-search-data">
                        <div class="box-white-black-stroke-search">
                            <select name="username_search" id="username_search" class="select-sales">
                                <option value="Semua">Semua</option>
                                <?php require_once '../../../function/select-username.php';?>
                            </select>
                        </div>
                    </td>
                    <td class="td-button-search">
                        <input type="submit" name="search" class="button-submit-search" value="Cari Data Absensi">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="search-result">
        <?php include '../../../function/data-absensi.php'; ?>
    </div>
</main>
<?php include '../../../function/footer.php'; ?>
<script>
    $(document).ready(function () {
        $("#form-search-absensi").submit(function (event) {
            event.preventDefault(); // Mencegah submit form secara default
            cariDataAbsensi(); // Panggil fungsi cariDataAbsensi() untuk melakukan AJAX request
        });

        function cariDataAbsensi() {
            // Ambil nilai tanggal dan username dari elemen input
            const tanggal = $("#tanggal_search").val();
            const username = $("#username_search").val();

            // Lakukan request AJAX ke halaman do-search-absensi.php
            $.ajax({
                url: '../../../function/do-search-absensi.php',
                type: 'POST',
                data: {
                    tanggal_search: tanggal,
                    username_search: username
                },
                success: function (response) {
                    // Tampilkan hasil pencarian di elemen dengan class search-result
                    $('.search-result').html(response);
                },
                error: function (error) {
                    alert('Terjadi kesalahan saat melakukan pencarian data absensi');
                }
            });
        }
    });
</script>
</body>
</html>
