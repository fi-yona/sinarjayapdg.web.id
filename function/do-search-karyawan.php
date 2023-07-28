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

function createDetailKaryawanLink($id_karyawan)
{
    $link = '<a href="detail-karyawan.php?id_karyawan=' . $id_karyawan . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$kataKunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : '';

// Buat query untuk pencarian data
$query = "SELECT
            tb_karyawan.id_karyawan,
            tb_karyawan.nama_lengkap,
            tb_karyawan.nama_panggilan,
            tb_karyawan.username,
            tb_karyawan.no_telp,
            tb_karyawan.email,
            tb_karyawan.jk,
            tb_karyawan.jabatan
            FROM
            tb_karyawan";

// Tambahkan kondisi jika diberikan nilai
if (!empty($kataKunci)) {
    $query .= " WHERE nama_lengkap LIKE '%$kataKunci%' OR nama_panggilan LIKE '%$kataKunci%' OR username LIKE '%$kataKunci%' OR jabatan LIKE '%$kataKunci%'";
} 

$query .= " ORDER BY tb_karyawan.nama_lengkap ASC";

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
    echo "<th class='.title-atribut-data-karyawan'>No</th>";
    echo "<th class='.title-atribut-data-karyawan'>Id Karyawan</th>";
    echo "<th class='.title-atribut-data-karyawan'>Nama Lengkap</th>";
    echo "<th class='.title-atribut-data-karyawan'>Username</th>";
    echo "<th class='.title-atribut-data-karyawan'>Nomor Telepon</th>";
    echo "<th class='.title-atribut-data-karyawan'>Email</th>";
    echo "<th class='.title-atribut-data-karyawan'>Jenis Kelamin</th>";
    echo "<th class='.title-atribut-data-karyawan'>Jabatan</th>";
    echo "<th class='.title-atribut-data-karyawan'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
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
echo "</div>";

$conn -> close();
?>
