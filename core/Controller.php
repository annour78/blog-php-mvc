<?php
class Controller {

    // Load a model
    public function model($model) {
        require_once __DIR__ . '/../app/models/' . $model . '.php';
        return new $model();
    }

    // Load a view with layout
    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../app/views/layouts/header.php';
        require_once __DIR__ . '/../app/views/' . $view . '.php';
        require_once __DIR__ . '/../app/views/layouts/footer.php';
    }

    // Redirect to a URL
    public function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Check if user is admin
    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Require login middleware
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/Blog/public/login');
        }
    }

    // Require admin middleware
    public function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->redirect('/Blog/public/');
        }
    }

    // Generate CSRF token
    public function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Verify CSRF token
    public function verifyCsrfToken() {
        if (!isset($_POST['csrf_token']) || 
            !isset($_SESSION['csrf_token']) || 
            $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed. Please go back and try again.');
        }
    }
}