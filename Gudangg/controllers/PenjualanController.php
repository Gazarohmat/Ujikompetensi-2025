<?php

// Pastikan file Penjualan.php, Pelanggan.php, dan Produk.php sudah di-include
require_once 'models/Penjualan.php';
require_once 'models/Pelanggan.php';
require_once 'models/Produk.php';

class PenjualanController {
    private $penjualan;
    private $pelanggan;
    private $produk;

    public function __construct($db) {
        $this->penjualan = new Penjualan($db);
        $this->pelanggan = new Pelanggan($db);
        $this->produk = new Produk($db);  // Inisialisasi produk model
    }

    // Metode untuk menampilkan data penjualan
    public function index() {
        // Ambil semua data penjualan beserta detail produk
        $penjualanList = $this->penjualan->getAllPenjualan();

        // Ambil daftar pelanggan dan produk untuk dropdown
        $pelangganList = $this->pelanggan->getAllPelanggan();
        $produkList = $this->produk->getAllProduk();

        // Kirimkan data penjualan, pelanggan, dan produk ke view
        include 'views/penjualan/penjualan_list.php'; 
    }

    // Metode untuk menambah data penjualan baru
    public function penjualan_tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form dan lakukan validasi
            $tanggalPenjualan = $_POST['TanggalPenjualan'];
            $pelangganID = $_POST['PelangganID'];
            $produkID = $_POST['ProdukID'];  // Ambil ProdukID
            $kuantitas = $_POST['Kuantitas'];  // Ambil Kuantitas
            $totalPembayaran = $_POST['TotalPembayaran'];
            $metodePembayaran = $_POST['MetodePembayaran'];

            // Hitung subtotal berdasarkan kuantitas dan harga produk
            $hargaSatuan = $this->produk->getProdukHarga($produkID);  // Pastikan ada method getProdukHarga() dalam model Produk
            $subtotal = $hargaSatuan * $kuantitas;

            // Validasi input
            if (empty($tanggalPenjualan) || empty($pelangganID) || empty($produkID) || empty($kuantitas) || empty($subtotal) || empty($totalPembayaran) || empty($metodePembayaran)) {
                echo 'Semua kolom harus diisi.';
                return;
            }

            // Panggil method untuk menyimpan data penjualan
            $result = $this->penjualan->addPenjualan($tanggalPenjualan, $pelangganID, $produkID, $kuantitas, $subtotal, $totalPembayaran, $metodePembayaran);

            if ($result) {
                header('Location: index.php?action=penjualan_list');
                exit;
            } else {
                echo 'Gagal menambah data penjualan.';
            }
        } else {
            // Ambil daftar pelanggan dan produk untuk dropdown
            $pelangganList = $this->pelanggan->getAllPelanggan();
            $produkList = $this->produk->getAllProduk();

            // Kirimkan data pelanggan dan produk ke view untuk dropdown
            include 'views/penjualan/penjualan_tambah.php';
        }
    }
}