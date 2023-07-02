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

function createDetailPenugasanLink($id_penugasan)
{
    $link = '<a href="detail-penugasan.php?id_penugasan=' . $id_penugasan . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
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
            tb_rute ON tb_penugasan.rute_penugasan = tb_rute.id_rute
        ORDER BY
            tb_penugasan.create_at DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-absensi'>Tanggal Penugasan</th>";
    echo "<th class='.title-atribut-data-absensi'>Nama Lengkap</th>";
    echo "<th class='.title-atribut-data-absensi'>Username Sales</th>";
    echo "<th class='.title-atribut-data-absensi'>Nama Rute Penugasan</th>";
    echo "<th class='.title-atribut-data-absensi'>Ditugaskan Oleh</th>";
    echo "<th class='.title-atribut-data-absensi'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['tanggal_penugasan'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username_penugasan'] . "</td>";
        echo "<td>" . $row['nama_rute'] . "</td>";
        echo "<td>" . $row['penanggung_jawab'] . "</td>";
        echo "<td>" . createDetailPenugasanLink($row['id_penugasan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data penugasan.</p>";
}
?>
