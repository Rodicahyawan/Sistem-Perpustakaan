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

    // Prepare and execute the update query
    $query = "UPDATE buku SET 
                judul_buku = ?, 
                penulis = ?, 
                tahun_terbit = ?, 
                genre = ? 
              WHERE id_buku = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ssisi", $judul_buku, $penulis, $tahun_terbit, $genre, $id_buku);
        if ($stmt->execute()) {
            // Success - Redirect back to admin page
            header("Location: admin.php");
            exit();
        } else {
            // Error - Display an error message
            echo "Error updating record: " . $mysqli->error;
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
