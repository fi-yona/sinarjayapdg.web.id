<?php
require_once 'dbconfig.php';
require_once '../../../staff/manajer/toko/lihat-qr-code.php';
require_once '../../../vendor/autoload.php'; // Masukkan path ke autoload.php

use Endroid\QrCode\QrCode;

$id_toko = $_GET['id_toko'];

// Ambil data toko berdasarkan id_toko
$query = "SELECT id_toko, nama_toko FROM tb_toko WHERE id_toko = '$id_toko'";
$result = $conn->query($query);

if (!$result) {
    die("Query error: " . $conn->error);
}

if ($result->num_rows === 0) {
    echo "Data toko tidak ditemukan";
    exit();
}

$row = $result->fetch_assoc();
$nama_toko = $row['nama_toko'];

// Inisialisasi objek QRCode
$qrcode = new QrCode($id_toko);
$qrcode->setSize(150);
$qrcode->setErrorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevelHigh());

// Generate QR code sebagai gambar PNG
$imagePath = "../../../assets/qrcode/"; // Ganti dengan direktori tempat Anda menyimpan gambar QR code
$imageFileName = "qrcode-$id_toko-$nama_toko.png";
$imageFilePath = $imagePath . $imageFileName;

$qrcode->writeFile($imageFilePath);

// Set header agar file dapat diunduh
header("Content-type: image/png");
header("Content-Disposition: attachment; filename=$imageFileName");
readfile($imageFilePath);
?>
