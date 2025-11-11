<?php
require_once 'config/db.php';

class Game {
    private $db;
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // READ (JOIN Developer)
    public function getAll() {
        $sql = "SELECT g.GameId, g.Name, g.Developer, d.Name AS DeveloperName, g.Genre, g.Price
                FROM Games g
                JOIN Developer d ON g.Developer = d.DevId";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // CREATE
    public function add($name, $developer, $genre, $price) {
        $stmt = $this->db->prepare("INSERT INTO Games (Name, Developer, Genre, Price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $developer, $genre, $price]);
    }

    // UPDATE
    public function update($id, $name, $developer, $genre, $price) {
        $stmt = $this->db->prepare("UPDATE Games SET Name=?, Developer=?, Genre=?, Price=? WHERE GameId=?");
        $stmt->execute([$name, $developer, $genre, $price, $id]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Games WHERE GameId=?");
        $stmt->execute([$id]);
    }
}
?>
