<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_anggota'])) {
        $id_anggota = intval($_POST['id_anggota']);
        
        // Menyiapkan pernyataan SQL untuk menghapus data anggota
        $stmt = $mysqli->prepare("DELETE FROM anggota WHERE id_anggota = ?");
        $stmt->bind_param("i", $id_anggota);
        
        if ($stmt->execute()) {
            // Redirect kembali ke halaman admin setelah penghapusan
            header("Location: admin.php?message=success");
        } else {
            // Redirect dengan pesan error
            header("Location: admin.php?message=error");
        }

        $stmt->close();
    }
}

$mysqli->close();
?>
