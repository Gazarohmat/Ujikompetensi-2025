<?php
require_once 'models/Produk.php';

class ProdukController {
    private $produkModel;

    public function __construct() {
        $this->produkModel = new Produk();
    }
    
    public function index() {
        // Mengambil data produk dari model
        $produk = $this->produkModel->getAllProduk();  // Mengambil semua produk dari model
    
        // Jika produk kosong, tampilkan pesan error
        if ($produk === null || empty($produk)) {
            echo "Tidak ada produk yang tersedia";
            return;
        }

    }
    
      // Show the list of products
    public function produkList() {
        // Fetch all products from the model
        $produk = $this->produkModel->getAllProduk();
   
        
        // Include the produk_list.php view
        require_once 'views/produk/produk_list.php'; 
    }

    // Menambah produk
    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['NamaProduk'];
            $harga = $_POST['HargaSatuan'];
            $kategori = $_POST['Kategori'];
            $stok = $_POST['Stok'];

            // Pastikan kategori diisi
            if (empty($kategori)) {
                echo "Kategori wajib diisi!";
                return;
            }

            // Proses upload gambar
            $gambar = $_FILES['Gambar_Produk']['name'];
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($gambar);

            if (move_uploaded_file($_FILES['Gambar_Produk']['tmp_name'], $targetFile)) {
                $this->produkModel->addProduk($nama, $harga, $kategori, $stok, $gambar);
                header("Location: index.php");
                exit();
            } else {
                echo "Upload gambar gagal!";
            }
        } else {
            require_once 'views/produk/produk_tambah.php';
        }
    }

    // Mengubah produk
    public function ubah() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $produk = $this->produkModel->getProdukById($id);  // Ambil data produk berdasarkan ID
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nama = $_POST['NamaProduk'];
                $harga = $_POST['HargaSatuan'];
                $kategori = $_POST['Kategori'];
                $stok = $_POST['Stok'];
    
                // Pastikan kategori diisi
                if (empty($kategori)) {
                    echo "Kategori wajib diisi!";
                    return;
                }
    
                // Jika ada gambar baru yang di-upload, proses gambar tersebut
                if (!empty($_FILES['Gambar_Produk']['name'])) {
                    // Ambil nama gambar yang di-upload
                    $gambar = $_FILES['Gambar_Produk']['name'];
                    $targetDir = "uploads/";
                    $targetFile = $targetDir . basename($gambar);
    
                    // Pindahkan gambar ke folder upload
                    if (move_uploaded_file($_FILES['Gambar_Produk']['tmp_name'], $targetFile)) {
                        echo "Gambar berhasil di-upload.";
                    } else {
                        echo "Gambar gagal di-upload.";
                    }
                } else {
                    // Jika tidak ada gambar baru, gunakan gambar lama
                    $gambar = $produk['Gambar_Produk'];  // Tetap pakai gambar lama
                }
    
                // Update produk di database
                $this->produkModel->updateProduk($id, $nama, $harga, $kategori, $stok, $gambar);
    
                // Redirect ke halaman utama setelah update
                header("Location: index.php");
                exit();
            }
        }
    }
    
    // Menghapus produk
    public function hapus() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->produkModel->deleteProduk($id);
            header("Location: index.php");
            exit();
        }
    }

    
}
?>