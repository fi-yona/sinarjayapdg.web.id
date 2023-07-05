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

function createDetailPembayaranLink($id_pembayaran)
{
    $link = '<a href="detail-pembayaran.php?id_pembayaran=' . $id_pembayaran . '">Detail</a>';
    return $link;
}

// Query SQL
$sql = "SELECT
            tb_pembayaran.id_pembayaran,
            tb_pembayaran.tanggal_pembayaran,
            tb_pembayaran.id_pesanan, 
            tb_pesanan.tanggal_pesanan,
            tb_toko.nama_toko,
            tb_pembayaran.jumlah_pembayaran,
            tb_pembayaran.metode_pembayaran,
            tb_karyawan.nama_lengkap,
            tb_pembayaran.username
        FROM 
            tb_pembayaran
        INNER JOIN 
            tb_pesanan ON tb_pembayaran.id_pesanan = tb_pesanan.id_pesanan
        INNER JOIN
            tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
        INNER JOIN 
            tb_karyawan ON tb_pembayaran.username = tb_karyawan.username
        ORDER BY 
            tb_pembayaran.tanggal_pembayaran DESC, tb_pembayaran.waktu_pembayaran DESC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-pesanan'>Id Pembayaran</th>";
    echo "<th class='.title-atribut-data-pesanan'>Tanggal Pembayaran</th>";
    echo "<th class='.title-atribut-data-pesanan'>Id Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Tanggal Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-pesanan'>Jumlah Pembayaran</th>";
    echo "<th class='.title-atribut-data-pesanan'>Metode Pembayaran</th>";
    echo "<th class='.title-atribut-data-pesanan'>Diterima Oleh</th>";
    echo "<th class='.title-atribut-data-pesanan'>Detail</th>";
    echo "</tr>";

    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_pembayaran'] . "</td>";
        echo "<td>" . $row['tanggal_pembayaran'] . "</td>";
        echo "<td>" . $row['id_pesanan'] . "</td>";
        echo "<td>" . $row['tanggal_pesanan'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . number_format($row['jumlah_pembayaran'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['metode_pembayaran'] . "</td>";
        echo "<td>" . $row['nama_lengkap'] . " (" . $row['username'] . ")" . "</td>";
        echo "<td>" . createDetailPembayaranLink($row['id_pembayaran']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data riwayat pembayaran.</p>";
}
?>
