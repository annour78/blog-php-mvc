<div class="auth-container">
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/Blog/public/login" method="POST" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p>Don't have an account? <a href="/Blog/public/register">Register here</a></p>
    </form>
</div>