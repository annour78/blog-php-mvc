<div class="admin-form-container">
    <h2>Create New Post</h2>

    <form action="/blog/public/admin/post/create" method="POST" 
          enctype="multipart/form-data" class="admin-form">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required placeholder="Enter post title">
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" required rows="10" 
                      placeholder="Write your post content..."></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image (optional)</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Publish Post</button>
            <a href="/blog/public/admin" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>