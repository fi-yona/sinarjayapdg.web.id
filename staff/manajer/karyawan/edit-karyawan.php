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

$id_karyawan = $_GET['id_karyawan'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_karyawan.foto_karyawan,
                tb_karyawan.no_ktp,
                tb_karyawan.nama_lengkap,
                tb_karyawan.nama_panggilan,
                tb_karyawan.username,
                tb_karyawan.tempat_lahir,
                tb_karyawan.tanggal_lahir,
                tb_karyawan.jk,
                tb_karyawan.agama,
                tb_karyawan.status,
                tb_karyawan.no_telp,
                tb_karyawan.email,
                tb_karyawan.domisili,
                tb_karyawan.jabatan,
                tb_karyawan.tanggal_diterima,
                tb_karyawan.tanggal_berhenti,
                tb_karyawan.pendidikan_terakhir
            FROM
                tb_karyawan
            WHERE
                id_karyawan = '$id_karyawan'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data karyawan tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Karyawan</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.5">
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
                Edit Karyawan
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-karyawan" class="table-form-add" action="../../../function/edit-data-karyawan.php?id_karyawan=<?php echo $id_karyawan; ?>" method="POST">
                        <table class="table-add-data">
                        <tr>
                                <th>Username</th>
                                <td>
                                    <select name="username" id="username" class="input-text-add">
                                        <?php require_once '../../../function/edit-select-username-karyawan.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>No KTP</th>
                                <td><input type="text" placeholder="Nomor NIK KTP" name="no_ktp" id="no_ktp" class="input-text-add" value="<?php echo $row['no_ktp']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><input type="text" placeholder="Nama Sesuai KTP" name="nama_lengkap" id="nama_lengkap" class="input-text-add" value="<?php echo $row['nama_lengkap']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Nama Panggilan</th>
                                <td><input type="text" placeholder="Panggilan" name="nama_panggilan" id="nama_panggilan" class="input-text-add" value="<?php echo $row['nama_panggilan']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td><input type="text" placeholder="Kota/Daerah" name="tempat_lahir" id="tempat_lahir" class="input-text-add" value="<?php echo $row['tempat_lahir']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_lahir" id="tanggal_lahir" class="input-text-add tanggal-penugasan" value="<?php echo $row['tanggal_lahir']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    <select name="jk" id="jk" class="input-text-add">
                                        <option value="P" <?php echo ($row['jk'] === 'P') ? 'selected' : ''; ?>>Pria</option>
                                        <option value="W" <?php echo ($row['jk'] === 'W') ? 'selected' : ''; ?>>Wanita</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>
                                    <select name="agama" id="agama" class="input-text-add">
                                        <option value="Islam" <?php echo ($row['agama'] === 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                        <option value="Protestan" <?php echo ($row['agama'] === 'Protestan') ? 'selected' : ''; ?>>Protestan</option>
                                        <option value="Katolik" <?php echo ($row['agama'] === 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                        <option value="Hindu" <?php echo ($row['agama'] === 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                        <option value="Buddha" <?php echo ($row['agama'] === 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                                        <option value="Khonghucu" <?php echo ($row['agama'] === 'Khonghucu') ? 'selected' : ''; ?>>Khonghucu</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <select name="status" id="status" class="input-text-add">
                                        <option value="Lajang" <?php echo ($row['status'] === 'Lajang') ? 'selected' : ''; ?>>Lajang</option>
                                        <option value="Menikah" <?php echo ($row['status'] === 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
                                        <option value="Pernah Menikah" <?php echo ($row['status'] === 'Pernah Menikah') ? 'selected' : ''; ?>>Pernah Menikah</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <td>
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="input-text-add">
                                        <option value="S3" <?php echo ($row['pendidikan_terakhir'] === 'S3') ? 'selected' : ''; ?>>S3</option>
                                        <option value="S2" <?php echo ($row['pendidikan_terakhir'] === 'S2') ? 'selected' : ''; ?>>S2</option>
                                        <option value="S1" <?php echo ($row['pendidikan_terakhir'] === 'S1') ? 'selected' : ''; ?>>S1</option>
                                        <option value="SMA" <?php echo ($row['pendidikan_terakhir'] === 'SMA') ? 'selected' : ''; ?>>SMA</option>
                                        <option value="SMK" <?php echo ($row['pendidikan_terakhir'] === 'SMK') ? 'selected' : ''; ?>>SMK</option>
                                        <option value="SMP" <?php echo ($row['pendidikan_terakhir'] === 'SMP') ? 'selected' : ''; ?>>SMP</option>
                                        <option value="SD" <?php echo ($row['pendidikan_terakhir'] === 'SD') ? 'selected' : ''; ?>>SD</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td><input type="text" placeholder="No Whatsapp" name="no_telp" id="no_telp" class="input-text-add" value="<?php echo $row['no_telp']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" placeholder="Email Pribadi" name="email" id="email" class="input-text-add" value="<?php echo $row['email']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Alamat Saat Ini</th>
                                <td><textarea placeholder="Alamat Tempat Tinggal Saat Ini" name="domisili" id="domisili" class="input-text-add" rows="10"><?php echo $row['domisili']; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td><input type="text" placeholder="Jabatan di Perusahaan" name="jabatan" id="jabatan" class="input-text-add" value="<?php echo $row['jabatan']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Diterima</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_diterima" id="tanggal_diterima" class="input-text-add tanggal-penugasan" value="<?php echo $row['tanggal_diterima']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Berhenti</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="tanggal_berhenti" id="tanggal_berhenti" class="input-text-add tanggal-penugasan" value="<?php echo $row['tanggal_berhenti']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td><input type="text" placeholder="Link Foto" name="foto_karyawan" id="foto_karyawan" class="input-text-add" value="<?php echo $row['foto_karyawan']; ?>"></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-karyawan" class="button-submit-add" value="Submit">
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
                var noKtp = document.getElementById('no_ktp').value;
                var namaLengkap = document.getElementById('nama_lengkap').value;
                var namaPanggilan = document.getElementById('nama_panggilan').value;
                var jabatan = document.getElementById('jabatan').value;
                var tanggalDiterima = document.getElementById('tanggal_diterima').value;

                if (noKtp.trim() === '') {
                    alert('No KTP tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (namaLengkap.trim() === '') {
                    alert('Nama lengkap tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (namaPanggilan.trim() === '') {
                    alert('Nama panggilan tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (jabatan.trim() === '') {
                    alert('Jabatan tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (tanggalDiterima.trim() === '') {
                    alert('Tanggal Diterima tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }
                
                return true;
            }
        </script>
    </body>
</html>