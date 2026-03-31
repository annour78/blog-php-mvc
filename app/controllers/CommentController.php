<?php
class CommentController extends Controller {

    public function add($post_id) {
        $this->requireLogin();

        $content = htmlspecialchars(trim($_POST['content'] ?? ''));

        if (empty($content)) {
            $this->redirect('/blog/public/post/' . $post_id);
            return;
        }

        $commentModel = $this->model('Comment');
        $commentModel->create($content, $_SESSION['user_id'], $post_id);

        $postModel = $this->model('Post');
        $post = $postModel->findById($post_id);
        $this->redirect('/blog/public/post/' . $post['slug']);
    }

    public function delete($id) {
        $this->requireLogin();

        $commentModel = $this->model('Comment');
        $comment = $commentModel->findById($id);

        if ($comment) {
            if ($_SESSION['role'] === 'admin' || $comment['user_id'] == $_SESSION['user_id']) {
                $commentModel->delete($id);
            }
        }

        $postModel = $this->model('Post');
        $post = $postModel->findById($comment['post_id']);
        $this->redirect('/blog/public/post/' . $post['slug']);
    }
}