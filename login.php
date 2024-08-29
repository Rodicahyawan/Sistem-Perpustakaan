<?php
session_start();
include 'koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek login pengguna
    $sql_user = "SELECT * FROM anggota WHERE email = ? AND password = ?";
    if ($stmt_user = $mysqli->prepare($sql_user)) {
        $stmt_user->bind_param("ss", $email, $password);
        if ($stmt_user->execute()) {
            $result_user = $stmt_user->get_result();
            if ($result_user->num_rows > 0) {
                // Login pengguna berhasil
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("Location: main.php");
                exit();
            }
        } else {
            die('Execute failed: ' . $stmt_user->error);
        }
    } else {
        die('Prepare failed: ' . $mysqli->error);
    }

    // Cek login admin jika login pengguna gagal
    $sql_admin = "SELECT * FROM admin WHERE email = ? AND password = ?";
    if ($stmt_admin = $mysqli->prepare($sql_admin)) {
        $stmt_admin->bind_param("ss", $email, $password);
        if ($stmt_admin->execute()) {
            $result_admin = $stmt_admin->get_result();
            if ($result_admin->num_rows > 0) {
                // Login admin berhasil
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("Location: admin.php");
                exit();
            }
        } else {
            die('Execute failed: ' . $stmt_admin->error);
        }
    } else {
        die('Prepare failed: ' . $mysqli->error);
    }

    // Jika login gagal untuk kedua akun
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
?>
