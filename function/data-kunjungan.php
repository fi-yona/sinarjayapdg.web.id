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

function createDetailKunjunganLink($id_kunjungan)
{
    $link = '<a href="detail-kunjungan.php?id_kunjungan=' . $id_kunjungan . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_kunjungan.id_kunjungan,
            tb_karyawan.nama_lengkap,
            tb_kunjungan.username,
            tb_kunjungan.tanggal_kunjungan,
            tb_kunjungan.waktu_kunjungan,
            tb_toko.nama_toko,
            tb_kunjungan.latitude_kunjungan,
            tb_kunjungan.longitude_kunjungan,
            tb_kunjungan.lokasi_kunjungan
        FROM
            tb_kunjungan
        JOIN
            tb_karyawan ON tb_kunjungan.username = tb_karyawan.username
        JOIN
            tb_toko ON tb_kunjungan.id_toko = tb_toko.id_toko
        ORDER BY
            tb_kunjungan.tanggal_kunjungan DESC, tb_kunjungan.waktu_kunjungan DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-absensi'>Nama Lengkap</th>";
    echo "<th class='.title-atribut-data-absensi'>Username</th>";
    echo "<th class='.title-atribut-data-absensi'>Tanggal Kunjungan</th>";
    echo "<th class='.title-atribut-data-absensi'>Waktu Kunjungan</th>";
    echo "<th class='.title-atribut-data-absensi'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-absensi'>Koordinat Kunjungan</th>";
    echo "<th class='.title-atribut-data-absensi'>Lokasi Kunjungan</th>";
    echo "<th class='.title-atribut-data-absensi'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['tanggal_kunjungan'] . "</td>";
        echo "<td>" . $row['waktu_kunjungan'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . $row['latitude_kunjungan'] . ", " . $row['longitude_kunjungan'] . "</td>";
        echo "<td>" . $row['lokasi_kunjungan'] . "</td>";
        echo "<td>" . createDetailKunjunganLink($row['id_kunjungan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data kunjungan.</p>";
}
?>