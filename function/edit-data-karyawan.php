<?php
session_start();

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

// Periksa apakah data karyawan telah dikirimkan
if (isset($_POST['edit-data-karyawan'])) {
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

    // Mengambil tanggal dan waktu saat ini
    $dateTime = date('Y-m-d H:i:s');

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
        // Update data 
        $id_karyawan = $_GET['id_karyawan'];
        $query_update = "UPDATE tb_karyawan 
                        SET username = '$username', 
                            no_ktp = '$no_ktp', 
                            nama_lengkap = '$nama_lengkap', 
                            nama_panggilan = '$nama_panggilan',
                            tempat_lahir = '$tempat_lahir', 
                            tanggal_lahir = '$tanggal_lahir', 
                            jk = '$jk', 
                            agama = '$agama',
                            status = '$status', 
                            pendidikan_terakhir = '$pendidikan_terakhir', 
                            no_telp = '$no_telp',
                            email = '$email', 
                            domisili = '$domisili', 
                            jabatan = '$jabatan',
                            tanggal_diterima = '$tanggal_diterima', 
                            tanggal_berhenti = '$tanggal_berhenti', 
                            foto_karyawan = '$foto_karyawan',
                            update_at = '$dateTime'
                        WHERE id_karyawan = '$id_karyawan'";

        if ($conn->query($query_update) === true) {
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
