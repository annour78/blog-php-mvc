<?php
class Comment extends Model {

    public function getByPost($post_id) {
        $stmt = $this->db->prepare("
            SELECT comments.*, users.username
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = ?
            ORDER BY comments.created_at ASC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }

    public function create($content, $user_id, $post_id) {
        $stmt = $this->db->prepare("
            INSERT INTO comments (content, user_id, post_id)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$content, $user_id, $post_id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}