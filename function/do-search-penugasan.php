<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
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

function createDetailPenugasanLink($id_penugasan)
{
    $link = '<a href="detail-penugasan.php?id_penugasan=' . $id_penugasan . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$tanggal = isset($_POST['tanggal_search']) ? $_POST['tanggal_search'] : '';
$rute = isset($_POST['rute_search']) ? $_POST['rute_search'] : '';
$username_penugasan = isset($_POST['username_penugasan_search']) ? $_POST['username_penugasan_search'] : '';
$penanggung_jawab = isset($_POST['penanggung_jawab_search']) ? $_POST['penanggung_jawab_search'] : '';

// Buat query untuk pencarian data
$query = "SELECT
                tb_penugasan.id_penugasan,
                tb_penugasan.tanggal_penugasan,
                tb_karyawan.nama_lengkap,
                tb_penugasan.username_penugasan,
                tb_rute.nama_rute,
                tb_penugasan.penanggung_jawab
            FROM
                tb_penugasan
            JOIN
                tb_karyawan ON tb_penugasan.username_penugasan = tb_karyawan.username
            JOIN
                tb_rute ON tb_penugasan.rute_penugasan = tb_rute.id_rute";

// Tambahkan kondisi jika diberikan nilai
if (!empty($tanggal) && $rute === 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.rute_penugasan = '$rute'";
} elseif (empty($tanggal) && $rute === 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.username_penugasan = '$username_penugasan'";
} elseif (empty($tanggal) && $rute === 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.rute_penugasan = '$rute'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.username_penugasan = '$username_penugasan'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.username_penugasan = '$username_penugasan'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (empty($tanggal) && $rute === 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.username_penugasan = '$username_penugasan' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab === 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.username_penugasan = '$username_penugasan'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $username_penugasan === 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (!empty($tanggal) && $rute === 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.username_penugasan = '$username_penugasan' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (empty($tanggal) && $rute !== 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.username_penugasan = '$username_penugasan' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
} elseif (!empty($tanggal) && $rute !== 'Semua' && $username_penugasan !== 'Semua' && $penanggung_jawab !== 'Semua') {
    $query .= " WHERE tb_penugasan.tanggal_penugasan = '$tanggal' AND tb_penugasan.rute_penugasan = '$rute' AND tb_penugasan.username_penugasan = '$username_penugasan' AND tb_penugasan.penanggung_jawab = '$penanggung_jawab'";
}

$query .= " ORDER BY tb_penugasan.tanggal_penugasan DESC, tb_penugasan.create_at DESC";

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
    echo "<th class='.title-atribut-data-absensi'>Tanggal Penugasan</th>";
    echo "<th class='.title-atribut-data-absensi'>Nama Lengkap</th>";
    echo "<th class='.title-atribut-data-absensi'>Username Sales</th>";
    echo "<th class='.title-atribut-data-absensi'>Nama Rute Penugasan</th>";
    echo "<th class='.title-atribut-data-absensi'>Ditugaskan Oleh</th>";
    echo "<th class='.title-atribut-data-absensi'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
            $counter++;
        echo "<td>" . $row['tanggal_penugasan'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username_penugasan'] . "</td>";
        echo "<td>" . $row['nama_rute'] . "</td>";
        echo "<td>" . $row['penanggung_jawab'] . "</td>";
        echo "<td>" . createDetailPenugasanLink($row['id_penugasan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data penugasan yang ditemukan.</p>";
}
?>
