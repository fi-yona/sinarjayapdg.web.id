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
        <title>Tambah Karyawan</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
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
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="./karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "title-page">
                Tambah Karyawan
            </div>
            <div class = "detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-karyawan" class="table-form-add" action="../../../function/add-data-karyawan.php" method="POST">
                        <table class="table-add-data">
                            <tr>
                                <th>Username</th>
                                <td>
                                    <select name="username" id="username" class="input-text-add">
                                        <?php require_once '../../../function/select-username-karyawan.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>No KTP</th>
                                <td><input type="text" placeholder="Nomor NIK KTP" name="no_ktp" id="no_ktp" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><input type="text" placeholder="Nama Sesuai KTP" name="nama_lengkap" id="nama_lengkap" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Nama Panggilan</th>
                                <td><input type="text" placeholder="Panggilan" name="nama_panggilan" id="nama_panggilan" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td><input type="text" placeholder="Kota/Daerah" name="tempat_lahir" id="tempat_lahir" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_lahir" id="tanggal_lahir" class="input-text-add tanggal-penugasan"></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    <select name="jk" id="jk" class="input-text-add">
                                        <option value="P">Pria</option>
                                        <option value="W">Wanita</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>
                                    <select name="agama" id="agama" class="input-text-add">
                                        <option value="Islam">Islam</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <select name="status" id="status" class="input-text-add">
                                        <option value="Lajang">Lajang</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Pernah Menikah">Pernah Menikah</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <td>
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="input-text-add">
                                        <option value="S3">S3</option>
                                        <option value="S2">S2</option>
                                        <option value="S1">S1</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SD">SD</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td><input type="text" placeholder="No Whatsapp" name="no_telp" id="no_telp" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" placeholder="Email Pribadi" name="email" id="email" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Alamat Saat Ini</th>
                                <td><textarea placeholder="Alamat Tempat Tinggal Saat Ini" name="domisili" id="domisili" class="input-text-add" rows="10"></textarea></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td><input type="text" placeholder="Jabatan di Perusahaan" name="jabatan" id="jabatan" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Diterima</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_diterima" id="tanggal_diterima" class="input-text-add tanggal-penugasan"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Berhenti</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_berhenti" id="tanggal_berhenti" class="input-text-add tanggal-penugasan"></td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td><input type="text" placeholder="Link Foto" name="foto_karyawan" id="foto_karyawan" class="input-text-add"></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-karyawan" class="button-submit-add" value="Submit">
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
