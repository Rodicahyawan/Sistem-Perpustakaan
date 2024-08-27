<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_buku = $_POST['loanBookId'];
    $id_anggota = $_POST['loanMemberId'];
    $tanggal_peminjaman = $_POST['loanDate'];
    $tanggal_kembali = isset($_POST['returnDate']) ? $_POST['returnDate'] : null;

    // Query untuk menyimpan data ke tabel peminjaman
    $sql = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_peminjaman, tanggal_kembali) VALUES (?, ?, ?, ?)";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("iiss", $id_buku, $id_anggota, $tanggal_peminjaman, $tanggal_kembali);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data peminjaman berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data peminjaman: " . $stmt->error;
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
