<?php
namespace Src\Model;

use PDO;

class RecipeModel {
    private $db;

    public function __construct() {
        $dsn = 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME');
        $this->db = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM recipes');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES (?, ?, ?, ?)');
        $stmt->execute([$data['name'], $data['prep_time'], $data['difficulty'], $data['vegetarian']]);
        return ['id' => $this->db->lastInsertId()];
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM recipes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE recipes SET name = ?, prep_time = ?, difficulty = ?, vegetarian = ? WHERE id = ?');
        $stmt->execute([$data['name'], $data['prep_time'], $data['difficulty'], $data['vegetarian'], $id]);
        return ['status' => 'updated'];
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM recipes WHERE id = ?');
        $stmt->execute([$id]);
        return ['status' => 'deleted'];
    }

    public function rate($id, $score) {
        $stmt = $this->db->prepare('INSERT INTO ratings (recipe_id, score) VALUES (?, ?)');
        $stmt->execute([$id, $score]);
        return ['status' => 'rated'];
    }

    public function search($query) {
        $stmt = $this->db->prepare("SELECT * FROM recipes WHERE name ILIKE ?");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
