<?php
require_once 'config/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Ambil semua user
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM `User`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah user baru (DateJoined otomatis)
    public function add($id, $name, $bio) {
        $stmt = $this->db->prepare("INSERT INTO `User` (UserId, Name, Bio, DateJoined) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([$id, $name, $bio]);
    }

    // Update data user (tanpa ubah DateJoined)
    public function update($id, $name, $bio) {
        $stmt = $this->db->prepare("UPDATE `User` SET Name = ?, Bio = ? WHERE UserId = ?");
        $stmt->execute([$name, $bio, $id]);
    }

    // Hapus user berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM `User` WHERE UserId = ?");
        $stmt->execute([$id]);
    }
}
?>
