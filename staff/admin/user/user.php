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

//memuncul data berhasil tersimpan
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo '<script>alert("Data Berhasil Tersimpan");</script>';
}elseif(isset($_GET['status']) && $_GET['status'] === 'success-delete') {
    echo '<script>alert("Data Berhasil Terhapus");</script>';
}
?>

<!DOCTYPE html>
<html>
    <head>
		<title>Data User</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v8">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v5">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v3">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js?v3"></script>
	</head>
    <body>
        <header>
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
        </header>
        <main>
            <div class = "title-page">
                Data User
            </div>
            <div class = "search-column">
                <form id="form-search-user" class="form-search" action="../../../function/do-search-user.php" method="POST"> 
                    <table class="table-layout-search">
                        <tr>
                            <td class="td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="role_search" id="role_search" class="select-role">
                                        <option value="Semua">Semua</option>
                                        <?php require_once '../../../function/select-role-user.php';?>
                                    </select>
                                </div>
                            </td>
                            <td class="td-search-data">
                                <div class="box-white-black-stroke-search">
                                    <select name="status_search" id="status_search" class="select-role">
                                        <option value="Semua">Semua</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </td>
                            <td class = "td-search-tanggal">
                                <div class="box-white-black-stroke-search">
                                    <input type="text" placeholder="Masukkan Username" name="kata_kunci" id="kata_kunci" class="input-kata-kunci-long">
                                </div>
                            </td>
                            <td class = "td-button-search">
                                <input type="submit" name="search" class="button-submit-search" value="Cari Data User">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class = "add-data">
                <a href="./add-user.php"><button type="button" class="button-add-data">Tambah User</button></a>
            </div>
            <div class = "search-result">
                <?php include '../../../function/data-user.php'; ?>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            $(document).ready(function () {
                $("#form-search-user").submit(function (event) {
                    event.preventDefault(); // Mencegah submit form secara default
                    cariDataUser(); // Panggil fungsi cariDataUser() untuk melakukan AJAX request
                });

                function cariDataUser() {
                    // Ambil nilai dari elemen input
                    const role = $("#role_search").val();
                    const status = $("#status_search").val();
                    const kataKunci = $("#kata_kunci").val();

                    // Lakukan request AJAX ke halaman do-search-user.php
                    $.ajax({
                        url: '../../../function/do-search-user.php',
                        type: 'POST',
                        data: {
                            role_search: role,
                            kata_kunci: kataKunci,
                            status_search: status
                        },
                        success: function (response) {
                            console.log(response); // Cek respon dari server sebelum ditampilkan di halaman
                            // Tampilkan hasil pencarian di elemen dengan class search-result
                            $('.search-result').html(response);
                        },
                        error: function (error) {
                            alert('Terjadi kesalahan saat melakukan pencarian data user');
                        }
                    });
                }
            });
        </script>
    </body>
</html>