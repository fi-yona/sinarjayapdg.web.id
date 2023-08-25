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
        header("Location: ../staff/login.html");
        echo "Anda tidak memiliki akses ke halaman ini!";
        exit();
    }
}

require_once 'dbconfig.php';

// Query SQL
$sql = "SELECT
            id_manufaktur,
            nama_manufaktur
        FROM
            tb_manufaktur
        ORDER BY 
            id_manufaktur ASC";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row2 = $result->fetch_assoc()) {
        $selected = ($row2['id_manufaktur'] == $row['id_manufaktur']) ? 'selected' : ''; //Logika untuk menandai opsi yang sesuai
        echo "<option value='" . $row2['id_manufaktur'] . "' $selected>" . $row2['nama_manufaktur'] . "</option>";
    }
}
?>
