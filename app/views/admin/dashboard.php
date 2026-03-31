<div class="admin-dashboard">
    <div class="admin-header">
        <h2>Admin Dashboard</h2>
        <a href="/blog/public/admin/post/create" class="btn btn-primary">+ New Post</a>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3><?= count($posts) ?></h3>
            <p>Total Posts</p>
        </div>
    </div>

    <div class="admin-table-container">
        <h3>All Posts</h3>
        <?php if (empty($posts)): ?>
            <p class="no-posts">No posts yet. Create your first post!</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $post['id'] ?></td>
                            <td>
                                <a href="/blog/public/post/<?= htmlspecialchars($post['slug']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($post['category_name']) ?></td>
                            <td><?= htmlspecialchars($post['username']) ?></td>
                            <td><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                            <td class="action-buttons">
                                <a href="/blog/public/admin/post/edit/<?= $post['id'] ?>" 
                                   class="btn btn-warning btn-sm">Edit</a>
                                <a href="/blog/public/admin/post/delete/<?= $post['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>