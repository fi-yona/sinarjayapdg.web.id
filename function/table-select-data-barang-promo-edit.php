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
        WHERE
            tb_barang.banyak_barang > 0
            AND tb_barang.id_barang NOT IN (SELECT id_barang FROM tb_detail_promo WHERE id_promo = '$id_promo')
        ORDER BY
            tb_merek.nama_merek ASC, tb_barang.nama_barang ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
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
    echo "</div>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='selected_barang[]' value='" . $row['id_barang'] . "'></td>"; // Checkbox
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_barang'] . "</td>";
        echo "<td>" . number_format($row['harga_barang'], 0, ',', '.') . "</td>";
        echo "<td><input type='text' placeholder='Tanpa Titik dan Koma' name='harga_promo[]' class='input-text-add'></td>";
        echo "<td><textarea placeholder='Keterangan Barang Promo' name='keterangan_barang_promo[]' class='input-text-add' rows='5'></textarea></td>";
        echo "<td>" . createDetailBarangLink($row['id_barang']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data barang.</p>";
}
?>
