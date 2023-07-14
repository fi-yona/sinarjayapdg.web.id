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

// Periksa apakah data promo telah dikirimkan
if (isset($_POST['edit-data-promo'])) {
    // Ambil data dari form
    $nama_promo = $_POST['nama_promo'];
    $bentuk_promo = $_POST['bentuk_promo'];
    $mulai_berlaku = $_POST['mulai_berlaku'];
    $akhir_berlaku = $_POST['akhir_berlaku'];
    $status_promo = $_POST['status_promo'];
    $keterangan = $_POST['keterangan'];

    // Lakukan validasi data jika diperlukan

    // Lakukan proses penyimpanan data ke database
    require_once 'dbconfig.php';

    // Update data promo
    $id_promo = $_GET['id_promo'];
    $query_update = "UPDATE tb_promo 
                    SET
                        nama_promo = '$nama_promo',
                        bentuk_promo = '$bentuk_promo',
                        mulai_berlaku = '$mulai_berlaku',
                        akhir_berlaku = '$akhir_berlaku',
                        status_promo = '$status_promo',
                        keterangan = '$keterangan'
                     WHERE 
                        id_promo = '$id_promo'";

    if ($conn->query($query_update) === true) {
        // Jika penyimpanan berhasil
        // Ambil semua id_barang yang ada pada tb_detail_promo untuk id_promo tertentu
        $sql_existing_ids = "SELECT id_barang FROM tb_detail_promo WHERE id_promo = '$id_promo'";
        $result_existing_ids = mysqli_query($conn, $sql_existing_ids);
        $existing_ids = [];
        while ($row_existing_ids = mysqli_fetch_assoc($result_existing_ids)) {
            $existing_ids[] = $row_existing_ids['id_barang'];
        }

        // Jika jumlah array existing_ids sama dengan jumlah array selected_barang
        // Lakukan update data untuk setiap id_barang yang terpilih pada selected_barang
        if (isset($_POST['selected_barang'])) {
            $selected_barang = $_POST['selected_barang'];
            $harga_promo = $_POST['harga_promo'];
            $keterangan_barang_promo = $_POST['keterangan_barang_promo'];

            // Loop melalui data barang yang dipilih
            for ($i = 0; $i < count($selected_barang); $i++) {
                $id_barang = $selected_barang[$i];
                $harga_barang = $harga_promo[$i];
                $keterangan_barang = $keterangan_barang_promo[$i];
                
                // Update data detail promo barang
                $query_update_detail = "UPDATE tb_detail_promo 
                                        SET
                                            harga_promo = '$harga_barang',
                                            keterangan_barang_promo = '$keterangan_barang'
                                        WHERE
                                            id_promo = '$id_promo' AND
                                            id_barang = '$id_barang'";
                $conn->query($query_update_detail);
                
                // Hapus id_barang dari existing_ids jika ada di selected_barang
                $index = array_search($id_barang, $existing_ids);
                if ($index !== false) {
                    unset($existing_ids[$index]);
                }
            }
            
            // Hapus data detail promo barang yang tidak terpilih
            foreach ($existing_ids as $id_barang) {
                $query_delete_detail = "DELETE FROM tb_detail_promo WHERE id_promo = '$id_promo' AND id_barang = '$id_barang'";
                $conn->query($query_delete_detail);
            }

            header("Location: ../staff/manajer/barang/promo.php?status=success");
            exit();
        } else {
            // Jika tidak ada barang yang terpilih, hapus semua data detail promo
            $query_delete_detail_all = "DELETE FROM tb_detail_promo WHERE id_promo = '$id_promo'";
            $conn->query($query_delete_detail_all);
            
            header("Location: ../staff/manajer/barang/promo.php?status=success");
            exit();
        }
    } else {
        // Jika terjadi kesalahan saat penyimpanan
        echo "Terjadi kesalahan saat menyimpan data promo: " . $conn->connect_error;
    }

    $conn->close();
}
?>
