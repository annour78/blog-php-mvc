<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

$router = new Router();

// Public routes
$router->add('GET', '/', 'PostController', 'index');
$router->add('GET', '/post/{slug}', 'PostController', 'show');

// Auth routes
$router->add('GET', '/login', 'AuthController', 'loginForm');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('GET', '/register', 'AuthController', 'registerForm');
$router->add('POST', '/register', 'AuthController', 'register');
$router->add('GET', '/logout', 'AuthController', 'logout');

// Admin routes
$router->add('GET', '/admin', 'PostController', 'adminIndex');
$router->add('GET', '/admin/post/create', 'PostController', 'createForm');
$router->add('POST', '/admin/post/create', 'PostController', 'create');
$router->add('GET', '/admin/post/edit/{id}', 'PostController', 'editForm');
$router->add('POST', '/admin/post/edit/{id}', 'PostController', 'edit');
$router->add('GET', '/admin/post/delete/{id}', 'PostController', 'delete');

// Comment routes
$router->add('POST', '/comment/add/{post_id}', 'CommentController', 'add');
$router->add('GET', '/comment/delete/{id}', 'CommentController', 'delete');

// Get URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/Blog/public/index.php', '', $url);
$url = str_replace('/blog/public/index.php', '', $url);
$url = str_replace('/Blog/public', '', $url);
$url = str_replace('/blog/public', '', $url);

// Check query string for url parameter
if (isset($_GET['url'])) {
    $url = '/' . trim($_GET['url'], '/');
}

$url = $url === '' ? '/' : $url;

$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $url);