<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
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

// Query SQL
$sql = "SELECT 
            username,
            role,
            status_akun 
        FROM 
            tb_user
        ORDER BY
            username ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data'>Total Data: " . $total . "</div>";
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
} else {
    // Jika query tidak mengembalikan hasil
    echo "<p>Tidak ada data user.</p>";
}
?>
