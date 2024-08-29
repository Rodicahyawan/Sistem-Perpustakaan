<?php
// Include file koneksi
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul_buku = $_POST['bookTitle'];
    $penulis = $_POST['bookAuthor'];
    $tahun_terbit = $_POST['bookYear'];
    $genre = $_POST['bookGenre'];
    $status_peminjaman = 'Tersedia';  // Atur default status peminjaman

    // Query untuk memanggil stored procedure tambah_buku
    $sql = "CALL tambah_buku(?, ?, ?, ?, ?)";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("ssiss", $judul_buku, $penulis, $tahun_terbit, $genre, $status_peminjaman);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data buku berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data buku: " . $stmt->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "Gagal mempersiapkan statement: " . $mysqli->error;
    }
}

// Menutup koneksi
$mysqli->close();
?>
