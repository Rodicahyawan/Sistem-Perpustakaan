<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email']; // Menggunakan email dari session
    $buku_id = $_POST['id_buku'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' + 7 days'));

    // Ambil id_anggota berdasarkan email
    $sql_get_anggota = "SELECT id_anggota FROM anggota WHERE email = ?";
    $stmt_get_anggota = $mysqli->prepare($sql_get_anggota);
    $stmt_get_anggota->bind_param("s", $email);
    $stmt_get_anggota->execute();
    $result_get_anggota = $stmt_get_anggota->get_result();
    $row_anggota = $result_get_anggota->fetch_assoc();

    if (!$row_anggota) {
        echo "Gagal menemukan anggota dengan email: " . $email;
        exit();
    }

    $id_anggota = $row_anggota['id_anggota'];

    // Cek ketersediaan buku
    $sql_check_buku = "SELECT * FROM buku WHERE id_buku = ? AND status_peminjaman = 'tersedia'";
    $stmt_check_buku = $mysqli->prepare($sql_check_buku);
    $stmt_check_buku->bind_param("i", $buku_id);
    $stmt_check_buku->execute();
    $result_check_buku = $stmt_check_buku->get_result();

    if ($result_check_buku->num_rows > 0) {
        // Buku tersedia, lanjutkan proses peminjaman
        $sql_pinjam = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_peminjaman, tanggal_kembali) VALUES (?, ?, ?, ?)";
        $stmt_pinjam = $mysqli->prepare($sql_pinjam);
        $stmt_pinjam->bind_param("iiss", $buku_id, $id_anggota, $tanggal_pinjam, $tanggal_kembali);

        if ($stmt_pinjam->execute()) {
            // Tidak perlu lagi update status peminjaman buku secara manual
            echo "Peminjaman buku berhasil! Tanggal pengembalian buku maksimal: " . $tanggal_kembali;
        } else {
            echo "Peminjaman gagal: " . $stmt_pinjam->error;
        }
    } else {
        echo "Buku tidak tersedia atau sudah dipinjam.";
    }
}
?>
