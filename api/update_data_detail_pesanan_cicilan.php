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
    $update_token = $_POST['update_token'];
    $id_dt_pesanan = $_POST['id_dt_pesanan'];
    $banyak_barang_bayar = $_POST['banyak_barang_bayar'];
    $dateTime = date('Y-m-d H:i:s');

    $tokenQuery = "SELECT * FROM token WHERE update_token = '$update_token'";
    $tokenResult = $conn->query($tokenQuery);

    if ($tokenResult->num_rows > 0) {
        $selectDetailPesananQuery = "SELECT 
                                        barang_lunas, 
                                        banyak_barang
                                    FROM 
                                        tb_detail_pesanan
                                    WHERE 
                                        id_dt_pesanan = $id_dt_pesanan";
        $selectDetailPesananResult = $conn->query($selectDetailPesananQuery);
        $rowsDetail = array();
        while ($rowDetail = $selectDetailPesananResult->fetch_assoc()) {
            $barang_lunas = $rowDetail['barang_lunas'];
            $banyak_barang = $rowDetail['banyak_barang'];
            $barang_lunas_baru = $banyak_barang_bayar + $barang_lunas;
            if($banyak_barang==$barang_lunas_baru){
                $status_barang = "Lunas";
                $updateDetailPesananQuery = "UPDATE tb_detail_pesanan 
                                            SET barang_lunas = '$barang_lunas_baru',
                                                status_barang = '$status_barang'
                                            WHERE id_dt_pesanan = '$id_dt_pesanan'";
                $updateDetailPesananResult = $conn->query($updateDetailPesananQuery);
                
                if ($updateDetailPesananResult) {
                    $response = array('status' => 'Berhasil');
                    echo json_encode($response);
                } else {
                    $response = array('status' => 'Gagal');
                    echo json_encode($response);
                }
            }else{
                $updateDetailPesananQuery = "UPDATE tb_detail_pesanan 
                                            SET barang_lunas = '$barang_lunas_baru',
                                                update_at = '$dateTime'
                                            WHERE id_dt_pesanan = '$id_dt_pesanan'";
                $updateDetailPesananResult = $conn->query($updateDetailPesananQuery);
                
                if ($updateDetailPesananResult) {
                    $response = array('status' => 'Berhasil');
                        echo json_encode($response);
                } else {
                    $response = array('status' => 'Gagal');
                    echo json_encode($response);
                }
            }
        }
    } else {
        header('HTTP/1.1 401 Unauthorized');
        $response = array('message' => 'Invalid token');
        echo json_encode($response);
    }
}

$conn->close();

?>
