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

function createDetailBarangLink($id_barang)
{
    $link = '<a href="detail-barang.php?id_barang=' . $id_barang . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_barang.id_barang,
            tb_merek.nama_merek,
            tb_barang.nama_barang,
            tb_barang.banyak_barang,
            tb_barang.harga_barang
        FROM
            tb_barang
        JOIN
            tb_merek ON tb_barang.id_merek = tb_merek.id_merek
        ORDER BY
            tb_merek.nama_merek ASC, tb_barang.nama_barang ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-barang'>No</th>";
    echo "<th class='.title-atribut-data-barang'>Nama Merek</th>";
    echo "<th class='.title-atribut-data-barang'>Nama Barang</th>";
    echo "<th class='.title-atribut-data-barang'>Banyak Barang</th>";
    echo "<th class='.title-atribut-data-barang'>Harga Barang</th>";
    echo "<th class='.title-atribut-data-barang'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_barang'] . "</td>";
        echo "<td>" . number_format($row['banyak_barang'], 0, ',', '.') . "</td>";
        echo "<td>" . number_format($row['harga_barang'], 0, ',', '.') . "</td>";
        echo "<td>" . createDetailBarangLink($row['id_barang']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data barang.</p>";
}
?>
