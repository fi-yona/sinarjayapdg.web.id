<?php
//update sisa_pembayaran = 0, status_bayar_pesanan = "Lunas", update_at = datetime untuk id_pesanan pada tb_pesanan

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
    $id_pesanan = $_POST['id_pesanan'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $dateTime = date('Y-m-d H:i:s');

    $tokenQuery = "SELECT * FROM token WHERE update_token = '$update_token'";
    $tokenResult = $conn->query($tokenQuery);
    //jika token ada
    if ($tokenResult->num_rows > 0) {
        //cari apakah ada data sisa_pembayaran_pesanan 
        $detailSisaPembayaranQuery = "SELECT sisa_pembayaran_pesanan FROM tb_pesanan WHERE id_pesanan = $id_pesanan";
        $detailSisaPembayaranResult = $conn->query($detailSisaPembayaranQuery);
        while ($rowSisaPembayaran = $detailSisaPembayaranResult->fetch_assoc()) {
            //ambil data sisa_pembayaran_pesanan
            $sisa_pembayaran_pesanan = $rowSisaPembayaran['sisa_pembayaran_pesanan'];
            //jika nilai sisa_pembayaran_pesanan > 0
            if($sisa_pembayaran_pesanan>0){
                //sisa_pembayaran_pesanan_baru disimpan dari data $sisa_pembayaran_pesanan kurang jumlah_bayar
                $sisa_pembayaran_pesanan_baru = $sisa_pembayaran_pesanan - $jumlah_bayar;
                $updatePesananQuery = "UPDATE tb_pesanan 
                                            SET sisa_pembayaran_pesanan = '$sisa_pembayaran_pesanan_baru',
                                                update_at = '$dateTime'
                                            WHERE id_pesanan = '$id_pesanan'";
                $updatePesananResult = $conn->query($updatePesananQuery);
                $rows = array();
                if($updatePesananResult){
                    //cari apakah ada data yang belum lunas untuk id_pesanan
                    $cekDetailPesananQuery = "SELECT * FROM tb_detail_pesanan WHERE id_pesanan = $id_pesanan AND status_barang = 'Belum Lunas'";
                    $cekDetailPesananResult = $conn->query($cekDetailPesananQuery);
                    if ($cekDetailPesananResult->num_rows > 0){
                        $row['status'] = "Berhasil";
                        $row['status_bayar_pesanan'] = "Belum Lunas";
                        $rows[] = $row;
                        header('Content-Type: application/json');
                        //tampilkan status dan status_bayar_pesanan pada json
                        echo json_encode($rows);
                    }else{
                        $row['status'] = "Berhasil";
                        $row['status_bayar_pesanan'] = "Lunas";
                        $rows[] = $row;
                        header('Content-Type: application/json');
                        //tampilkan status dan status_bayar_pesanan pada json
                        echo json_encode($rows);
                    }
                }else{  
                        $row['status'] = "Gagal";
                        $row['status_bayar_pesanan'] = "";
                        $rows[] = $row;
                        header('Content-Type: application/json');
                        //tampilkan status dan status_bayar_pesanan pada json
                        echo json_encode($rows);
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
