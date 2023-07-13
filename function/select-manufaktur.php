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
            id_manufaktur,
            nama_manufaktur
        FROM
            tb_manufaktur
        ORDER BY 
            nama_manufaktur ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_manufaktur'] . "'>" . $row['nama_manufaktur'] . "</option>";
    }
}
?>
