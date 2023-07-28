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

function createDetailPembayaranLink($id_pembayaran)
{
    $link = '<a href="detail-pembayaran.php?id_pembayaran=' . $id_pembayaran . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$tanggalDari = isset($_POST['tanggal_dari_search']) ? $_POST['tanggal_dari_search'] : '';
$tanggalHingga = isset($_POST['tanggal_hingga_search']) ? $_POST['tanggal_hingga_search'] : '';
$toko = isset($_POST['toko_search']) ? $_POST['toko_search'] : '';
$metodePembayaran = isset($_POST['metode_pembayaran_search']) ? $_POST['metode_pembayaran_search'] : '';
$username = isset($_POST['username_search']) ? $_POST['username_search'] : '';

// Buat query untuk pencarian data
$query = "SELECT
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
            tb_karyawan ON tb_pembayaran.username = tb_karyawan.username";

// Array asosiatif untuk menyimpan nama kolom dan nilainya
$filterConditions = array(
    'tanggal_pembayaran' => "tb_pembayaran.tanggal_pembayaran >= '$tanggalDari' AND tb_pembayaran.tanggal_pembayaran <= '$tanggalHingga'",
    'id_toko' => "tb_toko.nama_toko LIKE '%$toko%'",
    'metode_pembayaran' => "tb_pembayaran.metode_pembayaran = '$metodePembayaran'",
    'username' => "tb_pesanan.username = '$username'"
);

// Buat array untuk menyimpan kondisi WHERE yang akan digunakan
$whereConditions = array();

//echo "Tanggal Dari: " . $tanggalDari . "<br>";
//echo "Tanggal Hingga: " . $tanggalHingga . "<br>";
if (!empty($tanggalDari) && !empty($tanggalHingga)) {
    $whereConditions[] = "tb_pembayaran.tanggal_pembayaran >= '$tanggalDari' AND tb_pembayaran.tanggal_pembayaran <= '$tanggalHingga'";
}

// Periksa apakah nilai $toko bukan 'Semua'
if ($toko !== 'Semua') {
    $whereConditions[] = "tb_toko.nama_toko LIKE '%$toko%'";
}

// Periksa apakah nilai $statusBayar bukan 'Semua'
if ($metodePembayaran !== 'Semua') {
    $whereConditions[] = "tb_pembayaran.metode_pembayaran = '$metodePembayaran'";
}

// Periksa apakah nilai $username bukan 'Semua'
if ($username !== 'Semua') {
    $whereConditions[] = "tb_pesanan.username = '$username'";
}

// Iterasi melalui array filter dan cek apakah nilainya tidak kosong
foreach ($filterConditions as $columnName => $condition) {
    
    if ($columnName === 'username' && $username === 'Semua') {
        continue; // Lewatkan kondisi WHERE untuk username jika nilainya 'Semua'
    }

    if (!empty($$columnName)) {
        $whereConditions[] = $condition;
    }
}

// Buat query dengan menggabungkan kondisi WHERE
if (!empty($whereConditions)) {
    $query .= " WHERE " . implode(" AND ", $whereConditions);
}

echo '<script>logQuery(' . json_encode($query) . ');</script>';
//echo "Query: " . $query . "<br>";

$query .= " ORDER BY tb_pembayaran.tanggal_pembayaran DESC, tb_pembayaran.waktu_pembayaran DESC";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Tampilkan hasil pencarian dalam tabel
$total = mysqli_num_rows($result);
    echo "<div class='total-data'>";
    //echo "<p>*Dalam bulan ini</p>";
    echo "<p>Total Data: " . $total . "</p>";
    echo "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-pesanan'>No</th>";
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

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
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
echo "</div>";
?>
