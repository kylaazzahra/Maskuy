<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "tiket_wisata";
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM tickets WHERE id='$id'");
    $ticket = $result->fetch_assoc();
} else {
    header("Location: admin.php");
}

if (isset($_POST['edit_ticket'])) {
    $nama_tiket = $_POST['nama_tiket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $query = "UPDATE tickets SET nama_tiket='$nama_tiket', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'";
    $conn->query($query);
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Tiket</title>
</head>
<body>
    <h1>Edit Tiket</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
        Nama Tiket: <input type="text" name="nama_tiket" value="<?php echo $ticket['nama_tiket']; ?>" required>
        Harga: <input type="text" name="harga" value="<?php echo $ticket['harga']; ?>" required>
        Deskripsi: <textarea name="deskripsi" required><?php echo $ticket['deskripsi']; ?></textarea>
        <button type="submit" name="edit_ticket">Simpan Perubahan</button>
    </form>
    <a href="admin.php">Kembali</a>
</body>
</html>
