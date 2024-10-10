<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "tiket_wisata";
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registrasi Admin
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Simpan password tanpa enkripsi

    // Cek apakah username sudah ada
    $query = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "Username sudah terdaftar!";
    } else {
        $query = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
        if ($conn->query($query) === TRUE) {
            echo "Registrasi berhasil! Silakan login.";
        } else {
            echo "Error: " . $conn->error; // Menampilkan error jika ada
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Admin</title>
</head>
<body>
    <h1>Registrasi Admin</h1>
    <form method="post" action="">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <button type="submit" name="register">Registrasi</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
