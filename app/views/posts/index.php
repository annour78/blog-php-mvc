<div class="home-header">
    <h1>Welcome to MyBlog</h1>
    <p>Discover our latest articles</p>
</div>

<div class="blog-layout">
    <div class="posts-grid">
        <?php if (empty($posts)): ?>
            <p class="no-posts">No posts available yet.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <?php if ($post['image']): ?>
                        <img src="/blog/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                             alt="<?= htmlspecialchars($post['title']) ?>" class="post-image">
                    <?php else: ?>
                        <div class="post-image-placeholder">📝</div>
                    <?php endif; ?>
                    <div class="post-card-body">
                        <span class="category-badge"><?= htmlspecialchars($post['category_name']) ?></span>
                        <h2><a href="/blog/public/post/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a></h2>
                        <p class="post-excerpt">
                            <?= htmlspecialchars(substr($post['content'], 0, 150)) ?>...
                        </p>
                        <div class="post-meta">
                            <span>✍️ <?= htmlspecialchars($post['username']) ?></span>
                            <span>📅 <?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                        </div>
                        <a href="/blog/public/post/<?= htmlspecialchars($post['slug']) ?>" 
                           class="btn btn-primary">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="sidebar">
        <div class="sidebar-widget">
            <h3>Categories</h3>
            <ul class="category-list">
                <?php foreach ($categories as $category): ?>
                    <li><a href="#"><?= htmlspecialchars($category['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>