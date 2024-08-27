<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>Selamat Datang di Perpustakaan Seruni 📖✨</h1>
                <p>Jl. Tirtapati Timur No.18, Maos Kidul, Kec. Maos, Kab. Cilacap, Jawa Tengah</p>
                <p>Temukan dan pinjam buku favorit Anda dengan mudah.</p>
            </div>
        </header>
        <main>
            <h2>Daftar Buku</h2>
            <div class="search-bar-container">
    <form method="GET" action="main.php">
        <input type="text" id="searchInput" name="search" placeholder="Cari buku..." class="search-bar" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <span class="search-icon"><i class="fas fa-search"></i></span>
    </form>
</div>     
            <table id="booksTable">
                <thead>
                    <tr>
                        <th>ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Genre</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
include 'koneksi.php';

// Inisialisasi variabel pencarian
$search = '';
$search_query = '';

// Cek apakah ada input pencarian
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    // Siapkan query pencarian dengan prepared statements untuk mencegah SQL Injection
    $search_query = " WHERE judul_buku LIKE ? OR penulis LIKE ? OR genre LIKE ?";
}

$query = "SELECT * FROM buku" . $search_query;
$stmt = $mysqli->prepare($query);

if ($search_query) {
    // Tambahkan wildcard untuk pencarian menggunakan LIKE
    $like_search = '%' . $search . '%';
    $stmt->bind_param("sss", $like_search, $like_search, $like_search);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id_buku']) . "</td>";
        echo "<td>" . htmlspecialchars($row['judul_buku']) . "</td>";
        echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tahun_terbit']) . "</td>";
        echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
        echo "<td>";
        if ($row['status_peminjaman'] === 'tersedia') {
            echo "<form action='pinjam_buku.php' method='POST'>
                    <input type='hidden' name='id_buku' value='" . htmlspecialchars($row['id_buku']) . "'>
                    <button type='submit' class='btn-pinjam'><i class='fas fa-book-reader'></i> Pinjam</button>
                  </form>";
        } else {
            echo "<button class='btn-pinjam' disabled><i class='fas fa-book-reader'></i> Dipinjam</button>";
        }
        echo "</td>";
        echo "</tr>";
    }
    
} else {
    echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
}

$stmt->close();
$mysqli->close();
?>
                </tbody>
            </table>
        </main>
        <footer>
            <p>&copy; 2024 Perpustakaan Seruni | All Rights Reserved</p>
        </footer>
    </div>
    <script src="admin.js"></script>
</body>
</html>
