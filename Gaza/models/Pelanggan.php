<?php
require_once 'config/database.php';

class Pelanggan {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil semua data pelanggan
    public function getAllPelanggan() {
        $query = "SELECT * FROM pelanggan";
        $result = $this->db->conn->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil pelanggan berdasarkan PelangganID
    public function getPelangganById($id) {
        $query = "SELECT * FROM pelanggan WHERE PelangganID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Kembalikan data pelanggan sebagai array asosiatif
    }

    // Tambah pelanggan baru
    public function addPelanggan($nama, $alamat, $telepon, $email) {
        $query = "INSERT INTO pelanggan (Nama, Alamat, Telepon, Email) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssss", $nama, $alamat, $telepon, $email);
        return $stmt->execute();
    }

    // Ubah data pelanggan
    public function updatePelanggan($id, $nama, $alamat, $telepon, $email) {
        $query = "UPDATE pelanggan SET Nama = ?, Alamat = ?, Telepon = ?, Email = ? WHERE PelangganID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssssi", $nama, $alamat, $telepon, $email, $id);
        return $stmt->execute();
    }

    // Hapus pelanggan berdasarkan PelangganID
    public function deletePelanggan($id) {
        $query = "DELETE FROM pelanggan WHERE PelangganID = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
