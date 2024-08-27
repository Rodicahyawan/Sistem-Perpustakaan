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
                    <input type="text" id="searchInput" placeholder="Cari buku..." class="search-bar">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
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

                        $query = "SELECT * FROM buku";
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
                                    <button class='btn-edit' onclick='editBook(" . $row['id_buku'] . ")'><i class='fas fa-edit'></i></button>
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
                    <input type="text" id="searchInput" placeholder="Cari anggota..." class="search-bar">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
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

    $query = "SELECT * FROM anggota";
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
                <form action='edit_anggota.php' method='GET' style='display:inline;'>
                    <input type='hidden' name='id_anggota' value='" . $row['id_anggota'] . "'>
                    <button type='submit' class='btn-edit'><i class='fas fa-edit'></i></button>
                </form>
                <form action='hapus_anggota.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='id_anggota' value='" . $row['id_anggota'] . "'>
                    <button type='submit' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus anggota ini?\")'><i class='fas fa-trash'></i></button>
                </form>
                </td>";
            echo "</tr>";
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
        <input type="text" id="searchInput" placeholder="Cari data..." class="search-bar">
        <span class="search-icon"><i class="fas fa-search"></i></span>
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

            $query = "SELECT * FROM peminjaman";
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
        <input type="text" id="searchInput" placeholder="Cari data..." class="search-bar">
        <span class="search-icon"><i class="fas fa-search"></i></span>
    </div>  
    <button class="btn-action" onclick="addReturn()">Tambah Pengembalian</button>
    <table id="pengembalianTable">
        <thead>
            <tr>
                <th>ID Pengembalian</th>
                <th>ID Peminjaman</th> <!-- Added this column -->
                <th>Tanggal Pengembalian</th>
                <th>Denda</th>
                <th>Status Pengembalian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'koneksi.php'; // Include the database connection

            $query = "SELECT * FROM pengembalian";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_pengembalian'] . "</td>";
                    echo "<td>" . $row['id_peminjaman'] . "</td>";
                    echo "<td>" . $row['tanggal_pengembalian'] . "</td>";
                    echo "<td>" . $row['denda'] . "</td>";
                    echo "<td>" . $row['status_pengembalian'] . "</td>";
                    echo "<td>
                        <button class='btn-edit' onclick='editReturn(" . $row['id_pengembalian'] . ")'><i class='fas fa-edit'></i></button>
                        <button class='btn-delete' onclick='deleteReturn(" . $row['id_pengembalian'] . ")'><i class='fas fa-trash'></i></button>
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

        </footer>
    </div>
    <script src="admin.js"></script>
</body>
</html>
