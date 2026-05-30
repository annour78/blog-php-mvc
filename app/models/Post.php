<?php
class Post extends Model {

    // Get all posts with user and category info
    public function getAll() {
        try {
            $stmt = $this->db->query("
                SELECT posts.*, users.username, categories.name as category_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                JOIN categories ON posts.category_id = categories.id
                ORDER BY posts.created_at DESC
            ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting posts: " . $e->getMessage());
            return [];
        }
    }

    // Find post by slug
    public function findBySlug($slug) {
        try {
            $stmt = $this->db->prepare("
                SELECT posts.*, users.username, categories.name as category_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                JOIN categories ON posts.category_id = categories.id
                WHERE posts.slug = ?
            ");
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding post by slug: " . $e->getMessage());
            return false;
        }
    }

    // Find post by id
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT posts.*, users.username, categories.name as category_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                JOIN categories ON posts.category_id = categories.id
                WHERE posts.id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding post by id: " . $e->getMessage());
            return false;
        }
    }

    // Create a new post
    public function create($title, $slug, $content, $image, $user_id, $category_id) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO posts (title, slug, content, image, user_id, category_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$title, $slug, $content, $image, $user_id, $category_id]);
        } catch (PDOException $e) {
            error_log("Error creating post: " . $e->getMessage());
            return false;
        }
    }

    // Update a post
    public function update($id, $title, $slug, $content, $image, $category_id) {
        try {
            $stmt = $this->db->prepare("
                UPDATE posts SET title = ?, slug = ?, content = ?, image = ?, category_id = ?
                WHERE id = ?
            ");
            return $stmt->execute([$title, $slug, $content, $image, $category_id, $id]);
        } catch (PDOException $e) {
            error_log("Error updating post: " . $e->getMessage());
            return false;
        }
    }

    // Delete a post
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting post: " . $e->getMessage());
            return false;
        }
    }

    // Check if slug exists
    public function slugExists($slug) {
        try {
            $stmt = $this->db->prepare("SELECT id FROM posts WHERE slug = ?");
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error checking slug: " . $e->getMessage());
            return false;
        }
    }
}