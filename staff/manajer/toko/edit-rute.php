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

$id_rute = $_GET['id_rute'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
                tb_rute.nama_rute,
                tb_rute.keterangan_rute
            FROM
                tb_rute
            WHERE id_rute = '$id_rute'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data rute tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Rute</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.5">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v1.2">
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
                Edit Rute
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-rute" class="table-form-add" action="../../../function/edit-data-rute.php?id_rute=<?php echo $id_rute; ?>" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Rute</th>
                                <td><input type="text" placeholder="Nama Rute" name="nama_rute" id="nama_rute" class="input-text-add" value="<?php echo $row['nama_rute']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Keterangan Rute</th>
                                <td>
                                    <textarea placeholder="Tentang Daerah-Daerah Rute" name="keterangan_rute" id="keterangan_rute" class="input-text-add" rows="4"><?php echo $row['keterangan_rute']; ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-rute" class="button-submit-add" value="Submit">
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
                var namaRute = document.getElementById('nama_rute').value;

                if (namaRute.trim() === '') {
                    alert('Nama rute tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }

                // Lanjutkan dengan pengiriman formulir jika nama rute tidak kosong
                return true;
            }
        </script>
    </body>
</html>