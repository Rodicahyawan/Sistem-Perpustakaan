<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Konfigurasi database
$host = 'localhost';
$dbname = 'db_perpustakaan';
$username = 'root';
$password = '';

// Membuat koneksi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Menampilkan pesan sukses jika koneksi berhasil
// echo "Koneksi berhasil!";
?>
