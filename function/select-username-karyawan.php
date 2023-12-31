<?php
//session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    if ($_SESSION['role'] !== 'Admin Kantor'){
        if ($_SESSION['role'] !== 'Admin'){
            echo "Anda tidak memiliki akses ke halaman ini!";
            exit();
        }
    }
}

require_once 'dbconfig.php';

// Query SQL
$sql = "SELECT
            tb_user.username
        FROM
            tb_user
        ORDER BY 
            tb_user.username ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
    }
}
?>
