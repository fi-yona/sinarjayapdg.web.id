<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../../../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

require_once 'dbconfig.php';

function createDetailMerekLink($id_merek)
{
    $link = '<a href="detail-merek.php?id_merek=' . $id_merek . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$manufaktur = isset($_POST['manufaktur_search']) ? $_POST['manufaktur_search'] : '';
$merek = isset($_POST['merek_search']) ? $_POST['merek_search'] : '';

// Buat query untuk pencarian data
$query = "SELECT
            tb_merek.id_merek,
            tb_merek.nama_merek,
            tb_manufaktur.nama_manufaktur,
            tb_merek.website_merek
            FROM
            tb_merek
            INNER JOIN
            tb_manufaktur ON tb_merek.id_manufaktur = tb_manufaktur.id_manufaktur";

// Tambahkan kondisi jika diberikan nilai
if ($manufaktur !== 'Semua' && empty($merek)) {
    $query .= " WHERE tb_manufaktur.id_manufaktur = '$manufaktur'";
} elseif ($manufaktur === 'Semua' && !empty($merek)) {
    $query .= " WHERE tb_merek.nama_merek LIKE '%$merek%'";
} elseif ($manufaktur !== 'Semua' && !empty($merek)) {
    $query .= " WHERE tb_manufaktur.id_manufaktur = '$manufaktur' AND tb_merek.nama_merek LIKE '%$merek%'";
} 

$query .= " ORDER BY tb_merek.nama_merek ASC";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Tampilkan hasil pencarian dalam tabel
$total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-merek'>No</th>";
    echo "<th class='.title-atribut-data-merek'>Nama Merek</th>";
    echo "<th class='.title-atribut-data-merek'>Nama Manufaktur</th>";
    echo "<th class='.title-atribut-data-merek'>Website</th>";
    echo "<th class='.title-atribut-data-merek'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['nama_merek'] . "</td>";
        echo "<td>" . $row['nama_manufaktur'] . "</td>";
        echo "<td>" . $row['website_merek'] . "</td>";
        echo "<td>" . createDetailMerekLink($row['id_merek']) . "</td>";
        echo "</tr>";
    }

echo "</table>";
echo "</div>";
?>
