-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 03:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterAnggota` (IN `p_nama_anggota` VARCHAR(255), IN `p_no_telepon` VARCHAR(20), IN `p_tanggal_lahir` DATE, IN `p_alamat` TEXT, IN `p_email` VARCHAR(255), IN `p_password` VARCHAR(255))   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Rollback transaksi jika terjadi kesalahan
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Terjadi kesalahan saat registrasi anggota.';
    END;

    -- Mulai transaksi
    START TRANSACTION;

    -- Insert data anggota baru
    INSERT INTO anggota (nama_anggota, no_telepon, tanggal_lahir, alamat, email, password)
    VALUES (p_nama_anggota, p_no_telepon, p_tanggal_lahir, p_alamat, p_email, p_password);

    -- Commit transaksi jika berhasil
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_buku` (IN `p_judul_buku` VARCHAR(255), IN `p_penulis` VARCHAR(255), IN `p_tahun_terbit` YEAR, IN `p_genre` ENUM('Romance','History','Fantasy','Science Fiction','Horror','Mystery','Thriller','Comedy','Inspiratif','Psikologi','Keluarga','Petualangan'), IN `p_status_peminjaman` ENUM('Tersedia','Dipinjam'))   BEGIN
    -- Menambahkan data buku baru ke tabel buku
    INSERT INTO buku (judul_buku, penulis, tahun_terbit, genre, status_peminjaman)
    VALUES (p_judul_buku, p_penulis, p_tahun_terbit, p_genre, p_status_peminjaman);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_buku` (IN `p_id_buku` INT, IN `p_judul_buku` VARCHAR(255), IN `p_penulis` VARCHAR(255), IN `p_tahun_terbit` YEAR, IN `p_genre` ENUM('Romance','History','Fantasy','Science Fiction','Horror','Mystery','Thriller','Comedy','Inspiratif','Psikologi','Keluarga','Petualangan'), IN `p_status_peminjaman` ENUM('Tersedia','Dipinjam'))   BEGIN
    -- Memperbarui data buku berdasarkan ID
    UPDATE buku 
    SET judul_buku = p_judul_buku,
        penulis = p_penulis,
        tahun_terbit = p_tahun_terbit,
        genre = p_genre,
        status_peminjaman = p_status_peminjaman
    WHERE id_buku = p_id_buku;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
(1, 'serunimaos@gmail.com', 'password123');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_anggota`, `no_telepon`, `tanggal_lahir`, `email`, `password`, `alamat`) VALUES
(15, 'Dimas Anggara', '0893211023213', '2024-08-24', 'rcahya@gmail.com', '123654', 'Banyumas'),
(16, 'Ratna Budiman', '085741326975', '2008-05-14', 'ratna@gmail.com', 'ratnaks', 'JL. Raya Kesugihan, Cilacap');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `genre` enum('Romance','History','Fantasy','Science Fiction','Horror','Mystery','Thriller','Comedy','Inspiratif','Psikologi','Keluarga','Petualangan') NOT NULL,
  `status_peminjaman` enum('tersedia','dipinjam') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `penulis`, `tahun_terbit`, `genre`, `status_peminjaman`) VALUES
(11, 'Winter In Tokyo', 'Ilana Tan', '2021', 'Keluarga', 'tersedia'),
(12, 'MetroPop: Mismatch', 'Arata Kim', '2022', 'Romance', 'dipinjam'),
(14, 'Cosmos', 'Carl Sagan', '1980', 'Science Fiction', 'tersedia'),
(15, 'Gadis Pantai', 'Pramoedya Anantatur', '1962', 'History', 'dipinjam'),
(16, 'Laut Bercerita', 'Leila S. Chudori', '2017', 'History', 'dipinjam'),
(17, 'Cantik Itu Luka', 'Eka Kurniawan', '2002', 'History', 'dipinjam'),
(18, 'Please Look After Mom', 'Kyung Sook Shin', '2020', 'Keluarga', 'dipinjam'),
(19, 'Setengah Jalan', 'Ernest Prakasa', '2017', 'Comedy', 'tersedia'),
(20, 'Kisah Tanah Jawa: Sihir Mesir di Tahnah Jawa', 'Om Hao', '2022', 'Horror', 'tersedia'),
(21, 'Holy Mother', 'Rikako Akiyoshi', '2019', 'Horror', 'tersedia'),
(25, 'Seorang Anak yang Kehilangan Pundaknya', 'Khoerul Trian', '2023', 'Psikologi', 'tersedia'),
(26, '5 Cm', 'Donny Dhirgantoro', '2005', 'Petualangan', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `id_anggota`, `tanggal_peminjaman`, `tanggal_kembali`) VALUES
(59, 15, 15, '2024-08-28', '2024-09-04'),
(60, 16, 15, '2024-08-28', '2024-09-04'),
(61, 12, 15, '2024-08-28', '2024-09-04'),
(63, 17, 15, '2024-08-28', '2024-09-04'),
(64, 18, 15, '2024-08-28', '2024-09-04'),
(65, 11, 15, '2024-08-29', '2024-09-05');

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `after_insert_peminjaman` AFTER INSERT ON `peminjaman` FOR EACH ROW BEGIN
    UPDATE buku
    SET status_peminjaman = 'Dipinjam'
    WHERE id_buku = NEW.id_buku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int(11) DEFAULT NULL,
  `status_pengembalian` varchar(50) NOT NULL,
  `id_buku` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `tanggal_pengembalian`, `denda`, `status_pengembalian`, `id_buku`) VALUES
(45, '2024-08-27', 0, 'Tepat Waktu', 12),
(46, '2024-08-28', 0, 'Tepat Waktu', 12),
(47, '2024-08-28', 0, 'Tepat Waktu', 12),
(48, '2024-08-28', 0, 'Tepat Waktu', 15),
(49, '2024-08-28', 0, 'Tepat Waktu', 12),
(51, '2024-08-28', 0, 'Tepat Waktu', 18),
(52, '2024-08-28', 0, 'Tepat Waktu', 20),
(53, '2024-08-28', 0, 'Tepat Waktu', 14),
(57, '2024-08-28', 0, 'Tepat Waktu', 16),
(58, '2024-08-28', 0, 'Tepat Waktu', 14),
(59, '2024-08-28', 0, 'Tepat Waktu', 17),
(60, '2024-08-28', 0, 'Tepat Waktu', 11);

--
-- Triggers `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `after_insert_pengembalian` AFTER INSERT ON `pengembalian` FOR EACH ROW BEGIN
    UPDATE buku
    SET status_peminjaman = 'Tersedia'
    WHERE id_buku = NEW.id_buku;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `fk_id_buku_peminjaman` (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
