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

function createDetailTokoLink($id_toko)
{
    $link = '<a href="detail-toko.php?id_toko=' . $id_toko . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$rute = isset($_POST['rute_search']) ? $_POST['rute_search'] : '';
$toko = isset($_POST['toko_search']) ? $_POST['toko_search'] : '';

// Buat query untuk pencarian data toko
$query = "SELECT
                tb_toko.id_toko,
                tb_toko.nama_toko,
                tb_rute.nama_rute,
                tb_toko.kontak_toko,
                tb_toko.alamat_toko
            FROM
                tb_toko
            JOIN
                tb_rute ON tb_toko.id_rute = tb_rute.id_rute";

// Tambahkan kondisi jika diberikan nilai
if ($rute !== 'Semua' && empty($toko)) {
    $query .= " WHERE tb_rute.id_rute = '$rute'";
} elseif ($rute === 'Semua' && !empty($toko)) {
    $query .= " WHERE tb_toko.nama_toko LIKE '%$toko%'";
} elseif ($rute !== 'Semua' && !empty($toko)) {
    $query .= " WHERE tb_rute.id_rute = '$rute' AND tb_toko.nama_toko LIKE '%$toko%'";
} 

$query .= " ORDER BY tb_toko.nama_toko ASC";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    // Tampilkan hasil pencarian dalam tabel
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-absensi'>No</th>";
    echo "<th class='.title-atribut-data-toko'>Id Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Nama Rute</th>";
    echo "<th class='.title-atribut-data-toko'>Kontak Toko</th>";
    echo "<th class='.title-atribut-data-toko'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
            $counter++;
        echo "<td>" . $row['id_toko'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . $row['nama_rute'] . "</td>";
        echo "<td>" . $row['kontak_toko'] . "</td>";
        echo "<td>" . createDetailTokoLink($row['id_toko']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data toko yang ditemukan.</p>";
}
?>
