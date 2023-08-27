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

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit User</title>
        <link rel="stylesheet" href="../../../assets/style/style-body.css?v2.2">
        <link rel="stylesheet" href="../../../assets/style/style-button.css?v1.5">
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
                Edit User
            </div>
            <div class = "detail-data">
                <div class="box-green-1">
                    <form id="form-edit-data-user" class="table-form-add" action="../../../function/edit-data-user.php?username=<?php echo $username; ?>" method="POST" onsubmit="return validateForm()">
                        <table class="table-add-data">
                            <tr>
                                <th>Username</th>
                                <td><?php echo $row['username'];?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <select name="role_select" id="role_select" class="input-text-add" onchange="handleRoleSelect()">
                                        <?php require_once '../../../function/edit-select-role-user.php';?>
                                        <option value="Baru">+ Buat Baru</option>
                                    </select>
                                </td>
                                <td class="add-role" style="display: none;"><input type="text" placeholder="Masukkan role baru" name="role_new" id="role_new" class="input-text-add"></td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td>
                                    <select name="status_select" id="status_select" class="input-text-add" readonly>
                                        <option value="Aktif" <?php echo (isset($row['status_akun']) && $row['status_akun'] === 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?php echo (isset($row['status_akun']) && $row['status_akun'] === 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                </td>
                            </tr>                            
                        </table>
                        <div class="layout-button-submit">
                            <input type="submit" name="edit-data-user" class="button-submit-add" value="Submit">
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