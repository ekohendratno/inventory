-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2022 pada 15.50
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `barang_nama` text NOT NULL,
  `barang_nomor` text NOT NULL,
  `barang_nomor_kode` text NOT NULL,
  `barang_nomor_register` text NOT NULL,
  `barang_nomor_seripabrik` text NOT NULL,
  `barang_merk` text NOT NULL,
  `barang_ukuran` text NOT NULL,
  `barang_bahan` text NOT NULL,
  `barang_tahun_pembelian` text NOT NULL,
  `barang_kondisi` text NOT NULL,
  `barang_jumlah` int(11) NOT NULL,
  `barang_harga` text NOT NULL,
  `barang_keterangan` text NOT NULL,
  `barang_kondisi_saatini` text NOT NULL,
  `barang_tanggal_diupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `barang_tanggal_diinput` datetime NOT NULL,
  `barang_katalog` text NOT NULL,
  `barang_lokasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`barang_id`, `barang_nama`, `barang_nomor`, `barang_nomor_kode`, `barang_nomor_register`, `barang_nomor_seripabrik`, `barang_merk`, `barang_ukuran`, `barang_bahan`, `barang_tahun_pembelian`, `barang_kondisi`, `barang_jumlah`, `barang_harga`, `barang_keterangan`, `barang_kondisi_saatini`, `barang_tanggal_diupdate`, `barang_tanggal_diinput`, `barang_katalog`, `barang_lokasi`) VALUES(2, 'Mikrotik RB 291 Lite', '2022.01.11 21.25.12', '', '', '', 'Mikrotik', '0', 'Elektronik', '2022', 'Baik', 10, '1000', '', 'Baik', '2022-01-11 21:25:54', '2011-01-22 00:00:00', 'Perangkat Jaringan', 'Ruang Guru 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_services`
--

DROP TABLE IF EXISTS `barang_services`;
CREATE TABLE `barang_services` (
  `barang_services_id` int(11) NOT NULL,
  `barang_services_catatan` text NOT NULL,
  `barang_services_keadaan` enum('Baik','Rusak ringan','Rusak berat','Hilang','Perbaikan') NOT NULL,
  `barang_services_status` enum('Menunggu','Selesai','Sedang ditangani','Tidak dapat ditangani','Masuk Gudang') NOT NULL,
  `barang_services_nomor` text NOT NULL,
  `barang_services_tanggal_masuk` date NOT NULL,
  `barang_services_tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_services`
--

INSERT INTO `barang_services` (`barang_services_id`, `barang_services_catatan`, `barang_services_keadaan`, `barang_services_status`, `barang_services_nomor`, `barang_services_tanggal_masuk`, `barang_services_tanggal_keluar`) VALUES(2, 'sering mati hidup', 'Rusak ringan', 'Menunggu', '2022.01.11 21.25.12', '2011-01-22', '2022-01-11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `katalog`
--

DROP TABLE IF EXISTS `katalog`;
CREATE TABLE `katalog` (
  `katalog_id` int(11) NOT NULL,
  `katalog_title` text NOT NULL,
  `katalog_kd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `katalog`
--

INSERT INTO `katalog` (`katalog_id`, `katalog_title`, `katalog_kd`) VALUES(3, 'Komputer', 'KOM');
INSERT INTO `katalog` (`katalog_id`, `katalog_title`, `katalog_kd`) VALUES(4, 'Perangkat Jaringan', 'JAR');
INSERT INTO `katalog` (`katalog_id`, `katalog_title`, `katalog_kd`) VALUES(5, 'Alat Alat', 'ALAT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
CREATE TABLE `lokasi` (
  `lokasi_id` int(11) NOT NULL,
  `lokasi_title` text NOT NULL,
  `lokasi_kd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`lokasi_id`, `lokasi_title`, `lokasi_kd`) VALUES(1, 'Ruang Praktik  1', 'RP1');
INSERT INTO `lokasi` (`lokasi_id`, `lokasi_title`, `lokasi_kd`) VALUES(2, 'Ruang Praktik 2', 'RP2');
INSERT INTO `lokasi` (`lokasi_id`, `lokasi_title`, `lokasi_kd`) VALUES(3, 'Ruang Praktik MM', 'RMM');
INSERT INTO `lokasi` (`lokasi_id`, `lokasi_title`, `lokasi_kd`) VALUES(4, 'Ruang Guru 1', 'RG1');
INSERT INTO `lokasi` (`lokasi_id`, `lokasi_title`, `lokasi_kd`) VALUES(5, 'Ruang Guru 2', 'RG2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
CREATE TABLE `pengaturan` (
  `pengaturan_id` int(11) NOT NULL,
  `pengaturan_title` text NOT NULL,
  `pengaturan_value` text NOT NULL,
  `pengaturan_type` enum('number','text') NOT NULL DEFAULT 'text',
  `user_id` int(11) NOT NULL,
  `pengaturan_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_id`, `pengaturan_title`, `pengaturan_value`, `pengaturan_type`, `user_id`, `pengaturan_key`) VALUES(1, 'Lama Waktu Peminjaman Buku', '4', 'number', 1, '1209145');
INSERT INTO `pengaturan` (`pengaturan_id`, `pengaturan_title`, `pengaturan_value`, `pengaturan_type`, `user_id`, `pengaturan_key`) VALUES(2, 'Denda Peminjaman Buku', '1000', 'number', 1, '1209145');
INSERT INTO `pengaturan` (`pengaturan_id`, `pengaturan_title`, `pengaturan_value`, `pengaturan_type`, `user_id`, `pengaturan_key`) VALUES(3, 'Lama Waktu Peminjaman Buku Diperpanjang', '4', 'number', 1, '1209145');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `transaksi_jenis` enum('pinjam','kembali','perpanjang') NOT NULL DEFAULT 'pinjam',
  `transaksi_tanggal_pinjam` date NOT NULL,
  `transaksi_tanggal_pinjam_diperpanjang` date NOT NULL,
  `transaksi_tanggal_kembali` date NOT NULL,
  `transaksi_tanggal_kembali_diperpanjang` date NOT NULL,
  `transaksi_tanggal_dikembalikan` date NOT NULL,
  `transaksi_keterangan` text NOT NULL,
  `transaksi_jumlah` int(11) NOT NULL,
  `transaksi_denda` enum('bayar','tunda','belum') NOT NULL DEFAULT 'belum',
  `transaksi_tanggal` datetime NOT NULL,
  `transaksi_peminjam` text NOT NULL,
  `transaksi_nota` text NOT NULL,
  `transaksi_barang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `transaksi_jenis`, `transaksi_tanggal_pinjam`, `transaksi_tanggal_pinjam_diperpanjang`, `transaksi_tanggal_kembali`, `transaksi_tanggal_kembali_diperpanjang`, `transaksi_tanggal_dikembalikan`, `transaksi_keterangan`, `transaksi_jumlah`, `transaksi_denda`, `transaksi_tanggal`, `transaksi_peminjam`, `transaksi_nota`, `transaksi_barang`) VALUES(2, 'pinjam', '2022-01-11', '2022-01-11', '2022-01-11', '2022-01-11', '2022-01-11', 'untuk praktik xii tkj 1', 5, '', '2022-01-11 21:40:55', 'adi', '61DD96CE01557', '[{\"kode_barang\":\"2022.01.11 21.25.12\",\"jumlah_barang\":\"5\"}]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` enum('superadmin','admin','siswa','guru') NOT NULL,
  `last_active` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `level`, `last_active`) VALUES(1, 'admin', '12345678', 'admin', '2022-01-04 10:20:28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indeks untuk tabel `barang_services`
--
ALTER TABLE `barang_services`
  ADD PRIMARY KEY (`barang_services_id`);

--
-- Indeks untuk tabel `katalog`
--
ALTER TABLE `katalog`
  ADD PRIMARY KEY (`katalog_id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barang_services`
--
ALTER TABLE `barang_services`
  MODIFY `barang_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `katalog`
--
ALTER TABLE `katalog`
  MODIFY `katalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `lokasi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `pengaturan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
