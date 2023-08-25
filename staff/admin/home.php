<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login.html");
    exit();
}

// Periksa role pengguna
if ($_SESSION['role'] !== 'Admin') {
    header("Location: ../staff/login.html");
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Home</title>
		<link rel="stylesheet" href="../../assets/style/style-body.css">
        <link rel="stylesheet" href="../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../assets/style/style-input.css">
        <link rel="shortcut icon" href="../../assets/img/logo.svg">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../script/logout.js"></script>
	</head>
    <body>
        <header>
            <center>
                <h1><img src="../../assets/img/logo-horizontal.png" class="logo-header"></h1>
            </center>
            <nav class="nav-home">
                <ul class="nav-home-ul">
                    <li><a href="./home.php">Home</a></li>
                    <li><a href="./karyawan/karyawan.php">Karyawan</a></li>
                    <li><a href="./user/user.php">User</a></li>
                    <li><a href="#" onclick="logout()"><button type="button" class="btn-log-out">Log Out</button></a></li>
                </ul>
            </nav>
        </header>
        <main>
        <table class="table-layout-home">
                <tr>
                    <td>
                        <div class="box-white-black-stroke-3">
                            <div class="title-data-home">
                                Total Karyawan
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Aktif
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Karyawan)
                                </div>
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Seluruhnya
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data Karyawan)
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="box-white-black-stroke-4">
                            <div class="title-data-home">
                                Total User
                            </div>
                            <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Akun Aktif
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data User)
                                </div>
                                </div>
                                <div class="box-white-black-stroke-2">
                                <div class="title-nama-data-home">
                                    Seluruhnya
                                </div>
                                <div class="total-data-home">
                                    Total: (Jumlah Data User)
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </main>
        <?php include '../../function/footer.php'; ?>
    </body>
</html>