<?php
include 'koneksi.php'; // Include the database connection

// Debugging: Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan id_buku dikirim dan tidak kosong
    if (isset($_POST['id_buku']) && !empty($_POST['id_buku'])) {
        $id_buku = intval($_POST['id_buku']);

        // Siapkan query untuk menghapus buku berdasarkan id_buku
        $query = "DELETE FROM buku WHERE id_buku = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id_buku);

            if ($stmt->execute()) {
                // Redirect ke halaman admin untuk merefresh data
                header("Location: admin.php");
                exit();
            } else {
                echo "Error deleting record: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }

        $mysqli->close();
    } else {
        echo "ID Buku tidak valid.";
    }
}
?>
