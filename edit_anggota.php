<?php
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
include 'koneksi.php';

// Ambil ID anggota dari URL
$id_anggota = isset($_GET['id_anggota']) ? intval($_GET['id_anggota']) : 0;

// Jika ID anggota tidak valid, tampilkan pesan error
if ($id_anggota <= 0) {
    echo "ID Anggota tidak valid.";
    exit;
}

// Ambil data anggota dari database
$query = "SELECT * FROM anggota WHERE id_anggota = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id_anggota);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $anggota = $result->fetch_assoc();
} else {
    echo "Anggota tidak ditemukan.";
    exit;
}

// Tutup koneksi database
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* CSS untuk modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Anggota</h1>
        </header>
        <main>
            </div>
        </main>
    </div>

    <script>
        // Fungsi untuk membuka modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        // Menutup modal saat klik di luar modal
        window.onclick = function(event) {
            var modal = document.getElementById('editAnggotaModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Buka modal ketika halaman dimuat
        window.onload = function() {
            openModal('editAnggotaModal');
        }
    </script>
</body>
</html>
