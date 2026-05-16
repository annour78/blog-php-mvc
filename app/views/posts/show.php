<div class="post-single">
    <div class="post-header">
        <span class="category-badge"><?= htmlspecialchars($post['category_name']) ?></span>
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">
            <span>✍️ <?= htmlspecialchars($post['username']) ?></span>
            <span>📅 <?= date('M d, Y', strtotime($post['created_at'])) ?></span>
        </div>
    </div>

    <?php if ($post['image']): ?>
        <img src="/Blog/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
             alt="<?= htmlspecialchars($post['title']) ?>" class="post-single-image">
    <?php endif; ?>

    <div class="post-content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="post-actions">
            <a href="/Blog/public/admin/post/edit/<?= $post['id'] ?>" class="btn btn-warning">Edit</a>
            <a href="/Blog/public/admin/post/delete/<?= $post['id'] ?>" 
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
        </div>
    <?php endif; ?>
</div>

<div class="comments-section">
    <h3>Comments (<?= count($comments) ?>)</h3>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="/Blog/public/index.php?url=comment/add/<?= $post['id'] ?>" method="POST" class="comment-form">
            <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
            <div class="form-group">
                <textarea name="content" placeholder="Write your comment..." required rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    <?php else: ?>
        <p class="login-prompt">
            <a href="/Blog/public/login">Login</a> to leave a comment.
        </p>
    <?php endif; ?>

    <div class="comments-list">
        <?php if (empty($comments)): ?>
            <p class="no-comments">No comments yet. Be the first!</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-card">
                    <div class="comment-header">
                        <strong>👤 <?= htmlspecialchars($comment['username']) ?></strong>
                        <span>📅 <?= date('M d, Y', strtotime($comment['created_at'])) ?></span>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' 
                            || isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                            <a href="/Blog/public/comment/delete/<?= $comment['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this comment?')">Delete</a>
                        <?php endif; ?>
                    </div>
                    <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>