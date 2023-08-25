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

function createDetailPesananLink($id_pesanan)
{
    $link = '<a href="detail-pesanan.php?id_pesanan=' . $id_pesanan . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$rute = isset($_POST['rute_search']) ? $_POST['rute_search'] : '';
$toko = isset($_POST['toko_search']) ? $_POST['toko_search'] : '';
$tanggal = date("Y-m-d");

// Buat query untuk pencarian data
$query = "SELECT
            tb_pesanan.id_pesanan,
            tb_pesanan.jatuh_tempo,
            tb_pesanan.tanggal_pesanan,
            tb_rute.nama_rute,
            tb_toko.nama_toko,
            tb_pesanan.total_harga_pesanan,
            tb_pesanan.status_bayar_pesanan,
            tb_pesanan.cara_penagihan
            FROM 
            tb_pesanan
            INNER JOIN
            tb_toko ON tb_pesanan.id_toko = tb_toko.id_toko
            INNER JOIN
            tb_karyawan ON tb_pesanan.username = tb_karyawan.username
            INNER JOIN 
            tb_rute ON tb_toko.id_rute = tb_rute.id_rute
            WHERE 
            tb_pesanan.status_bayar_pesanan = 'Belum Lunas' AND jatuh_tempo <= '$tanggal'";

// Tambahkan kondisi jika diberikan nilai
if ($rute !== 'Semua' && $toko === 'Semua') {
    $query .= " AND tb_rute.id_rute = '$rute'";
} elseif ($rute === 'Semua' && $toko !== 'Semua') {
    $query .= " AND tb_toko.id_toko = '$toko'";
} elseif ($rute !== 'Semua' && $toko !== 'Semua') {
    $query .= " AND tb_rute.id_rute = '$rute' AND tb_toko.id_toko = '$toko'";
} 

$query .= " ORDER BY tb_pesanan.jatuh_tempo ASC";

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
    echo "<th class='.title-atribut-data-pesanan'>Jatuh Tempo</th>";
    echo "<th class='.title-atribut-data-pesanan'>Tanggal Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Id Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Rute</th>";
    echo "<th class='.title-atribut-data-pesanan'>Nama Toko</th>";
    echo "<th class='.title-atribut-data-pesanan'>Total Harga Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Status Bayar Pesanan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Cara Penagihan</th>";
    echo "<th class='.title-atribut-data-pesanan'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['jatuh_tempo'] . "</td>";
        echo "<td>" . $row['tanggal_pesanan'] . "</td>";
        echo "<td>" . $row['id_pesanan'] . "</td>";
        echo "<td>" . $row['nama_rute'] . "</td>";
        echo "<td>" . $row['nama_toko'] . "</td>";
        echo "<td>" . number_format($row['total_harga_pesanan'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['status_bayar_pesanan'] . "</td>";
        echo "<td>" . $row['cara_penagihan'] . "</td>";
        echo "<td>" . createDetailPesananLink($row['id_pesanan']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data pesanan jatuh tempo yang ditemukan.</p>";
}
?>
