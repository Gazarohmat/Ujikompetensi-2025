<?php

// Include the database connection and controllers
require_once 'config/database.php';  
require_once 'controllers/ProdukController.php';
require_once 'controllers/PelangganController.php';
require_once 'controllers/PenjualanController.php';
require_once 'views/layout/header.php';

// Inisialisasi objek Database untuk koneksi
$db = new Database();  

// Inisialisasi objek controller
$produkController = new ProdukController($db);
$pelangganController = new PelangganController($db);
$penjualanController = new PenjualanController($db); // Inisialisasi DetailPenjualanController

// Handle request based on the action
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        // Produk actions
        case 'produk_list':
            $produkController->produkList();
            break;
        case 'tambah':
            $produkController->tambah();
            break;
        case 'ubah':
            $produkController->ubah();
            break;
        case 'hapus':
            $produkController->hapus();
            break;

        // Pelanggan actions
        case 'pelanggan_list':
            $pelangganController->index();
            break;
        case 'pelanggan_store':
            $pelangganController->store();
            break;
        case 'pelanggan_edit':
            $pelangganController->edit($_GET['id']);
            break;
        case 'pelanggan_update':
            $pelangganController->update($_GET['id']);
            break;
        case 'pelanggan_destroy':
            $pelangganController->destroy($_GET['id']);
            break;

        // Penjualan actions
        case 'penjualan_list':
            $penjualanController->index();
            break;
        case 'penjualan_tambah':
            $penjualanController->penjualan_tambah();
            break;
    }
} else {
    $produkController->produkList();
}

require_once 'views/layout/footer.php';
?>
