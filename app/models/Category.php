<?php
class Category extends Model {

    // Get all categories
    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return [];
        }
    }

    // Find category by id
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding category: " . $e->getMessage());
            return false;
        }
    }

    // Create a new category
    public function create($name, $slug) {
        try {
            $stmt = $this->db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
            return $stmt->execute([$name, $slug]);
        } catch (PDOException $e) {
            error_log("Error creating category: " . $e->getMessage());
            return false;
        }
    }
}