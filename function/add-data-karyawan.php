<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Manajer') {
    if ($_SESSION['role'] !== 'Admin'){
        echo "Anda tidak memiliki akses ke halaman ini!";
        exit();
    }
}

// Periksa apakah data karyawan telah dikirimkan
if (isset($_POST['add-data-karyawan'])) {
    // Ambil data dari form
    $username = $_POST['username'];
    $no_ktp = $_POST['no_ktp'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_panggilan = $_POST['nama_panggilan'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jk'];
    $agama = $_POST['agama'];
    $status = $_POST['status'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $domisili = $_POST['domisili'];
    $jabatan = $_POST['jabatan'];
    $tanggal_diterima = $_POST['tanggal_diterima'];
    $tanggal_berhenti = $_POST['tanggal_berhenti'];
    $foto_karyawan = $_POST['foto_karyawan'];

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Cek apakah username sudah ada di tb_karyawan
    $query_check_username = "SELECT username FROM tb_karyawan WHERE username = '$username'";
    $result = $conn->query($query_check_username);
    
    if ($result->num_rows > 0) {
        // Jika username sudah ada, tampilkan pesan dan berhenti
        echo '<script>alert("Username sudah terdaftar pada karyawan yang lain!");</script>';
        echo '<script>window.history.back();</script>';
    } else {
        // Jika username belum ada, lakukan operasi INSERT
        $query_insert = "INSERT INTO 
                            tb_karyawan 
                            (username, 
                            no_ktp, 
                            nama_lengkap, 
                            nama_panggilan, 
                            tempat_lahir, 
                            tanggal_lahir, 
                            jk, 
                            agama,
                            status, 
                            pendidikan_terakhir,
                            no_telp, 
                            email,
                            domisili, 
                            jabatan,
                            tanggal_diterima, 
                            tanggal_berhenti, 
                            foto_karyawan) 
                         VALUES 
                            ('$username', 
                            '$no_ktp', 
                            '$nama_lengkap', 
                            '$nama_panggilan', 
                            '$tempat_lahir', 
                            '$tanggal_lahir', 
                            '$jk', 
                            '$agama',
                            '$status',
                            '$pendidikan_terakhir',
                            '$no_telp',
                            '$email',
                            '$domisili',
                            '$jabatan',
                            '$tanggal_diterima',
                            '$tanggal_berhenti',
                            '$foto_karyawan')";
                            
        if ($conn->query($query_insert) === true) {
            // Jika penyimpanan berhasil
            header("Location: ../staff/manajer/karyawan/karyawan.php?status=success");
            exit();
        } else {
            // Jika terjadi kesalahan saat penyimpanan
            echo "Terjadi kesalahan saat menyimpan data karyawan: " . mysqli_error($conn);
        }
    }

    $conn->close();
}
?>
