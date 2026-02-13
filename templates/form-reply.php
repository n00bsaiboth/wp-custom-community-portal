<?php if (!is_user_logged_in()) return; ?>

<div class="wccp-reply-form">
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('wccp_create_reply', 'wccp_reply_nonce'); ?>

        <input type="hidden" name="wccp_parent_id" value="<?php echo (int) $parent_id; ?>">
        <input type="hidden" name="wccp_parent_level" value="<?php echo (int) $parent_level; ?>">

        <div class="">
            <label for="wccp_content">reply</label>
            <textarea id="wccp_content" name="wccp_content" placeholder="Reply..." required></textarea>
        </div>

        <p>
            <input type="file" name="wccp_attachment">
        </p>

        <p>
            <button type="submit" name="wccp_submit_reply">Reply</button>
        </p>
    </form>
</div>
