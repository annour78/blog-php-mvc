<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="/blog/public/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/blog/public/" class="logo">📝 MyBlog</a>
        <div class="nav-links">
            <a href="/blog/public/">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/blog/public/admin">Dashboard</a>
                <?php endif; ?>
                <a href="/blog/public/logout">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
            <?php else: ?>
                <a href="/blog/public/login">Login</a>
                <a href="/blog/public/register">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container main-content">s