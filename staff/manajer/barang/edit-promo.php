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

$id_promo = $_GET['id_promo'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
            tb_promo.nama_promo,
            tb_promo.bentuk_promo, 
            tb_promo.mulai_berlaku, 
            tb_promo.akhir_berlaku, 
            tb_promo.status_promo, 
            tb_promo.keterangan
            FROM 
                tb_promo
            WHERE 
                tb_promo.id_promo = '$id_promo'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data barang tidak ditemukan";
    exit();
}

// Ambil data 
$row = $result->fetch_assoc();

// Query SQL untuk data detail promo
$sql_detail_promo = "SELECT
                        tb_detail_promo.id_dt_promo,
                        tb_barang.id_barang,
                        tb_merek.nama_merek,
                        tb_barang.nama_barang,
                        tb_barang.harga_barang,
                        tb_detail_promo.id_promo,
                        tb_detail_promo.id_barang,
                        tb_detail_promo.harga_promo,
                        tb_detail_promo.keterangan_barang_promo
                    FROM
                        tb_detail_promo
                    INNER JOIN 
                        tb_barang ON tb_detail_promo.id_barang = tb_barang.id_barang
                    INNER JOIN
                        tb_merek ON tb_barang.id_merek = tb_merek.id_merek
                    WHERE
                        tb_detail_promo.id_promo = '$id_promo'";

// Eksekusi query data detail promo
$result_detail_promo = mysqli_query($conn, $sql_detail_promo);

// Periksa apakah query berhasil dieksekusi
if (!$result_detail_promo) {
    die("Query error: " . $conn->error);
}

// Ambil semua data detail promo
$detail_promos = [];
while ($row_detail_promo = mysqli_fetch_assoc($result_detail_promo)) {
    $detail_promos[] = $row_detail_promo;
}

function createDetailBarang1Link($id_barang)
{
    $link = '<a href="detail-barang.php?id_barang=' . $id_barang . '">Detail</a>';
    return $link;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Promo</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v6">
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
            <div class="title-page">
                Edit Promo
            </div>
            <form id="form-edit-data-promo" class="table-form-add" action="../../../function/edit-data-promo.php?id_promo=<?php echo $id_promo; ?>" method="POST">
                <div class="detail-data">
                    <div class="box-green-1">
                        <table class="table-add-data">
                            <tr>
                                <th>Nama Promo</th>
                                <td><input type="text" placeholder="Nama Promo" name="nama_promo" id="nama_promo" class="input-text-add" value="<?php echo $row['nama_promo']; ?>"></td>
                            </tr> 
                            <tr>
                                <th>Kategori Promo</th>
                                <td><input type="text" placeholder="Kategori atau Bentuk Promo" name="bentuk_promo" id="bentuk_promo" class="input-text-add" value="<?php echo $row['bentuk_promo']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Mulai Berlaku</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="mulai_berlaku" id="mulai_berlaku" class="input-text-add tanggal-penugasan" value="<?php echo $row['mulai_berlaku']; ?>"></td>
                            </tr> 
                            <tr>
                                <th>Akhir Berlaku</th>
                                <td><input type="text" placeholder="Tahun-Bulan-Hari" name="akhir_berlaku" id="akhir_berlaku" class="input-text-add tanggal-penugasan" value="<?php echo $row['akhir_berlaku']; ?>"></td>
                            </tr>
                            <tr>
                                <th>Status Promo</th>
                                <td>
                                    <select name="status_promo" id="status_promo" class="input-text-add">
                                        <option value="Aktif" <?php echo ($row['status_promo'] === 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?php echo ($row['status_promo'] === 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><textarea placeholder="Tulis deskripsi atau keterangan tentang promo di sini!" name="keterangan" id="keterangan" class="input-text-add" rows="10"><?php echo $row['keterangan']; ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p></p>
                <?php
                    // Periksa hasil query data detail promo
                    if (count($detail_promos) > 0) {
                        echo "<div class='sub-title-page'>";
                        echo "Edit Detail Barang Promo";
                        echo "</div>";
                        echo "<div class='table-wrapper'>";
                        echo "<table class='table-search-result'>";
                        echo "<tr>";
                        echo "<th >Pilih</th>"; // Kolom checkbox
                        echo "<th class='.title-atribut-data-barang'>Nama Merek</th>";
                        echo "<th class='.title-atribut-data-barang'>Nama Barang</th>";
                        echo "<th class='.title-atribut-data-barang'>Harga Barang</th>";
                        echo "<th class='.title-atribut-data-barang'>Harga Promo</th>";
                        echo "<th class='.title-atribut-data-barang'>Keterangan Promo</th>";
                        echo "<th class='.title-atribut-data-barang'>Detail Barang</th>";
                        echo "</tr>";
                        // Tampilkan data detail promo dalam tabel
                        foreach ($detail_promos as $detail_promo) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='selected_barang[]' value='" . $detail_promo['id_barang'] . "' checked></td>"; // Checkbox
                            echo "<td>" . $detail_promo['nama_merek'] . "</td>";
                            echo "<td>" . $detail_promo['nama_barang'] . "</td>";
                            echo "<td>" . number_format($detail_promo['harga_barang'], 0, ',', '.') . "</td>";
                            echo "<td><input type='text' placeholder='Tanpa Titik dan Koma' name='harga_promo[]' value='" . $detail_promo['harga_promo'] . "' class='input-text-add'></td>";
                            echo "<td><textarea placeholder='Keterangan Barang Promo' name='keterangan_barang_promo[]' class='input-text-add' rows='5'>" . $detail_promo['keterangan_barang_promo'] . "</textarea></td>";
                            echo "<td>" . createDetailBarang1Link($detail_promo['id_barang']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    } else {
                        // Jika query data detail promo tidak mengembalikan hasil
                        echo "<p>Tidak ada data detail promo.</p>";
                    }
                ?>    
                <div class="layout-button-submit">
                    <input type="submit" name="edit-data-promo" class="button-submit-add" value="Submit Edit Barang Promo">
                </div>
            </form>
            <div class="layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
            <p></p>
            <hr>
            <div class="sub-title-page">
                Tambah Barang Promo
            </div>
            <form id="form-add-data-edit-promo" class="table-form-add" action="../../../function/edit-add-data-promo.php?id_promo=<?php echo $id_promo; ?>" method="POST">
                <div class = "search-result">
                    <?php include '../../../function/table-select-data-barang-promo-edit.php'; ?>
                </div>
                <div class="layout-button-submit">
                    <input type="submit" name="add-edit-data-promo" class="button-submit-add" value="Submit Tambah Barang Promo">
                </div>
            </form>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>
