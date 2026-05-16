<?php
class AuthController extends Controller {

    // Show login form
    public function loginForm() {
        $this->view('auth/login');
    }

    // Handle login
    public function login() {
        // Verify CSRF token
        $this->verifyCsrfToken();

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                $this->redirect('/Blog/public/admin');
            } else {
                $this->redirect('/Blog/public/');
            }
        } else {
            $this->view('auth/login', ['error' => 'Invalid email or password']);
        }
    }

    // Show register form
    public function registerForm() {
        $this->view('auth/register');
    }

    // Handle register
    public function register() {
        // Verify CSRF token
        $this->verifyCsrfToken();

        $username = htmlspecialchars(trim($_POST['username'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $userModel = $this->model('User');

        // Validate fields
        if (empty($username) || empty($email) || empty($password)) {
            $this->view('auth/register', ['error' => 'All fields are required']);
            return;
        }

        // Check passwords match
        if ($password !== $confirm) {
            $this->view('auth/register', ['error' => 'Passwords do not match']);
            return;
        }

        // Check password length
        if (strlen($password) < 6) {
            $this->view('auth/register', ['error' => 'Password must be at least 6 characters']);
            return;
        }

        // Check if email exists
        if ($userModel->emailExists($email)) {
            $this->view('auth/register', ['error' => 'Email already exists']);
            return;
        }

        // Check if username exists
        if ($userModel->usernameExists($username)) {
            $this->view('auth/register', ['error' => 'Username already exists']);
            return;
        }

        // Create user
        $userModel->create($username, $email, $password);
        $this->redirect('/Blog/public/login');
    }

    // Handle logout
    public function logout() {
        session_destroy();
        $this->redirect('/Blog/public/');
    }
}