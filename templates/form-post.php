<?php if (!is_user_logged_in()): ?>
    <p>You must be logged in to post.</p>
    <?php return; ?>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('wccp_create_post', 'wccp_post_nonce'); ?>

    <p>
        <input type="text" name="wccp_title" placeholder="Title" required>
    </p>

    <p>
        <textarea name="wccp_content" placeholder="Your message" required></textarea>
    </p>

    <p>
        <input type="file" name="wccp_attachment">
    </p>

    <p>
        <button type="submit" name="wccp_submit_post">Post</button>
    </p>
</form>