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

function createDetailMerekLink($id_merek)
{
    $link = '<a href="detail-merek.php?id_merek=' . $id_merek . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_merek.id_merek,
            tb_merek.nama_merek,
            tb_manufaktur.nama_manufaktur,
            tb_merek.website_merek
        FROM
            tb_merek
        JOIN
            tb_manufaktur ON tb_merek.id_manufaktur = tb_manufaktur.id_manufaktur
        ORDER BY
            tb_merek.nama_merek ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-merek'>Nama Merek</th>";
    echo "<th class='.title-atribut-data-merek'>Nama Manufaktur</th>";
    echo "<th class='.title-atribut-data-merek'>Website</th>";
    echo "<th class='.title-atribut-data-absensi'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_manufaktur'] . "</td>";
        echo "<td>" . $row['website_merek'] . "</td>";
        echo "<td>" . createDetailMerekLink($row['id_merek']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data merek.</p>";
}
?>
