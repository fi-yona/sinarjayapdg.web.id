<?php
session_start();

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

// Periksa apakah data telah dikirimkan
if (isset($_POST['edit-data-user'])) {
    // Ambil data dari form
    $roleExist = $_POST['role_select'];
    $roleNew = $_POST['role_new'];
    $statusAkun = $_POST['status_select'];

    if($roleExist==="Baru"){
        $role = $roleNew;
    }else{
        $role = $roleExist;
    }

    date_default_timezone_set('Asia/Jakarta');
    // Mengambil tanggal dan waktu saat ini
    $dateTime = date('Y-m-d H:i:s');

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Update data 
    $username = $_GET['username'];
    $query_update = "UPDATE tb_user 
                     SET role = '$role', 
                         status_akun = '$statusAkun', 
                         update_at = '$dateTime'
                     WHERE username = '$username'";

    if ($conn->query($query_update) === true) {
        // Jika penyimpanan berhasil
        header("Location: ../staff/admin/user/user.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data user: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
