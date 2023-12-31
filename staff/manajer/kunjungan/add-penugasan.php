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

// Dapatkan username dari session
$username = $_SESSION['username'];

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
        <title>Tambah Penugasan</title>
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
            <div class = "title-page">
                Tambah Penugasan
            </div>
            <div class="detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-penugasan" class="table-form-add" action="../../../function/add-data-penugasan.php" method="POST">
                        <table class="table-add-data">
                            <tr>
                                <th>Tanggal Penugasan</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_penugasan" id="tanggal_penugasan" class="input-text-add tanggal-penugasan" onchange="validateDate()"></td>
                            </tr>
                            <tr>
                                <th>Username Penugasan</th>
                                <td>
                                    <select name="username_penugasan" id="username_penugasan" class="input-text-add">
                                        <?php require_once '../../../function/select-username.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Rute Penugasan</th>
                                <td>
                                    <select name="rute_penugasan" id="rute_penugasan" class="input-text-add">
                                        <?php require_once '../../../function/select-rute.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Ditugaskan Oleh</th>
                                <td class = "td-username"><?php echo $username; ?></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-penugasan" class="button-submit-add" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            // Fungsi untuk memeriksa apakah tanggal penugasan lebih besar atau sama dengan tanggal saat ini
            function isDateValid(inputDate) {
                var currentDate = new Date().toISOString().split('T')[0];
                return inputDate >= currentDate;
            }

            // Fungsi untuk validasi tanggal saat input berubah
            function validateDate() {
                var tanggalPenugasan = document.getElementById('tanggal_penugasan').value;
                var isValid = isDateValid(tanggalPenugasan);
                
                if (!isValid) {
                    showInvalidDateAlert();
                    document.getElementById('tanggal_penugasan').value = ''; // Bersihkan input
                }
            }
            
            // Fungsi untuk menampilkan pesan peringatan
            function showInvalidDateAlert() {
                window.alert("Masukkan tanggal yang valid!");
            }
        </script>
    </body>
</html>