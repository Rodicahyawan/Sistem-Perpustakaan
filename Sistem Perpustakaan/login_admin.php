<?php
session_start();
// Include file koneksi
require_once 'koneksi.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa data login admin
    $sql = "SELECT * FROM admin WHERE email = ? AND password = ?";

    // Mempersiapkan statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameter ke query
        $stmt->bind_param("ss", $email, $password);

        // Eksekusi query
        $stmt->execute();

        // Mendapatkan hasil query
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login berhasil
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email; // Menyimpan email admin ke session

            // Arahkan pengguna ke halaman admin.php
            header("Location: admin.php");
            exit();
        } else {
            // Login gagal
            echo "<!DOCTYPE html>
                  <html lang='en'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>Login Failed</title>
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
                          .message {
                              background: white;
                              padding: 20px;
                              border-radius: 8px;
                              box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                              text-align: center;
                          }
                          .message h1 {
                              color: #e74c3c;
                          }
                          .message p {
                              margin: 15px 0;
                          }
                          .message a {
                              color: #2196F3;
                              text-decoration: none;
                              font-weight: bold;
                          }
                          .message a:hover {
                              text-decoration: underline;
                          }
                      </style>
                  </head>
                  <body>
                      <div class='message'>
                          <h1>Login Gagal</h1>
                          <p>Email atau password salah. Silahkan <a href='index.html'>coba lagi</a>.</p>
                      </div>
                  </body>
                  </html>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "Gagal mempersiapkan statement: " . $mysqli->error;
    }

    // Menutup koneksi
    $mysqli->close();
}
?>
