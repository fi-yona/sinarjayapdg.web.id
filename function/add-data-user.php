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

// Periksa apakah data user telah dikirimkan
if (isset($_POST['add-data-user'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roleExist = $_POST['role_select'];
    $roleNew = $_POST['role_new'];
    $statusAkun = $_POST['status_select'];
    
    if($roleExist==="Baru"){
        $role = $roleNew;
    }else{
        $role = $roleExist;
    }

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Cek apakah username sudah ada di tb_user
    $query_check_username = "SELECT username FROM tb_user WHERE username = '$username'";
    $result = $conn->query($query_check_username);
    
    if ($result->num_rows > 0) {
        // Jika username sudah ada, tampilkan pesan dan berhenti
        echo '<script>alert("Username sudah terdaftar!");</script>';
        echo '<script>window.history.back();</script>';
    } else {
        // Jika username belum ada, lakukan operasi INSERT
        $query_insert = "INSERT INTO 
                            tb_user 
                            (username, 
                            password, 
                            role, 
                            status_akun) 
                         VALUES 
                            ('$username', 
                            '$password', 
                            '$role', 
                            '$statusAkun')";
                            
        if ($conn->query($query_insert) === true) {
            // Jika penyimpanan berhasil
            header("Location: ../staff/admin/user/user.php?status=success");
            exit();
        } else {
            // Jika terjadi kesalahan saat penyimpanan
            echo "Terjadi kesalahan saat menyimpan data user: " . mysqli_error($conn);
        }
    }

    $conn->close();
}
?>
