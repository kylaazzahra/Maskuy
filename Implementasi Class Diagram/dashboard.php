<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit;
}

// Ambil nama admin dari sesi
$username = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>Anda berhasil login ke dashboard admin.</p>

    <a href="logout.php">Logout</a>
</body>
</html>
