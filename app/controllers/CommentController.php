<?php
class CommentController extends Controller {

    // Handle add comment
    public function add($post_id) {
        $this->requireLogin();

        // Verify CSRF token
        $this->verifyCsrfToken();

        $content = htmlspecialchars(trim($_POST['content'] ?? ''));

        // Validate content
        if (empty($content)) {
            $this->redirect('/Blog/public/post/' . $post_id);
            return;
        }

        // Save comment to database
        $commentModel = $this->model('Comment');
        $commentModel->create($content, $_SESSION['user_id'], $post_id);

        // Redirect back to post
        $postModel = $this->model('Post');
        $post = $postModel->findById($post_id);
        $this->redirect('/Blog/public/post/' . $post['slug']);
    }

    // Handle delete comment
    public function delete($id) {
        $this->requireLogin();

        $commentModel = $this->model('Comment');
        $comment = $commentModel->findById($id);

        // Check permission - admin or comment owner
        if ($comment) {
            if ($_SESSION['role'] === 'admin' || $comment['user_id'] == $_SESSION['user_id']) {
                $commentModel->delete($id);
            }
        }

        // Redirect back to post
        $postModel = $this->model('Post');
        $post = $postModel->findById($comment['post_id']);
        $this->redirect('/Blog/public/post/' . $post['slug']);
    }
}