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

$id_toko = $_GET['id_toko'];

require_once '../../../function/dbconfig.php';

$query = "SELECT
            tb_toko.id_toko,
            tb_toko.nama_toko
        FROM
            tb_toko
        WHERE id_toko = '$id_toko'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data toko tidak ditemukan";
    exit();
}

// Ambil data absensi
$row = $result->fetch_assoc();

//$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>QR Code Toko</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v4">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v2">
        <link rel="stylesheet" href="../../../assets/style/style-img.css?v6">
        <link rel="stylesheet" href="../../../assets/style/style-input.css">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
                    <li><a href="./toko.php">Toko</a></li>
                    <li><a href="../barang/barang.php">Barang</a></li>
                    <li><a href="../riwayat-pesanan/riwayat-pesanan.php">Riwayat Pesanan</a></li>
                    <li><a href="../riwayat-pembayaran/riwayat-pembayaran.php">Riwayat Pembayaran</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="javascript:history.back()"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                QR Code Toko <?php echo $row['nama_toko']?>
            </div>
            <div class = "detail-data">
                <div id="qrcode" class="qrcode">

                </div>
            </div>
            <div class="layout-button-data">
                <a id="download" href="" download="SINARJAYA-QR-<?php echo $id_toko ?>-<?php echo $row['nama_toko'] ?>.png"><button type="button" class="button-lihat-foto">Download QR Code</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            function hapusData(id) {
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    window.location.href = "../../../function/delete-data-toko.php?id_toko=" + id;
                }
            }

            window.addEventListener("load", () => {
                var qrc = new QRCode(document.getElementById("qrcode"), {
                    text: "<?php echo $id_toko; ?>",
                    width: 150,
                    height: 150,
                    //colorDark: "#ff0000",
                    //colorLight: "#ffffff",
                    // QRCode.CorrectLevel.L | QRCode.CorrectLevel.M | QRCode.CorrectLevel.H
                    correctLevel : QRCode.CorrectLevel.H
                });
            });
            
            var link = document.getElementById("download");
            link.addEventListener("click", setUpDownload);

            function setUpDownload() {
                // Find the image inside the #qrcode div
                var image = document.getElementById("qrcode").getElementsByTagName("img");

                // Get the src attribute of the image, which is the data-encoded QR code
                var qr = image[0].src;

                // Copy that to the download link
                link.href = qr;
            }
        </script>
    </body>
</html>