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

function createDetailPromoLink($id_promo)
{
    $link = '<a href="detail-promo.php?id_promo=' . $id_promo . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT 
            tb_promo.id_promo,
            tb_promo.nama_promo,
            tb_promo.bentuk_promo,
            tb_promo.mulai_berlaku,
            tb_promo.akhir_berlaku,
            tb_promo.status_promo
        FROM
            tb_promo
        ORDER BY 
            tb_promo.create_at DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-absensi'>Nama Promo</th>";
    echo "<th class='.title-atribut-data-absensi'>Kategori Promo</th>";
    echo "<th class='.title-atribut-data-absensi'>Mulai Berlaku</th>";
    echo "<th class='.title-atribut-data-absensi'>Akhir Berlaku</th>";
    echo "<th class='.title-atribut-data-absensi'>Status Promo</th>";
    echo "<th class='.title-atribut-data-absensi'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_promo'] . "</td>";
        echo "<td>" . $row['bentuk_promo'] . "</td>";
        echo "<td>" . $row['mulai_berlaku'] . "</td>";
        echo "<td>" . $row['akhir_berlaku'] . "</td>";
        echo "<td>" . $row['status_promo'] . "</td>";
        echo "<td>" . createDetailPromoLink($row['id_promo']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data promo.</p>";
}
?>
