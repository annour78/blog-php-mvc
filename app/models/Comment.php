<?php
class Comment extends Model {

    // Get all comments for a post
    public function getByPost($post_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT comments.*, users.username
                FROM comments
                JOIN users ON comments.user_id = users.id
                WHERE comments.post_id = ?
                ORDER BY comments.created_at ASC
            ");
            $stmt->execute([$post_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting comments: " . $e->getMessage());
            return [];
        }
    }

    // Create a new comment
    public function create($content, $user_id, $post_id) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO comments (content, user_id, post_id)
                VALUES (?, ?, ?)
            ");
            return $stmt->execute([$content, $user_id, $post_id]);
        } catch (PDOException $e) {
            error_log("Error creating comment: " . $e->getMessage());
            return false;
        }
    }

    // Delete a comment
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting comment: " . $e->getMessage());
            return false;
        }
    }

    // Find comment by id
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error finding comment: " . $e->getMessage());
            return false;
        }
    }
}