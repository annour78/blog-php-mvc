<?php
class AuthController extends Controller {

    public function loginForm() {
        $this->view('auth/login');
    }

    public function login() {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                $this->redirect('/blog/public/admin');
            } else {
                $this->redirect('/blog/public/');
            }
        } else {
            $this->view('auth/login', ['error' => 'Invalid email or password']);
        }
    }

    public function registerForm() {
        $this->view('auth/register');
    }

    public function register() {
        $username = htmlspecialchars(trim($_POST['username'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $userModel = $this->model('User');

        if (empty($username) || empty($email) || empty($password)) {
            $this->view('auth/register', ['error' => 'All fields are required']);
            return;
        }

        if ($password !== $confirm) {
            $this->view('auth/register', ['error' => 'Passwords do not match']);
            return;
        }

        if (strlen($password) < 6) {
            $this->view('auth/register', ['error' => 'Password must be at least 6 characters']);
            return;
        }

        if ($userModel->emailExists($email)) {
            $this->view('auth/register', ['error' => 'Email already exists']);
            return;
        }

        if ($userModel->usernameExists($username)) {
            $this->view('auth/register', ['error' => 'Username already exists']);
            return;
        }

        $userModel->create($username, $email, $password);
        $this->redirect('/blog/public/login');
    }

    public function logout() {
        session_destroy();
        $this->redirect('/blog/public/');
    }
}