<?php
//session_start();

require_once 'dbconfig.php';

$id_rute = $_POST['rute_search'];

if ($id_rute === 'Semua') {
    // Jika select-rute yang terpilih adalah "Semua", ambil semua data toko
    $sql = "SELECT
                id_toko,
                nama_toko
            FROM
                tb_toko
            ORDER BY 
                nama_toko ASC";
} else {
    // Jika select-rute yang terpilih bukan "Semua", ambil data toko sesuai dengan rute yang terpilih
    $sql = "SELECT
                tb_toko.id_toko,
                tb_toko.nama_toko
            FROM
                tb_toko
            WHERE 
                id_rute = '$id_rute'
            ORDER BY 
                nama_toko ASC";
}

// Eksekusi query untuk mengambil data toko
$result = mysqli_query($conn, $sql);

// Periksa hasil query dan tampilkan data toko
if (mysqli_num_rows($result) > 0) {
    echo "<option value='Semua'>Semua Toko</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_toko'] . "'>" . $row['nama_toko'] . "</option>";
    }
}
?>
