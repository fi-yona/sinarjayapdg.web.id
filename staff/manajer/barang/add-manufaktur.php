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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah Manufaktur</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
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
            <div class = "title-page">
                Tambah Manufaktur
            </div>
            <div class = "detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-manufaktur" class="table-form-add" action="../../../function/add-data-manufaktur.php" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Manufaktur</th>
                                <td><input type="text" placeholder="Nama Manufaktur/Badan Usaha" name="nama_manufaktur" id="nama_manufaktur" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td><input type="text" placeholder="Nomor Telepon Kantor/CS" name="kontak_manufaktur" id="kontak_manufaktur" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" placeholder="Email Kantor/CS" name="email_manufaktur" id="email_manufaktur" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td><textarea placeholder="Website Resmi Manufaktur" name="website_manufaktur" id="website_manufaktur" class="input-text-add" rows="3"></textarea></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><textarea placeholder="Alamat Lokasi Kantor Manufaktur" name="alamat_manufaktur" id="alamat_manufaktur" class="input-text-add" rows="10"></textarea></td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td><input type="text" placeholder="Kode Pos Kantor" name="kode_pos_manufaktur" id="kode_pos_manufaktur" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td><input type="text" placeholder="Kota Lokasi Kantor Manufaktur" name="kota_manufaktur" id="kota_manufaktur" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Negara</th>
                                <td><input type="text" placeholder="Negara Lokasi Kantor Manufaktur" name="negara_manufaktur" id="negara_manufaktur" class="input-text-add"></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-manufaktur" class="button-submit-add" value="Submit">
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
            function validateForm() {
                var namaManufaktur = document.getElementById('nama_manufaktur').value;

                if (namaManufaktur.trim() === '') {
                    alert('Nama manufaktur tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }
                
                return true;
            }
        </script>
    </body>
</html>
