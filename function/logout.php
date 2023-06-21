<?php
session_start();

// Hapus semua data session
session_unset();

// Hapus session
session_destroy();

// Redirect ke halaman login
header("Location: ../staff/login.html");
exit();
?>
