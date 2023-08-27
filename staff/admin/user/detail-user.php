<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../../staff/login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Admin') {
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}

$username = $_GET['username'];

require_once '../../../function/dbconfig.php';

$query = "SELECT 
                username,
                role,
                status_akun
            FROM
                tb_user
            WHERE
                username = '$username'";

// Eksekusi query
$result = $conn->query($query);

// Periksa hasil query
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Periksa apakah data ditemukan
if ($result->num_rows === 0) {
    echo "Data user tidak ditemukan";
    exit();
}

// Ambil data
$row = $result->fetch_assoc();

$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail User</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-img.css?v1.1">
        <link rel="stylesheet" href="../../../assets/style/style-input.css">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
    </head>
    <body>
        <header>
            <center>
                <h1><img src="../../../assets/img/logo-horizontal.png" class="logo-header"></h1>
            </center>
            <nav class="nav-home">
                <ul class="nav-home-ul">
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="./user.php">User</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class = "column-button-sub-menu">
                <a href="javascript:history.back()"><button type="button" class="button-sub-menu-back">Kembali</button></a>
            </div>
            <div class = "title-page">
                Detail User
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <div class = "layout-table-absensi">
                        <table class = "table-data-absensi">
                            <tr>
                                <th>Username</th>
                                <td> : </td>
                                <td><?php echo $row['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td> : </td>
                                <td><?php echo $row['role']; ?></td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td> : </td>
                                <td><?php echo $row['status_akun']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="edit-user.php?username=<?php echo $username; ?>"><button type="button" class="button-edit-data">Edit</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
    </body>
</html>