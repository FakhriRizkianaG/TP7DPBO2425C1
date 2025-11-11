<?php
require_once 'config/db.php';

class Developer {
    private $db;
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // READ (JOIN User)
    public function getAll() {
        $sql = "SELECT d.DevId, d.Name, d.Owner, u.Name AS OwnerName, d.Status
                FROM Developer d
                JOIN User u ON d.Owner = u.UserId";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // CREATE
    public function add($name, $owner, $status) {
        $stmt = $this->db->prepare("INSERT INTO Developer (Name, Owner, Status) VALUES (?, ?, ?)");
        $stmt->execute([$name, $owner, $status]);
    }

    // UPDATE
    public function update($id, $name, $owner, $status) {
        $stmt = $this->db->prepare("UPDATE Developer SET Name=?, Owner=?, Status=? WHERE DevId=?");
        $stmt->execute([$name, $owner, $status, $id]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Developer WHERE DevId=?");
        $stmt->execute([$id]);
    }
}
?>
