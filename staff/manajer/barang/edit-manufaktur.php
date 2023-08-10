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

$id_manufaktur = $_GET['id_manufaktur'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                nama_manufaktur,
                alamat_manufaktur,
                kontak_manufaktur,
                email_manufaktur,
                kode_pos_manufaktur,
                negara_manufaktur,
                kota_manufaktur,
                website_manufaktur
            FROM 
                tb_manufaktur
            WHERE 
                id_manufaktur = '$id_manufaktur'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data manufaktur tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Manufaktur</title>
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
        <script src="../../../script/show-calender.js"></script>
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
                Edit Manufaktur
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-manufaktur" class="table-form-add" action="../../../function/edit-data-manufaktur.php?id_manufaktur=<?php echo $id_manufaktur; ?>" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                        <tr>
                                <th>Nama Manufaktur</th>
                                <td><input type="text" placeholder="Nama Manufaktur/Badan Usaha" name="nama_manufaktur" id="nama_manufaktur" class="input-text-add" value="<?php echo $row['nama_manufaktur']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td><input type="text" placeholder="Nomor Telepon Kantor/CS" name="kontak_manufaktur" id="kontak_manufaktur" class="input-text-add" value="<?php echo $row['kontak_manufaktur']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="text" placeholder="Email Kantor/CS" name="email_manufaktur" id="email_manufaktur" class="input-text-add" value="<?php echo $row['email_manufaktur']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td><textarea placeholder="Website Resmi Manufaktur" name="website_manufaktur" id="website_manufaktur" class="input-text-add" rows="3"><?php echo $row['website_manufaktur']; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><textarea placeholder="Alamat Lokasi Kantor Manufaktur" name="alamat_manufaktur" id="alamat_manufaktur" class="input-text-add" rows="10"><?php echo $row['alamat_manufaktur']; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td><input type="text" placeholder="Kode Pos Kantor" name="kode_pos_manufaktur" id="kode_pos_manufaktur" class="input-text-add" value="<?php echo $row['kode_pos_manufaktur']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td><input type="text" placeholder="Kota Lokasi Kantor Manufaktur" name="kota_manufaktur" id="kota_manufaktur" class="input-text-add" value="<?php echo $row['kota_manufaktur']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Negara</th>
                                <td><input type="text" placeholder="Negara Lokasi Kantor Manufaktur" name="negara_manufaktur" id="negara_manufaktur" class="input-text-add" value="<?php echo $row['negara_manufaktur']; ?>"></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-manufaktur" class="button-submit-add" value="Submit">
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