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

function createDetailRuteLink($id_rute)
{
    $link = '<a href="detail-rute.php?id_rute=' . $id_rute . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT 
            tb_rute.id_rute, 
            tb_rute.nama_rute, 
            tb_rute.keterangan_rute 
        FROM 
            tb_rute
        ORDER BY
            tb_rute.nama_rute ASC, 
            tb_rute.create_at DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-rute'>No</th>";
    echo "<th class='.title-atribut-data-rute'>Nama Rute</th>";
    echo "<th class='.title-atribut-data-rute'>Keterangan Rute</th>";
    echo "<th class='.title-atribut-data-rute'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['nama_rute'] . "</td>";
        echo "<td>" . $row['keterangan_rute'] . "</td>";
        echo "<td>" . createDetailRuteLink($row['id_rute']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data rute.</p>";
}
?>
