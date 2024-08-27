<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <style>
        .controls-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .search-bar-container {
            flex: 1;
        }
        .sort-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
    </style>
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

            <!-- Search and Sort Controls -->
            <div class="controls-container">
                <div class="search-bar-container">
                    <form method="GET" action="main.php">
                        <input type="text" id="searchInput" name="search" placeholder="Cari buku..." class="search-bar" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                    </form>
                </div>
                <div class="sort-container">
                    <form method="GET" action="main.php">
                        <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                            <option value="tahun_terbit" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'tahun_terbit') ? 'selected' : ''; ?>>Tahun Terbit</option>
                            <option value="genre" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'genre') ? 'selected' : ''; ?>>Genre</option>
                        </select>
                        <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'tahun_terbit'): ?>
                            <select name="sort_order" id="sort_order" onchange="this.form.submit()">
                                <option value="asc" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') ? 'selected' : ''; ?>>Ascending</option>
                                <option value="desc" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') ? 'selected' : ''; ?>>Descending</option>
                            </select>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'genre'): ?>
                            <select name="genre" id="genre" onchange="this.form.submit()">
                                <option value="romance" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'romance') ? 'selected' : ''; ?>>Romance</option>
                                <option value="history" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'history') ? 'selected' : ''; ?>>History</option>
                                <option value="fantasy" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'fantasy') ? 'selected' : ''; ?>>Fantasy</option>
                                <option value="science fiction" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'science fiction') ? 'selected' : ''; ?>>Science Fiction</option>
                                <option value="horror" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'horror') ? 'selected' : ''; ?>>Horror</option>
                                <option value="mystery" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'mystery') ? 'selected' : ''; ?>>Mystery</option>
                                <option value="thriller" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'thriller') ? 'selected' : ''; ?>>Thriller</option>
                                <option value="comedy" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'comedy') ? 'selected' : ''; ?>>Comedy</option>
                                <option value="inspiratif" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'inspiratif') ? 'selected' : ''; ?>>Inspiratif</option>
                                <option value="sejarah" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'sejarah') ? 'selected' : ''; ?>>Sejarah</option>
                                <option value="psikologi" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'psikologi') ? 'selected' : ''; ?>>Psikologi</option>
                                <option value="keluarga" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'keluarga') ? 'selected' : ''; ?>>Keluarga</option>
                                <option value="petualangan" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'petualangan') ? 'selected' : ''; ?>>Petualangan</option>
                            </select>
                        <?php endif; ?>
                    </form>
                </div>
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

                // Inisialisasi variabel pencarian dan sorting
                $search = '';
                $search_query = '';
                $order_query = '';

                // Cek apakah ada input pencarian
                if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                    $search = trim($_GET['search']);
                    $search_query = " WHERE judul_buku LIKE ? OR penulis LIKE ? OR genre LIKE ?";
                }

                // Cek apakah ada input sorting
                if (isset($_GET['sort_by'])) {
                    if ($_GET['sort_by'] == 'tahun_terbit') {
                        $sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc' ? 'DESC' : 'ASC';
                        $order_query = " ORDER BY tahun_terbit $sort_order";
                    } elseif ($_GET['sort_by'] == 'genre' && isset($_GET['genre'])) {
                        $genre = $_GET['genre'];
                        $search_query = " WHERE genre = ?";
                        $order_query = " ORDER BY judul_buku ASC"; // Bisa disesuaikan sesuai kebutuhan
                    }
                }

                $query = "SELECT * FROM buku" . $search_query . $order_query;
                $stmt = $mysqli->prepare($query);

                if ($search_query && isset($_GET['sort_by']) && $_GET['sort_by'] == 'genre') {
                    $stmt->bind_param("s", $genre);
                } elseif ($search_query) {
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
