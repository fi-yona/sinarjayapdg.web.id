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

$id_merek = $_GET['id_merek'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                tb_merek.nama_merek,
                tb_merek.id_manufaktur,
                tb_merek.website_merek
            FROM 
                tb_merek
            WHERE 
                tb_merek.id_merek = '$id_merek'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data merek tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Merek</title>
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
                Edit Merek
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-merek" class="table-form-add" action="../../../function/edit-data-merek.php?id_merek=<?php echo $id_merek; ?>" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Manufaktur</th>
                                <td>
                                    <select name="id_manufaktur" id="id_manufaktur" class="input-text-add">
                                        <?php require_once '../../../function/edit-select-manufaktur-merek.php';?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Merek</th>
                                <td><input type="text" placeholder="Nama Merek" name="nama_merek" id="nama_merek" class="input-text-add" value="<?php echo $row['nama_merek']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td><textarea placeholder="Link Website Merek" name="website_merek" id="website_merek" class="input-text-add" rows="3"><?php echo $row['website_merek']; ?></textarea></td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-merek" class="button-submit-add" value="Submit">
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
                var namaMerek = document.getElementById('nama_merek').value;

                if (namaMerek.trim() === '') {
                    alert('Nama merek tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }
                
                return true;
            }
        </script>
    </body>
</html>