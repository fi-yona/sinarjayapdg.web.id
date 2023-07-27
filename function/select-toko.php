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
$sql = "SELECT
            id_toko,
            nama_toko
        FROM
            tb_toko
        ORDER BY 
            nama_toko ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    echo "<option value='Semua'>Semua Toko</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_toko'] . "'>" . $row['nama_toko'] . "</option>";
    }
}else{
    echo "<option value='Semua'>Semua Toko</option>";
}
?>
