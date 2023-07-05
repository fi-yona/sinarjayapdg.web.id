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

function createDetailKaryawanLink($id_karyawan)
{
    $link = '<a href="detail-karyawan.php?id_karyawan=' . $id_karyawan . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_karyawan.id_karyawan,
            tb_karyawan.nama_lengkap,
            tb_karyawan.username,
            tb_karyawan.no_telp,
            tb_karyawan.email,
            tb_karyawan.jk,
            tb_karyawan.jabatan
        FROM
            tb_karyawan
        ORDER BY 
            tb_karyawan.nama_lengkap ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-karyawan'>Id Karyawan</th>";
    echo "<th class='.title-atribut-data-karyawan'>Nama Lengkap</th>";
    echo "<th class='.title-atribut-data-karyawan'>Username</th>";
    echo "<th class='.title-atribut-data-karyawan'>Nomor Telepon</th>";
    echo "<th class='.title-atribut-data-karyawan'>Email</th>";
    echo "<th class='.title-atribut-data-karyawan'>Jenis Kelamin</th>";
    echo "<th class='.title-atribut-data-karyawan'>Jabatan</th>";
    echo "<th class='.title-atribut-data-karyawan'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_karyawan'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['no_telp'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['jk'] . "</td>";
        echo "<td>" . $row['jabatan'] . "</td>";
        echo "<td>" . createDetailKaryawanLink($row['id_karyawan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p><center>Tidak ada data karyawan.</center></p>";
}
?>
