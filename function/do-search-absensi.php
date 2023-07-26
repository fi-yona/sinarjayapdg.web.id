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

function createDetailAbsensiLink($id_absensi)
{
    $link = '<a href="detail-absensi.php?id_absensi=' . $id_absensi . '">Detail</a>';
    return $link;
}

// Ambil nilai tanggal dan username dari request POST
$tanggal = isset($_POST['tanggal_search']) ? $_POST['tanggal_search'] : '';
$username = isset($_POST['username_search']) ? $_POST['username_search'] : '';

// Buat query untuk pencarian data absensi berdasarkan tanggal dan username
$query = "SELECT
            tb_absensi.id_absensi,
            tb_karyawan.nama_lengkap,
            tb_user.username,
            tb_absensi.tanggal_absensi,
            tb_absensi.waktu_masuk,
            tb_absensi.latitude_masuk,
            tb_absensi.longitude_masuk,
            tb_absensi.lokasi_masuk,
            tb_absensi.keterangan_masuk,
            tb_absensi.waktu_pulang,
            tb_absensi.latitude_pulang,
            tb_absensi.longitude_pulang,
            tb_absensi.lokasi_pulang,
            tb_absensi.keterangan_pulang
        FROM
            tb_absensi
        JOIN
            tb_karyawan ON tb_absensi.username = tb_karyawan.username
        JOIN
            tb_user ON tb_absensi.username = tb_user.username";

// Tambahkan kondisi untuk tanggal dan username jika diberikan nilai
if (!empty($tanggal) && $username === 'Semua') {
    $query .= " WHERE tb_absensi.tanggal_absensi = '$tanggal'";
} elseif (empty($tanggal) && $username !== 'Semua') {
    $query .= " WHERE tb_absensi.username = '$username'";
} elseif (!empty($tanggal) && $username !== 'Semua') {
    $query .= " WHERE tb_absensi.username = '$username' AND tb_absensi.tanggal_absensi = '$tanggal'";
}

$query .= " ORDER BY tb_absensi.tanggal_absensi DESC, tb_absensi.waktu_masuk DESC";

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
echo "<th class='.title-atribut-data-absensi'>Tanggal</th>";
echo "<th class='.title-atribut-data-absensi'>Waktu Masuk</th>";
echo "<th class='.title-atribut-data-absensi'>Koordinat Masuk</th>";
echo "<th class='.title-atribut-data-absensi'>Lokasi Masuk</th>";
echo "<th class='.title-atribut-data-absensi'>Keterangan Masuk</th>";
echo "<th class='.title-atribut-data-absensi'>Waktu Pulang</th>";
echo "<th class='.title-atribut-data-absensi'>Koordinat Pulang</th>";
echo "<th class='.title-atribut-data-absensi'>Lokasi Pulang</th>";
echo "<th class='.title-atribut-data-absensi'>Keterangan Pulang</th>";
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
    echo "<td>" . $row['tanggal_absensi'] . "</td>";
    echo "<td>" . $row['waktu_masuk'] . "</td>";
    echo "<td>" . $row['latitude_masuk'] . ", " . $row['longitude_masuk'] . "</td>";
    echo "<td>" . $row['lokasi_masuk'] . "</td>";
    echo "<td>" . $row['keterangan_masuk'] . "</td>";
    echo "<td>" . $row['waktu_pulang'] . "</td>";
    echo "<td>" . $row['latitude_pulang'] . ", " . $row['longitude_pulang'] . "</td>";
    echo "<td>" . $row['lokasi_pulang'] . "</td>";
    echo "<td>" . $row['keterangan_pulang'] . "</td>";
    echo "<td>" . createDetailAbsensiLink($row['id_absensi']) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";
?>
