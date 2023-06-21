<?php
require_once 'dbconfig.php';

// Cek apakah form login telah disubmit
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Ambil data yang dikirim melalui form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Panggil fungsi untuk melakukan verifikasi login
    if (verifyLogin($username, $password)) {
        // Jika login berhasil, redirect ke halaman lain atau tampilkan pesan sukses
        header("Location: success.php");
        exit();
    } else {
        // Jika login gagal, redirect kembali ke halaman login atau tampilkan pesan error
        header("Location: ../staff/login.html");
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
            // Cek role dan redirect ke halaman yang sesuai
            if ($role === 'Manajer') {
                header("Location: ../staff/manajer/home.html");
                exit();
            } elseif ($role === 'Admin') {
                header("Location: ../staff/admin/home.html");
                exit();
            } else {
                // Role tidak dikenali, tampilkan pesan error atau redirect ke halaman lain
                // Contoh: tampilkan pesan error dan redirect ke halaman login
                header("Location: ../staff/login.html");
                echo "Role tidak valid!";
                exit();
            }
    } else {
        // Tidak ada pengguna dengan username tersebut, tampilkan pesan error atau redirect ke halaman lain
        // Contoh: tampilkan pesan error dan redirect ke halaman login
        header("Location: ../staff/login.html");
        echo "Username tidak ditemukan!";
        exit();
    }
}

?>
