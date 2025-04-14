<?php
class User {
    private $db;
    private $table = 'users';  // Sesuaikan dengan nama tabel di database Anda

    public function __construct($db) {
        $this->db = $db;
    }

    // Mendapatkan user berdasarkan email
    public function getUserByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan user baru
    public function tambahUser($username, $email, $password, $level = 'petugas') {
        $query = "INSERT INTO {$this->table} (username, email, password, level) VALUES (:username, :email, :password, :level)";
        $stmt = $this->db->prepare($query);
        
        // Binding parameter
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':level', $level);

        return $stmt->execute();
    }

    // Update informasi user (misalnya, update password atau level)
    public function updateUser($id, $username, $email, $password, $level) {
        $query = "UPDATE {$this->table} SET username = :username, email = :email, password = :password, level = :level WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id_user', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':level', $level);

        return $stmt->execute();
    }

    // Menghapus user berdasarkan ID
    public function deleteUser($id) {
        $query = "DELETE FROM {$this->table} WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id);
        return $stmt->execute();
    }

    // Mendapatkan semua pengguna
    public function getAllUsers() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
