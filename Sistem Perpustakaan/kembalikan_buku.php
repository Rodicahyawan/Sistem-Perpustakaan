<?php
session_start();
include 'koneksi.php'; 

$id_peminjaman = $_POST['id_peminjaman'];

// Ambil detail peminjaman berdasarkan ID peminjaman
$queryPeminjaman = "SELECT id_buku, id_anggota, tanggal_peminjaman, tanggal_kembali FROM peminjaman WHERE id_peminjaman = ?";
$stmt = $mysqli->prepare($queryPeminjaman);
$stmt->bind_param("i", $id_peminjaman);
$stmt->execute();
$stmt->bind_result($id_buku, $id_anggota, $tanggal_peminjaman, $tanggal_kembali);
$stmt->fetch();
$stmt->close();

// Hitung denda jika ada (misalnya: denda per hari keterlambatan)
$tanggal_pengembalian = date('Y-m-d');
$denda_per_hari = 5000;
$denda = 0;

if (strtotime($tanggal_pengembalian) > strtotime($tanggal_kembali)) {
    $hari_terlambat = (strtotime($tanggal_pengembalian) - strtotime($tanggal_kembali)) / (60 * 60 * 24);
    $denda = $hari_terlambat * $denda_per_hari;
}

// Masukkan data pengembalian ke tabel pengembalian
$queryPengembalian = "INSERT INTO pengembalian (id_peminjaman, tanggal_pengembalian, denda, status_pengembalian) VALUES (?, ?, ?, 'Selesai')";
$stmt = $mysqli->prepare($queryPengembalian);
$stmt->bind_param("isi", $id_peminjaman, $tanggal_pengembalian, $denda);
$stmt->execute();
$stmt->close();

// Hapus data peminjaman dari tabel peminjaman
$queryHapusPeminjaman = "DELETE FROM peminjaman WHERE id_peminjaman = ?";
$stmt = $mysqli->prepare($queryHapusPeminjaman);
$stmt->bind_param("i", $id_peminjaman);
$stmt->execute();
$stmt->close();

// Update status buku menjadi 'tersedia'
$queryUpdateBuku = "UPDATE buku SET status_peminjaman = 'tersedia' WHERE id_buku = ?";
$stmt = $mysqli->prepare($queryUpdateBuku);
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$stmt->close();

$mysqli->close();

header("Location: admin.php"); // Kembali ke halaman admin
exit();
?>
