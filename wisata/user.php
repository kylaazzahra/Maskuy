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

// Pemesanan Tiket
if (isset($_POST['order_ticket'])) {
    if (isset($_SESSION['user_id'])) { // Pastikan user_id ada di session
        $ticket_id = $_POST['ticket_id'];
        $user_id = $_SESSION['user_id']; // Ambil ID pengguna dari session
        $query = "INSERT INTO orders (user_id, ticket_id) VALUES ('$user_id', '$ticket_id')";
        
        if ($conn->query($query) === TRUE) {
            echo "Tiket dengan ID $ticket_id berhasil dipesan!";
        } else {
            echo "Error: " . $conn->error; // Menampilkan error jika ada
        }
    } else {
        echo "Anda belum login!"; // Berikan pesan jika user belum login
    }
}

// Ambil tiket untuk ditampilkan
$tickets = $conn->query("SELECT * FROM tickets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengguna - Website Pemesanan Tiket</title>
</head>
<body>
    <h1>
        <?php 
        if (isset($_SESSION['username'])) {
            echo "Selamat datang, " . $_SESSION['username'] . "!"; 
        } else {
            echo "Anda belum login!";
        }
        ?>
    </h1>
    <a href="index.php?logout=1">Logout</a>

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
                <form method="post" action="">
                    <input type="hidden" name="ticket_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="order_ticket">Pesan</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
