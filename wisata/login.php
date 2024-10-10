<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "tiket_wisata";
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login Admin
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data admin dari database
    $query = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($query);

    // Cek apakah username ada di database
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verifikasi password (tanpa enkripsi)
        if ($password == $admin['password']) {
            // Set session untuk admin
            $_SESSION['username'] = $admin['username']; // Ganti session menjadi 'username'
            $_SESSION['admin_id'] = $admin['id']; // Simpan ID admin di session
            
            // Redirect ke halaman admin setelah login
            header("Location: admin.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>
    <form method="post" action="login.php">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
</body>
</html>
