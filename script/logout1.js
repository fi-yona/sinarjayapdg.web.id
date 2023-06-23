function logout() {
    // Munculkan konfirmasi logout
    var confirmation = confirm("Apakah Anda yakin ingin logout?");

    // Jika pengguna mengkonfirmasi logout
    if (confirmation) {
        // Redirect ke halaman logout.php
        window.location.href = "../../../function/logout.php";
    }
}
