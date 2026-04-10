-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Apr 2026 pada 04.45
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_1_Andi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alat`
--

CREATE TABLE `alat` (
  `id_alat` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL,
  `tersedia` int(11) NOT NULL,
  `kondisi` enum('baik','rusak') DEFAULT 'baik',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alat`
--

INSERT INTO `alat` (`id_alat`, `id_kategori`, `nama_alat`, `stok`, `tersedia`, `kondisi`, `created_at`) VALUES
(1, NULL, 'Tenda Dome', 7, 7, 'baik', '2026-02-04 06:05:13'),
(4, NULL, 'Carrier', 4, 0, 'baik', '2026-02-04 06:05:13'),
(7, NULL, 'Sleeping Bag Standar', 6, 6, 'baik', '2026-02-04 06:05:13'),
(9, NULL, 'Matras Camping', 6, 6, 'baik', '2026-02-04 06:05:13'),
(10, NULL, 'Kompor Portable', 5, 4, 'baik', '2026-02-04 06:05:13'),
(11, NULL, 'Gas Portable', 5, 2, 'baik', '2026-02-04 06:05:13'),
(16, NULL, 'nesting', 5, 5, 'baik', '2026-02-04 06:05:13'),
(59, NULL, 'sepatu', 10, 9, 'baik', '2026-02-05 06:28:30'),
(60, NULL, 'jas hujan', 23, 20, 'baik', '2026-02-05 06:30:08'),
(66, NULL, 'hadlamp', 15, 15, 'baik', '2026-03-31 10:08:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(22, 'perlengkapan gunungg'),
(23, 'perlengkapan tidur'),
(24, 'perlengkapan masak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `tanggal_aktivitas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `nama`, `aktivitas`, `tanggal_aktivitas`) VALUES
(16, 'zaki', 'Mengajukan peminjaman alat: jas hujan (jumlah: 1)', '2026-04-01 17:35:21'),
(17, 'zaki', 'Mengembalikan alat: jas hujan', '2026-04-01 17:36:31'),
(18, 'zaki', 'Mengajukan peminjaman alat: jas hujan (jumlah: 2)', '2026-04-01 17:38:33'),
(19, 'zaki', 'Mengajukan peminjaman alat: Carrier (jumlah: 1)', '2026-04-01 18:32:55'),
(20, 'zaki', 'Mengembalikan alat: Carrier', '2026-04-01 18:34:08'),
(21, 'peminjam', 'Mengajukan peminjaman alat: Gas Portable (jumlah: 1)', '2026-04-01 18:59:00'),
(22, 'peminjam', 'Mengajukan peminjaman alat: Gas Portable (jumlah: 1)', '2026-04-01 18:59:31'),
(23, 'zaki', 'Mengajukan peminjaman alat: Tenda Dome (jumlah: 1)', '2026-04-01 19:01:18'),
(24, 'zaki', 'Mengajukan peminjaman alat: Carrier (jumlah: 1)', '2026-04-01 19:10:54'),
(25, 'zaki', 'Mengembalikan alat: Carrier', '2026-04-01 19:12:11'),
(26, 'zaki', 'Mengembalikan alat: Tenda Dome', '2026-04-01 19:13:52'),
(27, 'zaki', 'Mengembalikan alat: jas hujan', '2026-04-01 19:13:54'),
(28, 'bagas', 'Mengajukan peminjaman alat: Carrier (jumlah: 1)', '2026-04-01 20:57:16'),
(29, 'zaki', 'Mengajukan peminjaman alat: Carrier (jumlah: 1)', '2026-04-01 21:02:36'),
(30, 'zaki', 'Mengembalikan alat: Carrier', '2026-04-01 21:03:16'),
(31, 'zaki', 'Mengajukan peminjaman alat: Gas Portable (jumlah: 1)', '2026-04-01 21:05:13'),
(32, 'zaki', 'Mengembalikan alat: Gas Portable', '2026-04-01 21:06:27'),
(33, 'peminjam', 'Mengajukan peminjaman alat: sepatu (jumlah: 1)', '2026-04-01 21:19:50'),
(34, 'peminjam', 'Mengajukan peminjaman alat: Gas Portable (jumlah: 1)', '2026-04-01 21:49:01'),
(35, 'zaki', 'Mengajukan peminjaman alat: Gas Portable (jumlah: 1)', '2026-04-02 13:09:18'),
(36, 'zaki', 'Mengajukan peminjaman alat: Kompor Portable (jumlah: 1)', '2026-04-04 18:22:02'),
(37, 'zaki', 'Mengembalikan alat: Kompor Portable', '2026-04-04 18:24:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `status` enum('menunggu','disetujui','dipinjam','ditolak','dikembalikan','terlambat') DEFAULT 'menunggu',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `nama_peminjam`, `nama_alat`, `tanggal_pinjam`, `tanggal_kembali`, `jumlah`, `ukuran`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(68, 'bagas', 'Carrier', '2026-04-01', '2026-04-01', 1, '40', 'terlambat', NULL, '2026-04-01 13:57:16', '2026-04-01 17:50:51'),
(69, 'zaki', 'Carrier', '2026-04-01', '2026-04-01', 1, '40', 'dikembalikan', NULL, '2026-04-01 14:02:36', '2026-04-01 14:03:16'),
(70, 'zaki', 'Gas Portable', '2026-04-01', '2026-04-01', 1, '40', 'dikembalikan', NULL, '2026-04-01 14:05:13', '2026-04-01 14:06:27'),
(71, 'peminjam', 'sepatu', '2026-04-01', '2026-04-02', 1, '39', 'terlambat', NULL, '2026-04-01 14:19:50', '2026-04-04 11:23:00'),
(72, 'peminjam', 'Gas Portable', '2026-04-01', '2026-04-03', 1, '40', 'terlambat', NULL, '2026-04-01 14:49:01', '2026-04-04 11:23:00'),
(73, 'zaki', 'Gas Portable', '2026-04-02', '2026-04-03', 1, '40', 'terlambat', NULL, '2026-04-02 06:09:18', '2026-04-04 11:23:00'),
(74, 'zaki', 'Kompor Portable', '2026-04-04', '2026-04-04', 1, 'm', 'dikembalikan', NULL, '2026-04-04 11:22:02', '2026-04-04 11:24:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `id_alat` int(11) DEFAULT NULL,
  `tanggal_dikembalikan` date NOT NULL,
  `kondisi_kembali` enum('Baik','Rusak','Hilang') DEFAULT 'Baik',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_peminjaman`, `id_alat`, `tanggal_dikembalikan`, `kondisi_kembali`, `denda`) VALUES
(53, 69, 4, '2026-04-01', 'Baik', 0),
(54, 70, 11, '2026-04-01', 'Baik', 0),
(55, 74, 10, '2026-04-04', 'Baik', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_tlp` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Petugas','Peminjam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `no_tlp`, `password`, `role`) VALUES
(33, 'admin', 'admin@gmail.com', '08952738638', '$2y$10$jFIRNaAwty81w0Iq7vGlkelxcNzFJ9xTcpeckEbS5S45/rKE07kfu', 'Admin'),
(34, 'petugas ', 'petugas@gmail.com', '087752853726', '$2y$10$BhMJthR0K/L6WG7usgbUYexTeux8aYMqKqXsw2Xs339OZZnt/VJV.', 'Petugas'),
(35, 'peminjam', 'peminjam@gmail.com', '087752853726', '$2y$10$pHFe9FXQ/cfekbXUFDvBhOv8VP1ypbaLbJ3PhptqSvsextOr/UjHu', 'Peminjam');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
