<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

require_once 'dbconfig.php';

$id_pesanan = $_GET['id_pesanan'];

function createDetailBarangRiwayatPesananLink($id_dt_pesanan)
{
    $link = '<a href="detail-barang-pesanan.php?id_dt_pesanan=' . $id_dt_pesanan . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_detail_pesanan.id_dt_pesanan,
            tb_merek.nama_merek,
            tb_barang.nama_barang,
            tb_detail_pesanan.banyak_barang,
            tb_detail_pesanan.harga_barang,
            tb_detail_pesanan.total_harga_barang,
            tb_detail_pesanan.keterangan_pesanan,
            tb_detail_pesanan.barang_lunas,
            tb_detail_pesanan.status_barang
        FROM 
            tb_detail_pesanan 
        INNER JOIN
            tb_barang ON tb_detail_pesanan.id_barang = tb_barang.id_barang
        INNER JOIN
            tb_merek ON tb_barang.id_merek = tb_merek.id_merek
        WHERE id_pesanan = '$id_pesanan'
        ORDER BY tb_merek.nama_merek ASC, tb_barang.nama_barang ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Merek</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Banyak Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Harga Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Total Harga Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Banyak Barang Lunas</th>";
    echo "<th class='.title-atribut-data-pesanan'>Status Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Keterangan Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_barang'] . "</td>";
        echo "<td>" . number_format($row['banyak_barang'], 0, ',', '.') . "</td>";
        echo "<td>" . number_format($row['harga_barang'], 0, ',', '.') . "</td>";
        echo "<td>" . number_format($row['total_harga_barang'], 0, ',', '.') . "</td>";
        echo "<td>" . number_format($row['barang_lunas'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['status_barang'] . "</td>";
        echo "<td>" . $row['keterangan_pesanan'] . "</td>";
        echo "<td>" . createDetailBarangRiwayatPesananLink($row['id_dt_pesanan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data barang pesanan.</p>";
}
