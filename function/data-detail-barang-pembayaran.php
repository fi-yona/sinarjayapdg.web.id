<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
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

require_once 'dbconfig.php';

$id_pembayaran = $_GET['id_pembayaran'];

function createDetailBarangRiwayatPembayaranLink($id_dt_pembayaran)
{
    $link = '<a href="detail-barang-pembayaran.php?id_dt_pembayaran=' . $id_dt_pembayaran . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_detail_pembayaran.id_dt_pembayaran,
            tb_merek.nama_merek,
            tb_barang.nama_barang,
            tb_detail_pembayaran.banyak_barang,
            tb_detail_pembayaran.harga_barang,
            tb_detail_pembayaran.total_harga_barang
        FROM 
            tb_detail_pembayaran 
        INNER JOIN
            tb_barang ON tb_detail_pembayaran.id_barang = tb_barang.id_barang
        INNER JOIN
            tb_merek ON tb_barang.id_merek = tb_merek.id_merek
        WHERE 
            id_pembayaran = '$id_pembayaran'
        ORDER BY 
            tb_merek.nama_merek ASC, tb_barang.nama_barang ASC";

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
    echo "<th class='.title-atribut-data-pesanan'>Total Pembayaran Barang</th>";
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
        echo "<td>" . createDetailBarangRiwayatPembayaranLink($row['id_dt_pembayaran']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data barang pembayaran.</p>";
}
