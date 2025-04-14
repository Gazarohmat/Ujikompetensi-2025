<?php
class Database {
    private $host = "sql210.infinityfree.com";
    private $user = "if0_38715350";  // Sesuaikan dengan user MySQL Anda
    private $pass = "hWt90xhKvVlgTDG";  // Sesuaikan dengan password MySQL Anda
    private $db_name = "if0_38715350_GudangG";  // Ganti dengan nama database Anda
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    // Tambahkan fungsi untuk mendapatkan koneksi
    public function getConnection() {
        return $this->conn;
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function close() {
        $this->conn->close();
    }
}
?>
