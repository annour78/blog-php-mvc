<div class="admin-form-container">
    <h2>Edit Post</h2>

    <form action="/blog/public/admin/post/edit/<?= $post['id'] ?>" method="POST" 
          enctype="multipart/form-data" class="admin-form">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required 
                   value="<?= htmlspecialchars($post['title']) ?>">
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" 
                        <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" required rows="10"><?= htmlspecialchars($post['content']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image (optional)</label>
            <?php if ($post['image']): ?>
                <img src="/blog/public/uploads/<?= htmlspecialchars($post['image']) ?>" 
                     alt="Current image" style="max-width: 200px; display: block; margin-bottom: 10px;">
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="/blog/public/admin" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>