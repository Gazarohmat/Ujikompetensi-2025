<?php
require_once 'config/database.php';

class Penjualan {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil semua data penjualan beserta detail produk
    public function getAllPenjualan() {
        $query = "SELECT p.PenjualanID, p.TanggalPenjualan, pl.Nama AS PelangganNama, pr.NamaProduk, pr.Stok, 
           p.Kuantitas, p.TotalPembayaran, p.MetodePembayaran
    FROM penjualan p
    JOIN pelanggan pl ON p.PelangganID = pl.PelangganID
    JOIN produk pr ON p.ProdukID = pr.ProdukID
";
        
        $result = $this->db->conn->query($query);
    
        if (!$result) {
            // Log the error and show the SQL error message
            die("Query failed: " . $this->db->conn->error);
        }
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil data pelanggan
    public function getAllPelanggan() {
        $query = "SELECT PelangganID, Nama FROM pelanggan";
        $result = $this->db->conn->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil penjualan berdasarkan PenjualanID beserta detail produk
    public function getPenjualanById($id) {
        $query = "SELECT p.PenjualanID, p.TanggalPenjualan, p.TotalPembayaran, 
                         pr.NamaProduk, pr.Stok, p.Kuantitas, p.Subtotal
                  FROM penjualan p
                  JOIN produk pr ON p.ProdukID = pr.ProdukID
                  WHERE p.PenjualanID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Kembalikan data penjualan beserta detail produk
    }

    // Tambah penjualan baru
    public function addPenjualan($tanggal, $pelangganID, $produkID, $kuantitas, $subtotal, $totalPembayaran, $metodePembayaran) {
        // Mulai transaksi agar konsisten
        $this->db->conn->begin_transaction();

        // Query untuk menyimpan penjualan baru
        $query = "INSERT INTO penjualan (TanggalPenjualan, PelangganID, ProdukID, Kuantitas, Subtotal, TotalPembayaran, MetodePembayaran) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("siidids", $tanggal, $pelangganID, $produkID, $kuantitas, $subtotal, $totalPembayaran, $metodePembayaran);

        if ($stmt->execute()) {
            $penjualanID = $this->db->conn->insert_id;
            
            // Update stok produk setelah penjualan berhasil ditambahkan
            $stockResult = $this->kurangiStock($produkID, $kuantitas);

            if ($stockResult) {
                // Jika stok berhasil dikurangi, commit transaksi
                $this->db->conn->commit();
                return $penjualanID;
            } else {
                // Jika pengurangan stok gagal, rollback transaksi
                $this->db->conn->rollback();
                return false;
            }
        } else {
            // Jika penyimpanan penjualan gagal, rollback transaksi
            $this->db->conn->rollback();
            return false;
        }
    }

    // Mengurangi stok produk
    private function kurangiStock($produkID, $kuantitas) {
        $query = "UPDATE produk SET Stok = Stok - ? WHERE ProdukID = ? AND Stok >= ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("iii", $kuantitas, $produkID, $kuantitas);
        return $stmt->execute();  // Return true if stock is successfully reduced, false otherwise
    }

    // Ubah data penjualan
    public function updatePenjualan($id, $tanggal, $pelangganID, $produkID, $kuantitas, $subtotal, $totalPembayaran, $metodePembayaran) {
        // Mulai transaksi agar konsisten
        $this->db->conn->begin_transaction();

        // Query untuk memperbarui penjualan
        $query = "UPDATE penjualan SET TanggalPenjualan = ?, PelangganID = ?, ProdukID = ?, Kuantitas = ?, Subtotal = ?, TotalPembayaran = ?, MetodePembayaran = ? 
                  WHERE PenjualanID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("siididsi", $tanggal, $pelangganID, $produkID, $kuantitas, $subtotal, $totalPembayaran, $metodePembayaran, $id);
        
        if ($stmt->execute()) {
            // Update stok produk setelah penjualan diperbarui
            $stockResult = $this->kurangiStock($produkID, $kuantitas);
            
            if ($stockResult) {
                // Jika stok berhasil dikurangi, commit transaksi
                $this->db->conn->commit();
                return true;
            } else {
                // Jika pengurangan stok gagal, rollback transaksi
                $this->db->conn->rollback();
                return false;
            }
        } else {
            // Jika update penjualan gagal, rollback transaksi
            $this->db->conn->rollback();
            return false;
        }
    }

    // Hapus penjualan berdasarkan PenjualanID
    public function deletePenjualan($id) {
        $query = "DELETE FROM penjualan WHERE PenjualanID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        // Execute and return the result of the execution
        return $stmt->execute();
    }
}
?>
