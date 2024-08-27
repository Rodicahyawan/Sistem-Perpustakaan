<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_perpustakaan";

// Membuat koneksi
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Mendapatkan ID dari parameter URL
if (isset($_GET['id'])) {
    $id_pengembalian = $_GET['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM pengembalian WHERE id_pengembalian = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id_pengembalian);

    if ($stmt->execute()) {
        // Redirect ke halaman admin jika berhasil dihapus
        header("Location: admin.php"); // Pastikan nama file sesuai dengan nama file halaman admin Anda
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
