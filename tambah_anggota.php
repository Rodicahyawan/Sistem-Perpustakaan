<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_anggota = $_POST['memberName'];
    $alamat = $_POST['memberAddress'];
    $tanggal_lahir = $_POST['memberDob'];
    $no_telepon = $_POST['memberPhone'];
    $email = $_POST['memberEmail'];
    $password = $_POST['memberPassword'];

    // Query untuk menyimpan data ke tabel anggota
    $sql = "INSERT INTO anggota (nama_anggota, alamat, tanggal_lahir, no_telepon, email, password) VALUES (?, ?, ?, ?, ?, ?)";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("ssssss", $nama_anggota, $alamat, $tanggal_lahir, $no_telepon, $email, $password);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "Data anggota berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data anggota: " . $stmt->error;
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
