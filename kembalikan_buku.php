// Dalam kembalikan_buku.php
include 'koneksi.php';

$id_peminjaman = $_POST['id_peminjaman'];

// Ambil id_buku dari tabel peminjaman
$query = "SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_peminjaman);
$stmt->execute();
$stmt->bind_result($id_buku);
$stmt->fetch();
$stmt->close();

// Hapus data peminjaman
$query = "DELETE FROM peminjaman WHERE id_peminjaman = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_peminjaman);
$stmt->execute();
$stmt->close();

// Update status buku menjadi tersedia
$updateQuery = "UPDATE buku SET status_peminjaman = 'tersedia' WHERE id_buku = ?";
$stmt = $mysqli->prepare($updateQuery);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$stmt->close();

$mysqli->close();
