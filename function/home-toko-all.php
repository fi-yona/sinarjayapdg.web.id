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

require_once 'dbconfig.php';


// Query SQL
$sql = "SELECT *
        FROM
            tb_toko";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $total = mysqli_num_rows($result);
    echo "<div class='total-data-home'>";
    echo "Total: " . $total;
    echo "</div>";
} else {
    // Jika query tidak mengembalikan hasil
    echo "<div class='total-data-home'>";
    echo "Total: 0";
    echo "</div>";
}
?>
