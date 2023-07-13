<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

require_once 'dbconfig.php';

$id_promo = $_GET['id_promo'];

function createDetailBarangPromoLink($id_dt_promo)
{
    $link = '<a href="detail-barang-promo.php?id_dt_promo=' . $id_dt_promo . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_detail_promo.id_dt_promo,
            tb_merek.nama_merek,
            tb_barang.nama_barang,
            tb_detail_promo.harga_promo,
            tb_detail_promo.keterangan_barang_promo
        FROM 
            tb_detail_promo 
        INNER JOIN
            tb_barang ON tb_detail_promo.id_barang = tb_barang.id_barang
        INNER JOIN
            tb_merek ON tb_barang.id_merek = tb_merek.id_merek
        WHERE 
            id_promo = '$id_promo'
        ORDER BY 
            tb_merek.nama_merek ASC, 
            tb_barang.nama_barang ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Merek</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Barang</th>";
    echo "<th class='.title-atribut-data-pesanan'>Harga Promo</th>";
    echo "<th class='.title-atribut-data-pesanan'>Keterangan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_barang'] . "</td>";
        echo "<td>" . number_format($row['harga_promo'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['keterangan_barang_promo'] . "</td>";
        echo "<td>" . createDetailBarangPromoLink($row['id_dt_promo']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data barang promo.</p>";
}
