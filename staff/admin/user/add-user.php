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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tambah User</title>
		<link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css">
        <link rel="stylesheet" href="../../../assets/style/style-img.css">
        <link rel="stylesheet" href="../../../assets/style/style-input.css?v2">
        <link rel="shortcut icon" href="../../../assets/img/logo.svg">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../../../script/logout1.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="../../../script/show-calender.js?v2"></script>
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
            <div class = "title-page">
                Tambah User
            </div>
            <div class = "detail-data">
                <div class = "box-green-1">
                    <form id="form-add-data-user" class="table-form-add" action="../../../function/add-data-user.php" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Username</th>
                                <td><input type="text" placeholder="Masukkan username" name="username" id="username" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="password" placeholder="Masukkan Password" name="password" id="password" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <select name="role_select" id="role_select" class="input-text-add" onchange="handleRoleSelect()">
                                        <?php require_once '../../../function/select-role-user.php';?>
                                        <option value="Baru">+ Buat Baru</option>
                                    </select>
                                </td>
                                <td class="add-role" style="display: none;"><input type="text" placeholder="Masukkan role baru" name="role_new" id="role_new" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td>
                                    <select name="status_select" id="status_select" class="input-text-add">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="add-data-user" class="button-submit-add" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class = "layout-button-data">
                <a href="javascript:history.back()"><button type="button" class="button-hapus-data">Batal</button></a>
            </div>
        </main>
        <?php include '../../../function/footer.php'; ?>
        <script>
            // Fungsi untuk memeriksa nilai awal saat halaman dimuat
            window.onload = function() {
                handleRoleSelect(); // Panggil fungsi ini untuk menyembunyikan elemen .add-role jika tidak perlu
            };

            function handleRoleSelect() {
                var selectBox = document.getElementById("role_select");
                var addRoleDiv = document.querySelector(".add-role");

                if (selectBox.value === "Baru") {
                    addRoleDiv.style.display = "block";
                } else {
                    addRoleDiv.style.display = "none";
                }
            }

            function validateForm() {
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;

                if (username.trim() === '') {
                    alert('Username tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }else if (password.trim() === '') {
                    alert('Password tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }
                
                var selectBox = document.getElementById("role_select");
                var roleNewInput = document.getElementById("role_new");

                // Jika "Baru" dipilih, pastikan role_new tidak kosong
                if (selectBox.value === "Baru" && roleNewInput.value.trim() === '') {
                    alert('Role baru tidak boleh kosong!');
                    return false; // Menghentikan pengiriman formulir
                }

                return true;
            }
        </script>
    </body>
</html>
