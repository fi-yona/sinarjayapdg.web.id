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

$date = date('Y-m-d');

// Query SQL
$sql = "SELECT
            tb_karyawan.nama_lengkap,
            tb_karyawan.username,
            tb_absensi.waktu_masuk,
            tb_absensi.keterangan_masuk,
            tb_absensi.waktu_pulang,
            tb_absensi.keterangan_pulang
        FROM
            tb_absensi
        INNER JOIN
            tb_karyawan ON tb_absensi.username = tb_karyawan.username
        WHERE 
            tb_absensi.tanggal_absensi = '$date'
        ORDER BY 
            tb_absensi.waktu_masuk ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='box-white-black-stroke-2'>";
    echo "<div class='total-data-home'>";
    echo "Total: " . $total;
    echo "</div>";
    echo "<div>";
    echo "<table class='table-data-home'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-home'>No</td>";
    echo "<th class='.title-atribut-data-home'>Nama Lengkap</td>";
    echo "<th class='.title-atribut-data-home'>Username</td>";
    echo "<th class='.title-atribut-data-home'>Waktu Masuk</td>";
    echo "<th class='.title-atribut-data-home'>Keterangan Masuk</td>";
    echo "<th class='.title-atribut-data-home'>Waktu Pulang</td>";
    echo "<th class='.title-atribut-data-home'>Keterangan Pulang</td>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['waktu_masuk'] . "</td>";
        echo "<td>" . $row['keterangan_masuk'] . "</td>";
        echo "<td>" . $row['waktu_pulang'] . "</td>";
        echo "<td>" . $row['keterangan_pulang'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<div class='box-white-black-stroke-2'>";
    echo "<div class='total-data-home'>";
    echo "Total: 0 (tidak ada data absensi)";
    echo "</div>";
    echo "</div>";
}
?>
