<?php
require_once 'dbconfig.php';

// Cek apakah form login telah disubmit
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Ambil data yang dikirim melalui form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Panggil fungsi untuk melakukan verifikasi login
    $loginResult = verifyLogin($username, $password);

    // Jika login berhasil, set session dan redirect ke halaman home
    if ($loginResult['success']) {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['role'] = $loginResult['role'];
        $_SESSION['username'] = $username;
        
        if ($_SESSION['role'] === 'Manajer') {
            header("Location: ../staff/manajer/home.php");
            exit();
        } elseif ($_SESSION['role'] === 'Admin') {
            // Redirect ke halaman admin
            header("Location: ../staff/admin/home.php");
            exit();
        } elseif ($_SESSION['role'] === 'Super Admin') {
            // Redirect ke halaman super admin
            header("Location: ../staff/super-admin/home.php");
            exit();
        } else {
            // Role tidak dikenali, tampilkan pesan error atau redirect ke halaman lain
            // Contoh: tampilkan pesan error dan redirect ke halaman login
            header("Location: ../staff/login.html");
            echo "Role tidak valid!";
            exit();
        }
    } else {
        // Jika login gagal, redirect kembali ke halaman login atau tampilkan pesan error
        header("Location: ../staff/login.html");
        echo $loginResult['message'];
        exit();
    }
}

// Fungsi untuk memverifikasi login
function verifyLogin($username, $password)
{
    global $conn;

    // Mencegah serangan SQL Injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query untuk mendapatkan data pengguna dengan username yang sesuai
    $query = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password' AND status_akun = 'Aktif'";
    $result = $conn->query($query);

    // Periksa apakah pengguna dengan username tersebut ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        // Kembalikan hasil verifikasi
        return array('success' => true, 'role' => $role);
    } else {
        // Tidak ada pengguna dengan username tersebut, kembalikan pesan error
        return array('success' => false, 'message' => 'Username tidak ditemukan!');
    }
}
?>
