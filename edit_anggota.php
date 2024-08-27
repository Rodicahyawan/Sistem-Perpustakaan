<?php
include 'koneksi.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_anggota = $_POST['id_anggota'];
    $nama_anggota = $_POST['nama_anggota'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Password should be hashed in a real application

    // Query untuk memperbarui data anggota
    $query = "UPDATE anggota SET 
              nama_anggota = ?, 
              alamat = ?, 
              tanggal_lahir = ?, 
              no_telepon = ?, 
              email = ?, 
              password = ? 
              WHERE id_anggota = ?";

    // Persiapkan statement
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ssssssi", $nama_anggota, $alamat, $tanggal_lahir, $no_telepon, $email, $password, $id_anggota);

        // Eksekusi statement
        if ($stmt->execute()) {
            echo "Data anggota berhasil diperbarui.";
        } else {
            echo "Terjadi kesalahan saat memperbarui data: " . $mysqli->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat mempersiapkan query: " . $mysqli->error;
    }

    // Tutup koneksi
    $mysqli->close();
}
?>
