<?php
/**
 * Basic Tests for Blog PHP MVC Application
 * Run this file to verify core functionality
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Post.php';
require_once __DIR__ . '/app/models/Category.php';
require_once __DIR__ . '/app/models/Comment.php';

$passed = 0;
$failed = 0;

function test($name, $result) {
    global $passed, $failed;
    if ($result) {
        echo "✅ PASSED: $name\n";
        $passed++;
    } else {
        echo "❌ FAILED: $name\n";
        $failed++;
    }
}

echo "========================================\n";
echo "   Blog PHP MVC - Basic Tests\n";
echo "========================================\n\n";

// Test 1: Database connection
echo "--- Database Tests ---\n";
try {
    $db = Database::getInstance()->getConnection();
    test('Database connection', $db !== null);
} catch (Exception $e) {
    test('Database connection', false);
}

// Test 2: User Model
echo "\n--- User Model Tests ---\n";
try {
    $userModel = new User();
    test('User model instantiation', $userModel !== null);

    $user = $userModel->findByEmail('admin@blog.com');
    test('Find admin user by email', $user !== false);
    test('Admin user has correct role', isset($user['role']) && $user['role'] === 'admin');
    test('Admin username is correct', isset($user['username']) && $user['username'] === 'admin');
} catch (Exception $e) {
    test('User model tests', false);
}

// Test 3: Category Model
echo "\n--- Category Model Tests ---\n";
try {
    $categoryModel = new Category();
    test('Category model instantiation', $categoryModel !== null);

    $categories = $categoryModel->getAll();
    test('Get all categories', is_array($categories));
    test('Categories not empty', count($categories) > 0);
} catch (Exception $e) {
    test('Category model tests', false);
}

// Test 4: Post Model
echo "\n--- Post Model Tests ---\n";
try {
    $postModel = new Post();
    test('Post model instantiation', $postModel !== null);

    $posts = $postModel->getAll();
    test('Get all posts', is_array($posts));
} catch (Exception $e) {
    test('Post model tests', false);
}

// Test 5: Comment Model
echo "\n--- Comment Model Tests ---\n";
try {
    $commentModel = new Comment();
    test('Comment model instantiation', $commentModel !== null);
} catch (Exception $e) {
    test('Comment model tests', false);
}

// Test 6: Security Tests
echo "\n--- Security Tests ---\n";
$xssInput = '<script>alert("xss")</script>';
$sanitized = htmlspecialchars($xssInput);
test('XSS protection with htmlspecialchars', $sanitized !== $xssInput);
test('XSS script tag removed', strpos($sanitized, '<script>') === false);

$password = 'testpassword123';
$hash = password_hash($password, PASSWORD_BCRYPT);
test('Password hashing works', $hash !== $password);
test('Password verification works', password_verify($password, $hash));

// Test 7: Controller
echo "\n--- Controller Tests ---\n";
session_start();
try {
    $controller = new Controller();
    test('Controller instantiation', $controller !== null);

    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'admin';
    test('isLoggedIn() returns true when logged in', $controller->isLoggedIn());
    test('isAdmin() returns true for admin role', $controller->isAdmin());

    unset($_SESSION['user_id']);
    test('isLoggedIn() returns false when not logged in', !$controller->isLoggedIn());
} catch (Exception $e) {
    test('Controller tests', false);
}

// Summary
echo "\n========================================\n";
echo "   Results: $passed passed, $failed failed\n";
echo "========================================\n";