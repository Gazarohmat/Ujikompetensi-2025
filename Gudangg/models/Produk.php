<?php
require_once 'config/database.php';

class Produk {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = new Database();
    }

    // Ambil semua data produk
    public function getAllProduk() {
        $query = "SELECT * FROM produk";
        $result = $this->db->conn->query($query);

        if ($result === false) {
            // Tangani kegagalan query
            die("Query failed: " . $this->db->conn->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil produk berdasarkan ProdukID
    public function getProdukById($id) {
        $id = $this->sanitizeInput($id); // Sanitasi input untuk mencegah SQL injection
        $query = "SELECT * FROM produk WHERE ProdukID = ?";
        $stmt = $this->db->conn->prepare($query);

        if (!$stmt) {
            die("Prepare statement failed: " . $this->db->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Mengembalikan produk sebagai array asosiatif
        }

        return null; // Tidak ada produk ditemukan
    }

    // Tambah produk baru
    public function addProduk($nama, $harga, $kategori, $stok, $gambar) {
        $nama = $this->sanitizeInput($nama); // Sanitasi input
        $harga = $this->sanitizeInput($harga); // Sanitasi input
        $kategori = $this->sanitizeInput($kategori); // Sanitasi input
        $stok = $this->sanitizeInput($stok); // Sanitasi input
        $gambar = $this->sanitizeInput($gambar); // Sanitasi input

        // Mulai transaksi untuk memastikan integritas data
        $this->db->conn->begin_transaction();

        $query = "INSERT INTO produk (NamaProduk, HargaSatuan, Kategori, Stok, Gambar_Produk) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);

        if (!$stmt) {
            $this->db->conn->rollback();
            die("Prepare statement failed: " . $this->db->conn->error);
        }

        $stmt->bind_param("sdsis", $nama, $harga, $kategori, $stok, $gambar);
        $result = $stmt->execute();

        if ($result) {
            // Commit transaksi jika eksekusi berhasil
            $this->db->conn->commit();
            return true;
        } else {
            // Rollback transaksi jika eksekusi gagal
            $this->db->conn->rollback();
            die("Execution failed: " . $stmt->error);
        }
    }

    // Ubah data produk
    public function updateProduk($id, $nama, $harga, $kategori, $stok, $gambar = null) {
        $id = $this->sanitizeInput($id); // Sanitasi input
        $nama = $this->sanitizeInput($nama); // Sanitasi input
        $harga = $this->sanitizeInput($harga); // Sanitasi input
        $kategori = $this->sanitizeInput($kategori); // Sanitasi input
        $stok = $this->sanitizeInput($stok); // Sanitasi input
        $gambar = $this->sanitizeInput($gambar); // Sanitasi input

        // Mulai transaksi
        $this->db->conn->begin_transaction();

        if ($gambar) {
            $query = "UPDATE produk SET NamaProduk = ?, HargaSatuan = ?, Kategori = ?, Stok = ?, Gambar_Produk = ? WHERE ProdukID = ?";
            $stmt = $this->db->conn->prepare($query);

            if (!$stmt) {
                $this->db->conn->rollback();
                die("Prepare statement failed: " . $this->db->conn->error);
            }

            $stmt->bind_param("sdsisi", $nama, $harga, $kategori, $stok, $gambar, $id);
        } else {
            $query = "UPDATE produk SET NamaProduk = ?, HargaSatuan = ?, Kategori = ?, Stok = ? WHERE ProdukID = ?";
            $stmt = $this->db->conn->prepare($query);

            if (!$stmt) {
                $this->db->conn->rollback();
                die("Prepare statement failed: " . $this->db->conn->error);
            }

            $stmt->bind_param("sdsii", $nama, $harga, $kategori, $stok, $id);
        }

        $result = $stmt->execute();

        if ($result) {
            // Commit transaksi jika eksekusi berhasil
            $this->db->conn->commit();
            return true;
        } else {
            // Rollback transaksi jika eksekusi gagal
            $this->db->conn->rollback();
            die("Execution failed: " . $stmt->error);
        }
    }

    // Hapus produk berdasarkan ProdukID
    public function deleteProduk($id) {
        $id = $this->sanitizeInput($id); // Sanitasi input
        $query = "DELETE FROM produk WHERE ProdukID = ?";
        $stmt = $this->db->conn->prepare($query);

        if (!$stmt) {
            die("Prepare statement failed: " . $this->db->conn->error);
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        if (!$result) {
            die("Execution failed: " . $stmt->error);
        }

        return $result;
    }

    // Ambil harga produk berdasarkan ProdukID
    public function getProdukHarga($produkID) {
        $produkID = $this->sanitizeInput($produkID); // Sanitasi input
        $query = "SELECT HargaSatuan FROM produk WHERE ProdukID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $produkID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek jika produk ditemukan
        if ($row = $result->fetch_assoc()) {
            return $row['HargaSatuan'];
        } else {
            // Jika produk tidak ditemukan, kembalikan false atau nilai default
            return false;
        }
    }

    // Fitur tambahan untuk validasi atau sanitasi input, jika diperlukan
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input));
    }
}
?>
