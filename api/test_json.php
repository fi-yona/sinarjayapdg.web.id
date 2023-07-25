<?php
    $row['status'] = "Berhasil";
    $rows[] = $row;
    header('Content-Type: application/json');
    //tampilkan status dan status_bayar_pesanan pada json
    echo json_encode($rows);
?>