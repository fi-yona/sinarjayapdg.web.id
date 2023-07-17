<?php
require_once 'config.php';

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Endpoint untuk mendapatkan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insert_token = $_POST['insert_token'];
    $id_pesanan = $_POST['id_pesanan'];
    $id_barang = $_POST['id_barang'];
    $banyak_barang = $_POST['banyak_barang'];
    $harga_barang = $_POST['harga_barang'];
    $total_harga_barang = $_POST['total_harga_barang'];
    $keterangan_pesanan = $_POST['keterangan_pesanan'];
    $barang_lunas = $_POST['barang_lunas'];
    $status_barang = $_POST['status_barang'];

    $tokenQuery = "SELECT * FROM token WHERE insert_token = '$insert_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $tambahDetailPesananQuery = "INSERT INTO tb_detail_pesanan 
                                            (id_pesanan, 
                                            id_barang, 
                                            banyak_barang, 
                                            harga_barang, 
                                            total_harga_barang, 
                                            keterangan_pesanan,
                                            barang_lunas,
                                            status_barang) 
                                VALUES 
                                    ('$id_pesanan', 
                                    '$id_barang', 
                                    '$banyak_barang', 
                                    '$harga_barang', 
                                    '$total_harga_barang', 
                                    '$keterangan_pesanan', 
                                    '$barang_lunas',
                                    '$status_barang')";
        $tambahDetailPesananResult = $conn->query($tambahDetailPesananQuery);
        
        if ($tambahDetailPesananResult) {
            $cekBanyakBarangQuery = "SELECT 
                                banyak_barang
                            FROM 
                                tb_barang
                            WHERE 
                                id_barang = '$id_barang'";
            $cekBanyakBarangResult = $conn->query($cekBanyakBarangQuery);
            if ($cekBanyakBarangResult->num_rows > 0){
                $row = $cekBanyakBarangResult->fetch_assoc();
                $banyak_barang_data = $row['banyak_barang'];

                $banyak_barang_saat_ini = $banyak_barang_data - $banyak_barang;
                $updateBanyakBarangQuery = "UPDATE tb_barang 
                                            SET banyak_barang = '$banyak_barang_saat_ini'
                                            WHERE id_barang = '$id_barang'";
                $updateBanyakBarangResult = $conn->query($updateBanyakBarangQuery);
                if ($updateBanyakBarangResult){
                    $response = array('status' => 'Berhasil');
                    echo json_encode($response);
                }else{
                    $response = array('status' => 'Gagal');
                    echo json_encode($response);
                }
            }else{
                $response = array('status' => 'Gagal');
            echo json_encode($response);
            }
        } else {
            $response = array('status' => 'Gagal');
            echo json_encode($response);
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
