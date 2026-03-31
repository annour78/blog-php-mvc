<?php
class Controller {

    public function model($model) {
        require_once __DIR__ . '/../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../app/views/layouts/header.php';
        require_once __DIR__ . '/../app/views/' . $view . '.php';
        require_once __DIR__ . '/../app/views/layouts/footer.php';
    }

    public function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/blog/public/login');
        }
    }

    public function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->redirect('/blog/public/');
        }
    }
}