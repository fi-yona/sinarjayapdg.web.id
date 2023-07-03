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

function createDetailManukfakturLink($id_manukfaktur)
{
    $link = '<a href="detail-manufaktur.php?id_manufaktur=' . $id_manukfaktur . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT 
            tb_manufaktur.id_manufaktur, 
            tb_manufaktur.nama_manufaktur,
            tb_manufaktur.kontak_manufaktur,
            tb_manufaktur.email_manufaktur,
            tb_manufaktur.alamat_manufaktur,
            tb_manufaktur.kode_pos_manufaktur
        FROM
            tb_manufaktur
        ORDER BY 
            tb_manufaktur.nama_manufaktur ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-manufaktur'>Nama Manufaktur</th>";
    echo "<th class='.title-atribut-data-manufaktur'>Kontak</th>";
    echo "<th class='.title-atribut-data-manufaktur'>Email</th>";
    echo "<th class='.title-atribut-data-manufaktur'>Alamat</th>";
    echo "<th class='.title-atribut-data-manufaktur'>Kode Pos</th>";
    echo "<th class='.title-atribut-data-manufaktur'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nama_manufaktur'] . "</td>";
        echo "<td>" . $row['kontak_manufaktur'] . "</td>";
        echo "<td>" . $row['email_manufaktur'] . "</td>";
        echo "<td>" . $row['alamat_manufaktur'] . "</td>";
        echo "<td>" . $row['kode_pos_manufaktur'] . "</td>";
        echo "<td>" . createDetailManukfakturLink($row['id_manufaktur']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data manufaktur.</p>";
}
?>
