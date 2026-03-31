<?php
class Post extends Model {

    public function getAll() {
        $stmt = $this->db->query("
            SELECT posts.*, users.username, categories.name as category_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            JOIN categories ON posts.category_id = categories.id
            ORDER BY posts.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function findBySlug($slug) {
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username, categories.name as category_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            JOIN categories ON posts.category_id = categories.id
            WHERE posts.slug = ?
        ");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username, categories.name as category_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            JOIN categories ON posts.category_id = categories.id
            WHERE posts.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($title, $slug, $content, $image, $user_id, $category_id) {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, slug, content, image, user_id, category_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$title, $slug, $content, $image, $user_id, $category_id]);
    }

    public function update($id, $title, $slug, $content, $image, $category_id) {
        $stmt = $this->db->prepare("
            UPDATE posts SET title = ?, slug = ?, content = ?, image = ?, category_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$title, $slug, $content, $image, $category_id, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function slugExists($slug) {
        $stmt = $this->db->prepare("SELECT id FROM posts WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}