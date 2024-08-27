<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard Admin Perpustakaan Seruni</h1>
            <p>Kelola data Buku, Anggota, Peminjaman, dan Pengembalian</p>
        </header>
        <main>
                <h2>Data Buku</h2>
                <div class="search-bar-container">
                    <form method="GET" action="admin.php">
                        <input type="text" name="search" id="searchInput" placeholder="Cari buku..." class="search-bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <span type="submit" class="search-icon"><i class="fas fa-search"></i></span>
                    </form>
                </div>
  
<button class="btn-action" onclick="addBook()">Tambah Buku</button>
<table id="bukuTable">
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
        include 'koneksi.php'; // Include the database connection

        // Ambil keyword pencarian jika ada
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Modifikasi query untuk menyertakan pencarian
        $query = "SELECT * FROM buku WHERE judul_buku LIKE '%$search%' OR penulis LIKE '%$search%' OR genre LIKE '%$search%' OR tahun_terbit LIKE '%$search%'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_buku'] . "</td>";
                echo "<td>" . $row['judul_buku'] . "</td>";
                echo "<td>" . $row['penulis'] . "</td>";
                echo "<td>" . $row['tahun_terbit'] . "</td>";
                echo "<td>" . $row['genre'] . "</td>";
                echo "<td>
                    <button class='btn-edit' onclick='openEditBookModal(" . $row['id_buku'] . ", \"" . $row['judul_buku'] . "\", \"" . $row['penulis'] . "\", " . $row['tahun_terbit'] . ", \"" . $row['genre'] . "\")'><i class='fas fa-edit'></i></button>
                    <form action='hapus_buku.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id_buku' value='" . $row['id_buku'] . "'>
                        <button type='submit' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus buku ini?\")'><i class='fas fa-trash'></i></button>
                    </form>
                    </td>";
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
        }

        $mysqli->close();
        ?>


    </tbody>
</table>
            </section>

            <section class="table-section">
                <h2>Data Anggota</h2>
                <div class="search-bar-container">
                    <form method="GET" action="admin.php">
                        <input type="text" name="search_anggota" id="searchInput" placeholder="Cari anggota..." class="search-bar" value="<?php echo isset($_GET['search_anggota']) ? $_GET['search_anggota'] : ''; ?>">
                        <span type="submit" class="search-icon"><i class="fas fa-search"></i></span>
                    </form>
                </div>  
                <button class="btn-action" onclick="addMember()">Tambah Anggota</button>
                <table id="anggotaTable">
                    <thead>
                        <tr>
                            <th>ID Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
        include 'koneksi.php'; // Include the database connection

        // Ambil keyword pencarian jika ada
        $search_anggota = isset($_GET['search_anggota']) ? $_GET['search_anggota'] : '';

        // Modifikasi query untuk menyertakan pencarian
        $query = "SELECT * FROM anggota WHERE nama_anggota LIKE '%$search_anggota%' OR alamat LIKE '%$search_anggota%' OR email LIKE '%$search_anggota%' OR no_telepon LIKE '%$search_anggota%'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_anggota'] . "</td>";
                echo "<td>" . $row['nama_anggota'] . "</td>";
                echo "<td>" . $row['alamat'] . "</td>";
                echo "<td>" . $row['tanggal_lahir'] . "</td>";
                echo "<td>" . $row['no_telepon'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>
                     <button class='btn-edit' onclick='openEditMemberModal(" . $row['id_anggota'] . ", \"" . $row['nama_anggota'] . "\", \"" . $row['alamat'] . "\", \"" . $row['tanggal_lahir'] . "\", \"" . $row['no_telepon'] . "\", \"" . $row['email'] . "\", \"" . $row['password'] . "\")'><i class='fas fa-edit'></i></button>
                     <form action='hapus_anggota.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id_anggota' value='" . $row['id_anggota'] . "'>
                        <button type='submit' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus anggota ini?\")'><i class='fas fa-trash'></i></button>
                     </form>
                     </td>";

            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
        }

        $mysqli->close();
        ?>
