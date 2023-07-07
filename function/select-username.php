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
            tb_user.username,
            tb_karyawan.nama_lengkap
        FROM
            tb_user
        INNER JOIN
            tb_karyawan ON tb_user.username = tb_karyawan.username
        WHERE
            tb_user.role = 'Sales'
        ORDER BY 
            tb_user.username ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['username'] . "'>" . $row['username'] . " (" . $row['nama_lengkap'] . ")</option>";
    }
}
?>
