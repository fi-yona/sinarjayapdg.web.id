<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Admin') {
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

require_once 'dbconfig.php';

function createDetailUserLink($username)
{
    $link = '<a href="detail-user.php?username=' . $username . '">Detail</a>';
    return $link;
}

// Ambil nilai dari request POST
$role = isset($_POST['role_search']) ? $_POST['role_search'] : '';
$status = isset($_POST['status_search']) ? $_POST['status_search'] : '';
$kataKunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : '';

// Buat query untuk pencarian data
$query = "SELECT
            username,
            role,
            status_akun
            FROM 
            tb_user";

// Array asosiatif untuk menyimpan nama kolom dan nilainya
$filterConditions = array(
    'status_akun' => "status_akun = '$status'",
    'role' => "role = '$role'",
    'username' => "username LIKE '%$kataKunci%'"
);

// Buat array untuk menyimpan kondisi WHERE yang akan digunakan
$whereConditions = array();

// Periksa apakah nilai role bukan 'Semua'
if ($role !== 'Semua') {
    $whereConditions[] = "role = '$role'";
}

// Periksa apakah nilai status_akun bukan 'Semua'
if ($status !== 'Semua') {
    $whereConditions[] = "status_akun = '$status'";
}

if (!empty($kataKunci)) {
    // Jika tidak diisi, tambahkan kondisi jatuh_tempo
    $whereConditions[] = "username LIKE '%$kataKunci%'";
}

// Iterasi melalui array filter dan cek apakah nilainya tidak kosong
foreach ($filterConditions as $columnName => $condition) {
    
    if ($columnName === 'role' && $role === 'Semua') {
        continue; // Lewatkan kondisi WHERE untuk username jika nilainya 'Semua'
    }

    if ($columnName === 'status_akun' && $status === 'Semua') {
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

$query .= " ORDER BY username ASC";

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
    echo "<div class='total-data'>";
    //echo "<p>*Dalam bulan ini</p>";
    echo "<p>Total Data: " . $total . "</p>";
    echo "</div>";
    echo "<table class='table-search-result'>";
    echo "<tr>";
    echo "<th class='.title-atribut-data-user'>No</th>";
    echo "<th class='.title-atribut-data-user'>Username</th>";
    echo "<th class='.title-atribut-data-user'>Role</th>";
    echo "<th class='.title-atribut-data-user'>Status Akun</th>";
    echo "<th class='.title-atribut-data-user'>Detail</th>";
    echo "</tr>";

    $counter = 1;
    // Tampilkan data dalam tabel
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><center>" . $counter . "</center></td>";
            $counter++;
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . $row['status_akun'] . "</td>";
        echo "<td>" . createDetailUserLink($row['username']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data user yang ditemukan.</p>";
}
?>
