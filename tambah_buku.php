<?php
// Include file koneksi
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul_buku = $_POST['bookTitle'];
    $penulis = $_POST['bookAuthor'];
    $tahun_terbit = $_POST['bookYear'];
    $genre = $_POST['bookGenre'];

    // Query untuk menyimpan data ke tabel buku
    $sql = "INSERT INTO buku (judul_buku, penulis, tahun_terbit, genre) VALUES (?, ?, ?, ?)";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("ssis", $judul_buku, $penulis, $tahun_terbit, $genre);

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
