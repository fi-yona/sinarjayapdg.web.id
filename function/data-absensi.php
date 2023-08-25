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

require_once 'dbconfig.php';

$bulan = date('m');

function createDetailAbsensiLink($id_absensi)
{
    $link = '<a href="detail-absensi.php?id_absensi=' . $id_absensi . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
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
            tb_user ON tb_absensi.username = tb_user.username
        WHERE
            MONTH(tanggal_absensi) = '$bulan'
        ORDER BY
            tb_absensi.tanggal_absensi DESC, tb_absensi.waktu_masuk DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>";
    echo "<p>*Dalam bulan ini</p>";
    echo "<p>Total Data: " . $total . "</p>";
    echo "</div>";
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
        echo "<td><center>" . $counter . "</center></td>";
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
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data absensi untuk bulan ini.</p>";
}
?>
