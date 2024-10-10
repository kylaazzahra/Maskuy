<?php
session_start(); // Memulai session

$host = "localhost";
$username = "root";
$password = "";
$database = "tiket_wisata";
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tambah Tiket
if (isset($_POST['add_ticket'])) {
    $nama_tiket = $_POST['nama_tiket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $query = "INSERT INTO tickets (nama_tiket, harga, deskripsi) VALUES ('$nama_tiket', '$harga', '$deskripsi')";
    $conn->query($query);
    echo "Tiket berhasil ditambahkan!";
}

// Hapus Tiket
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM tickets WHERE id='$id'";
    $conn->query($query);
    header("Location: admin.php");
}

// Ambil tiket untuk ditampilkan
$tickets = $conn->query("SELECT * FROM tickets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Website Pemesanan Tiket</title>
</head>
<body>
    <h1>Dashboard Admin</h1>
    <p>
        <?php 
        // Pengecekan apakah username ada di session
        if (isset($_SESSION['username'])) {
            echo "Selamat datang, " . $_SESSION['username'] . "!";
        } else {
            echo "Anda belum login!";
        }
        ?>
    </p>
    <a href="index.php?logout=1">Logout</a>

    <h2>Tambah Tiket</h2>
    <form method="post" action="">
        Nama Tiket: <input type="text" name="nama_tiket" required>
        Harga: <input type="text" name="harga" required>
        Deskripsi: <textarea name="deskripsi" required></textarea>
        <button type="submit" name="add_ticket">Tambah Tiket</button>
    </form>

    <h2>Daftar Tiket</h2>
    <table border="1">
        <tr>
            <th>Nama Tiket</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $tickets->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nama_tiket']; ?></td>
            <td><?php echo $row['harga']; ?></td>
            <td><?php echo $row['deskripsi']; ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>">Hapus</a>
                <a href="edit_ticket.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
