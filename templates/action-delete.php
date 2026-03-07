<?php if (!isset($post_id)) return; ?>

<div class="wccp-action-delete">
    <form method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">

        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">

        <?php wp_nonce_field('wccp_delete_post', 'wccp_delete_nonce'); ?>

        <button type="submit" name="wccp_delete_post">
            Delete
        </button>

    </form>
</div>
