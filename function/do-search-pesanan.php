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

function createDetailPesananLink($id_pesanan)
{
    $link = '<a href="detail-pesanan.php?id_pesanan=' . $id_pesanan . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$tanggalDari = isset($_POST['tanggal_dari_search']) ? $_POST['tanggal_dari_search'] : '';
$tanggalHingga = isset($_POST['tanggal_hingga_search']) ? $_POST['tanggal_hingga_search'] : '';
$toko = isset($_POST['toko_search']) ? $_POST['toko_search'] : '';
$statusBayar = isset($_POST['status_bayar_search']) ? $_POST['status_bayar_search'] : '';
$caraPenagihan = isset($_POST['cara_penagihan_search']) ? $_POST['cara_penagihan_search'] : '';
$jatuhTempo = isset($_POST['jatuh_tempo_search']) ? $_POST['jatuh_tempo_search'] : '';
$username = isset($_POST['username_search']) ? $_POST['username_search'] : '';

// Buat query untuk pencarian data kunjungan
$query = "SELECT
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
            tb_karyawan ON tb_pesanan.username = tb_karyawan.username";

// Array asosiatif untuk menyimpan nama kolom dan nilainya
$filterConditions = array(
    'tanggal_pesanan' => "tb_pesanan.tanggal_pesanan >= '$tanggalDari' AND tb_pesanan.tanggal_pesanan <= '$tanggalHingga'",
    'id_toko' => "tb_toko.id_toko = '$toko'",
    'status_bayar_pesanan' => "tb_pesanan.status_bayar_pesanan = '$statusBayar'",
    'cara_penagihan' => "tb_pesanan.cara_penagihan = '$caraPenagihan'",
    'jatuh_tempo' => "tb_pesanan.jatuh_tempo = '$jatuhTempo'",
    'username' => "tb_pesanan.username = '$username'"
);

// Buat array untuk menyimpan kondisi WHERE yang akan digunakan
$whereConditions = array();

//echo "Tanggal Dari: " . $tanggalDari . "<br>";
//echo "Tanggal Hingga: " . $tanggalHingga . "<br>";
if (!empty($tanggalDari) && !empty($tanggalHingga)) {
    $whereConditions[] = "tb_pesanan.tanggal_pesanan >= '$tanggalDari' AND tb_pesanan.tanggal_pesanan <= '$tanggalHingga'";
}

// Periksa apakah nilai $toko bukan 'Semua'
if ($toko !== 'Semua') {
    $whereConditions[] = "tb_toko.id_toko = '$toko'";
}

// Periksa apakah nilai $statusBayar bukan 'Semua'
if ($statusBayar !== 'Semua') {
    $whereConditions[] = "tb_pesanan.status_bayar_pesanan = '$statusBayar'";
}

// Periksa apakah nilai $caraPenagihan bukan 'Semua'
if ($caraPenagihan !== 'Semua') {
    $whereConditions[] = "tb_pesanan.cara_penagihan = '$caraPenagihan'";
}

if (!empty($jatuhTempo)) {
    // Jika $jatuhTempo tidak diisi, tambahkan kondisi jatuh_tempo
    $whereConditions[] = "tb_pesanan.jatuh_tempo = '$jatuhTempo'";
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

$query .= " ORDER BY tb_pesanan.tanggal_pesanan DESC, tb_pesanan.waktu_pesanan DESC";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . $conn->error);
}

// Tampilkan hasil pencarian dalam tabel
$total = mysqli_num_rows($result);
    echo "<div class='total-data'>";
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
echo "</div>";
?>
