<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengembalian = $_POST['id_pengembalian'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $denda = $_POST['denda'];
    $status_pengembalian = $_POST['status_pengembalian'];

    echo "ID Pengembalian: $id_pengembalian<br>";
    echo "Tanggal Pengembalian: $tanggal_pengembalian<br>";
    echo "Denda: $denda<br>";
    echo "Status Pengembalian: $status_pengembalian<br>";

    $query = "UPDATE pengembalian SET 
                tanggal_pengembalian = ?, 
                denda = ?, 
                status_pengembalian = ?
              WHERE id_pengembalian = ?";

    if ($stmt = $mysqli->prepare($query)) {
        // Debugging statement
        echo "Query prepared successfully<br>";
        
        // Ensure the data type matches the column type in database
        if ($stmt->bind_param("sssi", $tanggal_pengembalian, $denda, $status_pengembalian, $id_pengembalian)) {
            echo "Parameters bound successfully<br>";
            
            if ($stmt->execute()) {
                echo "Query executed successfully<br>";
                header("Location: admin.php");
                exit();
            } else {
                echo "Error executing query: " . $stmt->error . "<br>";
            }
        } else {
            echo "Error binding parameters: " . $mysqli->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Error preparing query: " . $mysqli->error . "<br>";
    }

    $mysqli->close();
} else {
    header("Location: admin.php");
    exit();
}
?>
