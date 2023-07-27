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

function createDetailKunjunganLink($id_kunjungan)
{
    $link = '<a href="detail-kunjungan.php?id_kunjungan=' . $id_kunjungan . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$tanggal = isset($_POST['tanggal_search']) ? $_POST['tanggal_search'] : '';
$rute = isset($_POST['rute_search']) ? $_POST['rute_search'] : '';
$toko = isset($_POST['toko_search']) ? $_POST['toko_search'] : '';
$username = isset($_POST['username_search']) ? $_POST['username_search'] : '';

// Buat query untuk pencarian data kunjungan
$query = "SELECT
                tb_kunjungan.id_kunjungan,
                tb_karyawan.nama_lengkap,
                tb_kunjungan.username,
                tb_kunjungan.tanggal_kunjungan,
                tb_kunjungan.waktu_kunjungan,
                tb_rute.nama_rute,
                tb_toko.nama_toko,
                tb_kunjungan.latitude_kunjungan,
                tb_kunjungan.longitude_kunjungan,
                tb_kunjungan.lokasi_kunjungan
            FROM
                tb_kunjungan
            INNER JOIN
                tb_karyawan ON tb_kunjungan.username = tb_karyawan.username
            INNER JOIN
                tb_toko ON tb_kunjungan.id_toko = tb_toko.id_toko
            INNER JOIN
                tb_rute ON tb_toko.id_rute = tb_rute.id_rute";

// Tambahkan kondisi jika diberikan nilai
if (!empty($tanggal) && $rute === 'Semua' && $toko === 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_kunjungan.tanggal_kunjungan = '$tanggal'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $toko === 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_rute.id_rute = '$rute'";
} elseif (empty($tanggal) && $rute === 'Semua' && $toko !== 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_kunjungan.id_toko = '$toko'";
} elseif (empty($tanggal) && $rute === 'Semua' && $toko === 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_kunjungan.username = '$username'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $toko === 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_kunjungan.tanggal_kunjungan = '$tanggal' AND tb_rute.id_rute = '$rute'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $toko !== 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_kunjungan.tanggal_kunjungan = '$tanggal' AND tb_kunjungan.id_toko = '$toko'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $toko === 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_kunjungan.tanggal_kunjungan = '$tanggal' AND tb_kunjungan.username = '$username'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $toko !== 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_rute.id_rute = '$rute' AND tb_kunjungan.id_toko = '$toko'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $toko === 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_rute.id_rute = '$rute' AND tb_kunjungan.username = '$username'";
} elseif (empty($tanggal) && $rute === 'Semua' && $toko !== 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_kunjungan.id_toko = '$toko' AND tb_kunjungan.username = '$username'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $toko !== 'Semua' && $username === 'Semua') {
    $query .= " WHERE tb_tanggal.tanggal_kunjungan = '$tanggal' AND tb_rute.id_rute = '$rute' AND tb_kunjungan.id_toko = '$toko'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $toko === 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_tanggal.tanggal_kunjungan = '$tanggal' AND tb_rute.id_rute = '$rute' AND tb_kunjungan.username = '$username'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $toko !== 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_tanggal.tanggal_kunjungan = '$tanggal' AND tb_kunjungan.id_toko = '$toko' AND tb_kunjungan.username = '$username'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $toko !== 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_rute.id_rute = '$rute' AND tb_kunjungan.id_toko = '$toko' AND tb_kunjungan.username = '$username'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $toko !== 'Semua' && $username !== 'Semua') {
    $query .= " WHERE tb_kunjungan.tanggal_kunjungan = '$tanggal' AND tb_rute.id_rute = '$rute' AND tb_kunjungan.id_toko = '$toko' AND tb_kunjungan.username = '$username'";
}

$query .= " ORDER BY tb_kunjungan.tanggal_kunjungan DESC, tb_kunjungan.waktu_kunjungan DESC";

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
echo "<th class='.title-atribut-data-absensi'>No</th>";
echo "<th class='.title-atribut-data-absensi'>Nama Lengkap</th>";
echo "<th class='.title-atribut-data-absensi'>Username</th>";
echo "<th class='.title-atribut-data-absensi'>Tanggal Kunjungan</th>";
echo "<th class='.title-atribut-data-absensi'>Waktu Kunjungan</th>";
echo "<th class='.title-atribut-data-absensi'>Nama Rute</th>";
echo "<th class='.title-atribut-data-absensi'>Nama Toko</th>";
echo "<th class='.title-atribut-data-absensi'>Koordinat Kunjungan</th>";
echo "<th class='.title-atribut-data-absensi'>Lokasi Kunjungan</th>";
echo "<th class='.title-atribut-data-absensi'>Detail</th>";
echo "</tr>";

$counter = 1;
// Tampilkan data dalam tabel
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $counter . "</td>";
        $counter++;
    echo "<td>" . $row['nama_lengkap'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['tanggal_kunjungan'] . "</td>";
    echo "<td>" . $row['waktu_kunjungan'] . "</td>";
    echo "<td>" . $row['nama_rute'] . "</td>";
    echo "<td>" . $row['nama_toko'] . "</td>";
    echo "<td>" . $row['latitude_kunjungan'] . ", " . $row['longitude_kunjungan'] . "</td>";
    echo "<td>" . $row['lokasi_kunjungan'] . "</td>";
    echo "<td>" . createDetailKunjunganLink($row['id_kunjungan']) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";
?>
