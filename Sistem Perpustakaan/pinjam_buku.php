<?php
session_start();

if (!isset($_SESSION['id_anggota'])) {
    // Jika pengguna belum login, arahkan ke halaman login atau tampilkan pesan error
    header("Location: login.php"); // Arahkan ke halaman login
    exit();
}

include 'koneksi.php'; 

$id_buku = $_POST['id_buku'];
$id_anggota = $_SESSION['id_anggota'];
$tanggal_peminjaman = date('Y-m-d');
$tanggal_kembali = date('Y-m-d', strtotime('+5 days'));

// Cek apakah buku sedang dipinjam
$cekQuery = "SELECT status_peminjaman FROM buku WHERE id_buku = ?";
$stmt = $mysqli->prepare($cekQuery);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$stmt->bind_result($status_peminjaman);
$stmt->fetch();
$stmt->close();

if ($status_peminjaman === 'dipinjam') {
    die("Error: Buku sedang dipinjam oleh anggota lain.");
}

// Update status buku menjadi dipinjam
$updateQuery = "UPDATE buku SET status_peminjaman = 'dipinjam' WHERE id_buku = ?";
$stmt = $mysqli->prepare($updateQuery);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$stmt->close();

// Masukkan data peminjaman ke tabel `peminjaman`
$query = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_peminjaman, tanggal_kembali) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("iiss", $id_buku, $id_anggota, $tanggal_peminjaman, $tanggal_kembali);

if ($stmt->execute()) {
    echo "Buku berhasil dipinjam. Batas pengembalian: " . $tanggal_kembali;
} else {
    echo "Error: Tidak bisa menyimpan data ke tabel peminjaman.";
}

$stmt->close();
$mysqli->close();
?>
