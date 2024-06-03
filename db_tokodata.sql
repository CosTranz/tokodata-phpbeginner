-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jun 2023 pada 06.11
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokodata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_buku` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `id_produk`, `nama_buku`, `penulis`, `penerbit`, `foto`) VALUES
(50, 50, 'Kisah Si Kancil', 'Ari Wulandari', 'Le Coupe', 'upload/647a04bcc5cc2.jpg'),
(67, 67, 'Superman vs Batman', 'DC Comic', 'Dc Universe', 'upload/647a058db0e2b.jpg'),
(68, 68, 'Naruto Shippuden', 'Masashi Kisomoto', 'Shuisea', 'upload/647a0650694a1.jpg'),
(76, 76, 'Merebah Riuh', 'Sacessahi', 'Bukune', 'upload/647a05108c4f9.jpeg'),
(77, 77, 'Detektif Conan Vol 1', 'Gosho Aoyama', 'Elex Media', 'upload/647a06467142c.jpg'),
(81, 81, 'The Amazing Spiderman', 'Stan Lee', 'Marvel Studio', 'upload/647e9d9591ed5.jpg'),
(85, 85, 'Angsa dan Kelelawar', 'Keigo Higashino', 'Gramedia', 'upload/647e9e3742736.jpeg'),
(87, 87, 'Iron Man', 'Stan Lee', 'Marvel Studio', 'upload/647eb00368058.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jenis_produk` varchar(255) NOT NULL,
  `harga` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis_produk`, `harga`) VALUES
(50, 'Buku Cerita', 'Buku ', 210000),
(67, 'Buku Cerita', 'Ebook', 120000),
(68, 'Buku Fiksi', 'Manga', 90000),
(76, 'Buku Fiksi', 'Ebook', 35000),
(77, 'Buku Fiksi', 'Manga', 75000),
(81, 'Buku Fiksi', 'Komik', 30000),
(85, 'Buku Cerita', 'Novel', 30000),
(87, 'Buku Fiksi', 'Komik', 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `name`, `user_name`, `password`) VALUES
(837605, 'Hafiz Ilhami', 'hafiz1', '321'),
(879037, 'Hafiz Ilhami', 'hafiz2', '134'),
(5301772, 'Caca', 'caca1', 'caca'),
(22388871, 'Hafiz', 'hafiz', '123'),
(57476781, 'Jaya', 'jaya1', 'jaya1'),
(240750848, 'Zainal', 'zainal', '123'),
(598763609, 'Minda', 'minda', 'oke');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
