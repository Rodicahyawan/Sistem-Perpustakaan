<?php
// Include the database connection
include 'koneksi.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id_buku = $_POST['id_buku'];
    $judul_buku = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];
    $status_peminjaman = $_POST['status_peminjaman']; // Pastikan status_peminjaman diambil dari form

    // Prepare and execute the stored procedure call
    $query = "CALL update_buku(?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ississ", $id_buku, $judul_buku, $penulis, $tahun_terbit, $genre, $status_peminjaman);
        
        if ($stmt->execute()) {
            // Success - Redirect back to admin page
            header("Location: admin.php");
            exit();
        } else {
            // Error - Display an error message
            echo "Error updating record: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
} else {
    // Redirect if accessed directly
    header("Location: admin.php");
    exit();
}
?>
