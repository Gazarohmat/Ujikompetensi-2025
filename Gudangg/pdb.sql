-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Apr 2025 pada 18.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `PelangganID` int(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Telepon` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`PelangganID`, `Nama`, `Alamat`, `Telepon`, `Email`) VALUES
(24, 'Toko Franky', 'Cijenuk Utara', '0868864446', 'a@gmail.com'),
(25, 'Toko Johan', 'Cijeungjing', '0897654665', 'b@gmail.com'),
(30, 'Toko Strangler', 'Kebon Jeruk', '098976347365', 's@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `PenjualanID` int(11) NOT NULL,
  `ProdukID` int(11) DEFAULT NULL,
  `TanggalPenjualan` date DEFAULT NULL,
  `PelangganID` int(11) DEFAULT NULL,
  `TotalPembayaran` decimal(10,2) DEFAULT NULL,
  `MetodePembayaran` varchar(50) DEFAULT NULL,
  `Kuantitas` int(11) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`PenjualanID`, `ProdukID`, `TanggalPenjualan`, `PelangganID`, `TotalPembayaran`, `MetodePembayaran`, `Kuantitas`, `Subtotal`) VALUES
(36, 32, '2025-02-23', 24, 49000.00, 'cash', 1, 49000.00),
(37, 24, '2025-02-23', 25, 32000.00, 'Qris', 1, 32000.00),
(38, 32, '2025-02-24', 24, 49000.00, 'cash', 1, 49000.00),
(42, 24, '2025-02-24', 24, 32000.00, 'Qris', 1, 32000.00),
(43, 32, '2025-02-24', 25, 49000.00, 'cash', 1, 49000.00),
(44, 24, '2025-02-28', 25, 32000.00, 'Qris', 1, 32000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `ProdukID` int(11) NOT NULL,
  `NamaProduk` varchar(100) DEFAULT NULL,
  `HargaSatuan` decimal(10,2) DEFAULT NULL,
  `Kategori` varchar(50) NOT NULL,
  `Stok` int(11) DEFAULT NULL,
  `Gambar_Produk` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`ProdukID`, `NamaProduk`, `HargaSatuan`, `Kategori`, `Stok`, `Gambar_Produk`) VALUES
(24, 'L.A ice', 32000.00, 'barang', 20, 'th.jpeg'),
(25, 'Djarum Coklat', 12000.00, 'barang', 20, 'images.jpeg'),
(32, 'Sampoerna Avolution', 49000.00, 'barang', 20, 'th (1).jpeg'),
(47, 'Magnum', 28000.00, 'barang', 20, 'magnum.jpeg'),
(48, 'Dji Sam Soe super premium', 25000.00, 'barang', 20, 'jssp.jpeg'),
(49, 'Sampoerna Mild', 35000.00, 'barang', 20, 'sm.jpeg'),
(50, 'WIN Hijau', 12500.00, 'barang', 20, 'wh.jpeg'),
(51, 'Dji Sam Soe ', 13000.00, 'barang', 20, 'jss.jpeg'),
(52, 'Juara Jambu', 15500.00, 'barang', 20, 'JJ.jpeg'),
(53, 'Gudang Garam Merah', 18000.00, 'barang', 20, 'gg.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`PelangganID`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`PenjualanID`),
  ADD KEY `PelangganID` (`PelangganID`),
  ADD KEY `fk_produk` (`ProdukID`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ProdukID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `PelangganID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `PenjualanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `ProdukID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`ProdukID`) REFERENCES `produk` (`ProdukID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`PelangganID`) REFERENCES `pelanggan` (`PelangganID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
