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

$id_rute = $_GET['id_rute'];

require_once 'dbconfig.php';

function createDetailTokoLink($id_toko)
{
    $link = '<a href="detail-toko.php?id_toko=' . $id_toko . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_toko.id_toko,
            tb_toko.nama_toko,
            tb_rute.nama_rute,
            tb_toko.kontak_toko,
            tb_toko.alamat_toko
        FROM
            tb_toko
        JOIN
            tb_rute ON tb_toko.id_rute = tb_rute.id_rute
        WHERE
            tb_toko.id_rute = $id_rute
        ORDER BY
            tb_toko.nama_toko ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-absensi'>No</th>";
    echo "<th class='.title-atribut-data-toko'>Id Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Kontak Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['id_toko'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . $row['kontak_toko'] . "</td>";
        echo "<td>" . createDetailTokoLink($row['id_toko']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    //echo "<p>Tidak ada data toko.</p>";
}
?>
