<?php
session_start();

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

$id_promo = $_GET['id_promo'];

// Periksa apakah data barang telah dikirimkan
if (isset($_POST['add-edit-data-promo'])) {
    // Ambil data dari form
    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Periksa apakah ada data barang yang dipilih
    if (isset($_POST['selected_barang'])) {
        $selected_barang = $_POST['selected_barang'];
        $harga_promo = $_POST['harga_promo'];
        $keterangan_barang_promo = $_POST['keterangan_barang_promo'];

        // Loop melalui data barang yang dipilih
        for ($i = 0; $i < count($selected_barang); $i++) {
            $id_barang = $selected_barang[$i];
            $harga_barang = $harga_promo[$i];
            $keterangan_barang = $keterangan_barang_promo[$i];

            // Insert data detail promo barang
            $query_insert_detail = "INSERT INTO tb_detail_promo (id_promo, id_barang, harga_promo, keterangan_barang_promo) 
                                    VALUES ('$id_promo', '$id_barang', '$harga_barang', '$keterangan_barang')";
            $conn->query($query_insert_detail);
        }
    }
    header("Location: ../staff/manajer/barang/promo.php?status=success");
    exit();

}
?>
