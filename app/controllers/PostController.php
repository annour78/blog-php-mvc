<?php
class PostController extends Controller {

    public function index() {
        $postModel = $this->model('Post');
        $categoryModel = $this->model('Category');
        $posts = $postModel->getAll();
        $categories = $categoryModel->getAll();
        $this->view('posts/index', ['posts' => $posts, 'categories' => $categories]);
    }

    public function show($slug) {
        $postModel = $this->model('Post');
        $commentModel = $this->model('Comment');
        $post = $postModel->findBySlug($slug);

        if (!$post) {
            echo "<h1>Post not found</h1>";
            return;
        }

        $comments = $commentModel->getByPost($post['id']);
        $this->view('posts/show', ['post' => $post, 'comments' => $comments]);
    }

    public function adminIndex() {
        $this->requireAdmin();
        $postModel = $this->model('Post');
        $posts = $postModel->getAll();
        $this->view('admin/dashboard', ['posts' => $posts]);
    }

    public function createForm() {
        $this->requireAdmin();
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAll();
        $this->view('posts/create', ['categories' => $categories]);
    }

    public function create() {
        $this->requireAdmin();

        $title = htmlspecialchars(trim($_POST['title'] ?? ''));
        $content = htmlspecialchars(trim($_POST['content'] ?? ''));
        $category_id = (int)($_POST['category_id'] ?? 0);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $image = null;
        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($ext), $allowed)) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'],
                    BASE_PATH . '/public/uploads/' . $image);
            }
        }

        $postModel = $this->model('Post');
        $postModel->create($title, $slug, $content, $image, $_SESSION['user_id'], $category_id);
        $this->redirect('/blog/public/admin');
    }

    public function editForm($id) {
        $this->requireAdmin();
        $postModel = $this->model('Post');
        $categoryModel = $this->model('Category');
        $post = $postModel->findById($id);
        $categories = $categoryModel->getAll();
        $this->view('posts/edit', ['post' => $post, 'categories' => $categories]);
    }

    public function edit($id) {
        $this->requireAdmin();

        $title = htmlspecialchars(trim($_POST['title'] ?? ''));
        $content = htmlspecialchars(trim($_POST['content'] ?? ''));
        $category_id = (int)($_POST['category_id'] ?? 0);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $postModel = $this->model('Post');
        $post = $postModel->findById($id);
        $image = $post['image'];

        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($ext), $allowed)) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'],
                    BASE_PATH . '/public/uploads/' . $image);
            }
        }

        $postModel->update($id, $title, $slug, $content, $image, $category_id);
        $this->redirect('/blog/public/admin');
    }

    public function delete($id) {
        $this->requireAdmin();
        $postModel = $this->model('Post');
        $postModel->delete($id);
        $this->redirect('/blog/public/admin');
    }
}