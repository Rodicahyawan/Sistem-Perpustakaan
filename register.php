<?php
session_start();
// Include file koneksi
require_once 'koneksi.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_anggota = $_POST['name'];
    $no_telepon = $_POST['phone'];
    $tanggal_lahir = $_POST['dob'];
    $alamat = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil stored procedure
    $sql = "CALL RegisterAnggota(?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        // Bind parameter ke query
        $stmt->bind_param("ssssss", $nama_anggota, $no_telepon, $tanggal_lahir, $alamat, $email, $password);
        
        try {
            // Eksekusi query
            $stmt->execute();
            
            echo "<!DOCTYPE html>
                  <html lang='en'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>Registration Success</title>
                      <style>
                          body {
                              font-family: Arial, sans-serif;
                              background-color: #f4f4f4;
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              height: 100vh;
                              margin: 0;
                          }
                          .modal {
                              background: white;
                              padding: 20px;
                              border-radius: 8px;
                              box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                              text-align: center;
                          }
                          .modal h1 {
                              color: #4CAF50;
                          }
                          .modal p {
                              margin: 15px 0;
                          }
                          .modal a {
                              color: #2196F3;
                              text-decoration: none;
                              font-weight: bold;
                          }
                          .modal a:hover {
                              text-decoration: underline;
                          }
                      </style>
                  </head>
                  <body>
                      <div class='modal'>
                          <h1>Berhasil Registrasi!</h1>
                          <p>Anda telah berhasil mendaftar. Silahkan <a href='index.html'>login</a> untuk masuk ke sistem.</p>
                      </div>
                  </body>
                  </html>";
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        } finally {
            // Menutup statement dan koneksi
            $stmt->close();
        }
    } else {
        echo "Gagal mempersiapkan statement: " . $mysqli->error;
    }
}

// Menutup koneksi
$mysqli->close();
?>
