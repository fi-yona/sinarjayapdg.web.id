<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    header("Location: ../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

$bulan = date('m');

require_once 'dbconfig.php';

function createDetailPesananLink($id_pesanan)
{
    $link = '<a href="detail-pesanan.php?id_pesanan=' . $id_pesanan . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_pesanan.id_pesanan,
            tb_pesanan.tanggal_pesanan,
            tb_pesanan.waktu_pesanan,
            tb_toko.nama_toko,
            tb_pesanan.total_harga_pesanan,
            tb_pesanan.status_bayar_pesanan,
            tb_pesanan.cara_penagihan,
            tb_pesanan.jatuh_tempo,
            tb_karyawan.nama_lengkap,
            tb_pesanan.username
        FROM 
            tb_pesanan
        INNER JOIN
            tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
        INNER JOIN
            tb_karyawan ON tb_pesanan.username = tb_karyawan.username
        WHERE
            MONTH(tanggal_pesanan) = '$bulan'
        ORDER BY
            tb_pesanan.tanggal_pesanan DESC, tb_pesanan.waktu_pesanan DESC";

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
    echo "<th class='.title-atribut-data-pesanan'>No</th>";
    echo "<th class='.title-atribut-data-pesanan'>Id Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Tanggal Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Waktu Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-pesanan'>Total Harga Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Status Bayar</th>";
    echo "<th class='.title-atribut-data-pesanan'>Cara Penagihan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Tanggal Jatuh Tempo</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Sales</th>";
    echo "<th class='.title-atribut-data-pesanan'>Username Sales</th>";
    echo "<th class='.title-atribut-data-pesanan'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['id_pesanan'] . "</td>";
        echo "<td>" . $row['tanggal_pesanan'] . "</td>";
        echo "<td>" . $row['waktu_pesanan'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . number_format($row['total_harga_pesanan'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['status_bayar_pesanan'] . "</td>";
        echo "<td>" . $row['cara_penagihan'] . "</td>";
        echo "<td>" . $row['jatuh_tempo'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . createDetailPesananLink($row['id_pesanan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data riwayat pesanan.</p>";
}
?>
