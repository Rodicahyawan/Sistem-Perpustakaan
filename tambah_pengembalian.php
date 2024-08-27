<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_peminjaman = $_POST['returnLoanId'];
    $tanggal_pengembalian = $_POST['returnDate'];
    $denda = $_POST['returnFine'];
    $status_pengembalian = $_POST['returnStatus'];

    // Query untuk menyimpan data ke tabel pengembalian
    $sql = "INSERT INTO pengembalian (id_peminjaman, tanggal_pengembalian, denda, status_pengembalian) VALUES (?, ?, ?, ?)";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("isis", $id_peminjaman, $tanggal_pengembalian, $denda, $status_pengembalian);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data pengembalian berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data pengembalian: " . $stmt->error;
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
