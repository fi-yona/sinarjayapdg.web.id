    <?php
    //session_start();

    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: ../staff/login.html");
        exit();
    }

    // Periksa role pengguna
    if ($_SESSION['role'] !== 'Manajer') {
        header("Location: ../staff/login.html");
        echo "Anda tidak memiliki akses ke halaman ini!";
        exit();
    }

    require_once 'dbconfig.php';

    // Query SQL
    $sql = "SELECT
                username
            FROM
                tb_user
            ORDER BY 
                username ASC";

    // Eksekusi query
    $result = mysqli_query($conn, $sql);

    // Periksa hasil query
    if (mysqli_num_rows($result) > 0) {
        while ($row2 = $result->fetch_assoc()) {
            $selected = ($row2['username'] == $row['username']) ? 'selected' : ''; // Tambahkan logika untuk menandai opsi yang sesuai
            echo "<option value='" . $row2['username'] . "' $selected>" . $row2['username'] . "</option>";
        }
    }
    ?>