</tbody>
                </table>
            </section>

            <section class="table-section">
            <h2>Data Peminjaman</h2>
            <div class="search-bar-container">
            <form method="GET" action="admin.php">
                <input type="text" name="search_peminjaman" id="searchInput" placeholder="Cari data..." class="search-bar" value="<?php echo isset($_GET['search_peminjaman']) ? $_GET['search_peminjaman'] : ''; ?>">
                <span type="submit" class="search-icon"><i class="fas fa-search"></i></span>
            </form>
            </div>  
            <button class="btn-action" onclick="addLoan()">Tambah Peminjaman</button>
            <table id="peminjamanTable">
                <thead>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>ID Anggota</th>
                        <th>ID Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'koneksi.php'; // Include the database connection

                // Ambil keyword pencarian jika ada
                $search_peminjaman = isset($_GET['search_peminjaman']) ? $_GET['search_peminjaman'] : '';

                // Modifikasi query untuk menyertakan pencarian
                $query = "SELECT * FROM peminjaman 
                        WHERE id_peminjaman LIKE '%$search_peminjaman%' 
                        OR id_anggota LIKE '%$search_peminjaman%' 
                        OR id_buku LIKE '%$search_peminjaman%' 
                        OR tanggal_peminjaman LIKE '%$search_peminjaman%' 
                        OR tanggal_kembali LIKE '%$search_peminjaman%'";
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_peminjaman'] . "</td>";
                        echo "<td>" . $row['id_anggota'] . "</td>";
                        echo "<td>" . $row['id_buku'] . "</td>";
                        echo "<td>" . $row['tanggal_peminjaman'] . "</td>";
                        echo "<td>" . $row['tanggal_kembali'] . "</td>";
                        echo "<td>
                            <form action='kembalikan_buku.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id_peminjaman' value='" . $row['id_peminjaman'] . "'>
                                <button type='submit' class='btn-return' onclick='return confirm(\"Apakah buku ini sudah dikembalikan?\")'>Dikembalikan</button>
                            </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                }

                $mysqli->close();
                ?>
                </tbody>
            </table>
        </section>

        <section class="table-section">
            <h2>Data Pengembalian</h2>
            <div class="search-bar-container">
                <form method="GET" action="admin.php">
                    <input type="text" name="search_pengembalian" id="searchInput" placeholder="Cari data..." class="search-bar" value="<?php echo isset($_GET['search_pengembalian']) ? $_GET['search_pengembalian'] : ''; ?>">
                    <span type="submit" class="search-icon"><i class="fas fa-search"></i></span>
                </form>
            </div>  
            <button class="btn-action" onclick="addReturn()">Tambah Pengembalian</button>
            <table id="pengembalianTable">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th>
                        <th>ID Buku</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                        <th>Status Pengembalian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php'; // Include the database connection

                    // Ambil keyword pencarian jika ada
                    $search_pengembalian = isset($_GET['search_pengembalian']) ? $_GET['search_pengembalian'] : '';

                    // Modifikasi query untuk menyertakan pencarian
                    $query = "SELECT * FROM pengembalian 
                            WHERE id_pengembalian LIKE '%$search_pengembalian%' 
                            OR id_buku LIKE '%$search_pengembalian%' 
                            OR tanggal_pengembalian LIKE '%$search_pengembalian%' 
                            OR denda LIKE '%$search_pengembalian%' 
                            OR status_pengembalian LIKE '%$search_pengembalian%'";
                    $result = $mysqli->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id_pengembalian'] . "</td>";
                            echo "<td>" . $row['id_buku'] . "</td>";
                            echo "<td>" . $row['tanggal_pengembalian'] . "</td>";
                            echo "<td>" . $row['denda'] . "</td>";
                            echo "<td>" . $row['status_pengembalian'] . "</td>";
                            echo "<td>
                                <form action='hapus_pengembalian.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['id_pengembalian'] . "'>
                                    <button type='submit' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><i class='fas fa-trash'></i></button>
                                </form>
                                <button class='btn-edit' onclick='editReturn(" . $row['id_pengembalian'] . ")'><i class='fas fa-edit'></i></button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }

                    $mysqli->close();
                    ?>
                </tbody>
            </table>
        </section>

        </main>
        <footer>
            <p>&copy; 2024 Perpustakaan Seruni | All Rights Reserved</p>
            <!-- Modal for Add Book -->
            <div id="addBookModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('addBookModal')">&times;</span>
                    <h2>Tambah Buku</h2>
                    <form id="addBookForm" action="tambah_buku.php" method="POST">
                        <label for="bookTitle">Judul Buku:</label>
                        <input type="text" id="bookTitle" name="bookTitle" required>
                        
                        <label for="bookAuthor">Penulis:</label>
                        <input type="text" id="bookAuthor" name="bookAuthor" required>
                        
                        <label for="bookYear">Tahun Terbit:</label>
                        <input type="number" id="bookYear" name="bookYear" required>
                        
                        <label for="bookGenre">Genre:</label>
                        <input type="text" id="bookGenre" name="bookGenre" required>
                        
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Add Member -->
            <div id="addMemberModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('addMemberModal')">&times;</span>
                    <h2>Tambah Anggota</h2>
                    <form id="addMemberModal" action="tambah_anggota.php" method="POST">
                        <label for="memberName">Nama Anggota:</label>
                        <input type="text" id="memberName" name="memberName" required>
                        
                        <label for="memberAddress">Alamat:</label>
                        <textarea id="memberAddress" name="memberAddress" rows="3" required></textarea>
                        
                        <label for="memberDob">Tanggal Lahir:</label>
                        <input type="date" id="memberDob" name="memberDob" required>
                        
                        <label for="memberPhone">Nomor Telepon:</label>
                        <input type="text" id="memberPhone" name="memberPhone" required>
                        
                        <label for="memberEmail">Email:</label>
                        <input type="email" id="memberEmail" name="memberEmail" required>
                        
                        <label for="memberPassword">Password:</label>
                        <input type="password" id="memberPassword" name="memberPassword" required>
                        
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Edit Member -->
            <div id="editMemberModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('editMemberModal')">&times;</span>
                    <h2>Edit Anggota</h2>
                    <form id="editMemberForm" action="edit_anggota.php" method="POST">
                        <input type="hidden" id="editMemberId" name="id_anggota">
                        
                        <label for="editMemberName">Nama Anggota:</label>
                        <input type="text" id="editMemberName" name="nama_anggota" required>
                        
                        <label for="editMemberAddress">Alamat:</label>
                        <textarea id="editMemberAddress" name="alamat" rows="3" required></textarea>
                        
                        <label for="editMemberDob">Tanggal Lahir:</label>
                        <input type="date" id="editMemberDob" name="tanggal_lahir" required>
                        
                        <label for="editMemberPhone">Nomor Telepon:</label>
                        <input type="text" id="editMemberPhone" name="no_telepon" required>
                        
                        <label for="editMemberEmail">Email:</label>
                        <input type="email" id="editMemberEmail" name="email" required>
                        
                        <label for="editMemberPassword">Password:</label>
                        <input type="password" id="editMemberPassword" name="password" required>
                        
                        <button type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Edit Book -->
            <div id="editBookModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('editBookModal')">&times;</span>
                    <h2>Edit Buku</h2>
                    <form id="editBookForm" action="edit_buku.php" method="POST">
                        <input type="hidden" id="editBookId" name="id_buku">

                        <label for="editBookTitle">Judul Buku:</label>
                        <input type="text" id="editBookTitle" name="judul_buku" required>

                        <label for="editBookAuthor">Penulis:</label>
                        <input type="text" id="editBookAuthor" name="penulis" required>

                        <label for="editBookYear">Tahun Terbit:</label>
                        <input type="number" id="editBookYear" name="tahun_terbit" required>

                        <label for="editBookGenre">Genre:</label>
                        <input type="text" id="editBookGenre" name="genre" required>

                        <button type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Add Loan -->
            <div id="addLoanModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('addLoanModal')">&times;</span>
                    <h2>Tambah Peminjaman</h2>
                    <form id="addPeminjaman" action="tambah_peminjaman.php" method="POST">
                        <label for="loanBookId">ID Buku:</label>
                        <input type="number" id="loanBookId" name="loanBookId" required>
                        
                        <label for="loanMemberId">ID Anggota:</label>
                        <input type="number" id="loanMemberId" name="loanMemberId" required>
                        
                        <label for="loanDate">Tanggal Peminjaman:</label>
                        <input type="date" id="loanDate" name="loanDate" required>
                        
                        <label for="returnDate">Tanggal Kembali:</label>
                        <input type="date" id="returnDate" name="returnDate">
                        
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Modal for Add Return -->
            <div id="addReturnModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('addReturnModal')">&times;</span>
                    <h2>Tambah Pengembalian</h2>
                    <form id="addPengembalian" action="tambah_pengembalian.php" method="POST">
                        <label for="returnLoanId">ID Peminjaman:</label>
                        <input type="number" id="returnLoanId" name="returnLoanId" required>
                        
                        <label for="bookId">ID Buku:</label>
                        <input type="number" id="bookId" name="bookId" required>

                        <label for="returnDate">Tanggal Pengembalian:</label>
                        <input type="date" id="returnDate" name="returnDate" required>
                        
                        <label for="returnFine">Denda:</label>
                        <input type="number" id="returnFine" name="returnFine" value="0">
                        
                        <label for="returnStatus">Status Pengembalian:</label>
                        <input type="text" id="returnStatus" name="returnStatus" value="Selesai">
                        
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Return -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
                    <form action="edit_pengembalian.php" method="POST">
                        <input type="hidden" name="id_pengembalian" id="edit-id">
                        <label for="edit-id-buku">ID Buku:</label>
                        <input type="text" name="id_buku" id="edit-id-buku">
                        <label for="edit-tanggal-pengembalian">Tanggal Pengembalian:</label>
                        <input type="date" name="tanggal_pengembalian" id="edit-tanggal-pengembalian">
                        <label for="edit-denda">Denda:</label>
                        <input type="text" name="denda" id="edit-denda">
                        <label for="edit-status-pengembalian">Status Pengembalian:</label>
                        <input type="text" name="status_pengembalian" id="edit-status-pengembalian">
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>

        </footer>
    </div>
    <script src="admin.js"></script>
</body>
</html>
