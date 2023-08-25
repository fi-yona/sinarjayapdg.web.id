<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

// Dapatkan username dari session
$username = $_SESSION['username'];
$id_pembayaran = $_GET['id_pembayaran'];

?>

<script>
    function showCalendar() {
        // Tampilkan window kalender
        var tanggalPenugasan = document.getElementById('tanggal_penugasan');
        tanggalPenugasan.focus();
    }
</script>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Konfirmasi Pembayaran</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v1.4">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.5">
        <link rel="stylesheet" href="../../../assets/style/style-img.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.2">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js?v2"></script>
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
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="./riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "title-page">
                Tambah Konfirmasi Pembayaran
            </div>
            <div class="detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-konf-pembayaran" class="table-form-add" action="../../../function/add-data-konf-pembayaran.php?id_pembayaran=<?php echo $id_pembayaran; ?>" method="POST">
                        <table class="table-add-data">
                            <tr>
                                <th>Dikonfirmasi Oleh</th>
                                <td class = "td-username"><?php echo $username?></td>
                            </tr>
                            <tr>
                                <th>Status Konfirmasi</th>
                                <td>
                                    <select name="status_konf" id="status_konf" class="input-text-add">
                                        <option value="Belum Terkonfirmasi">Belum Terkonfirmasi</option>
                                        <option value="Terkonfirmasi">Terkonfirmasi</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-konf-pembayaran" class="button-submit-add" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>