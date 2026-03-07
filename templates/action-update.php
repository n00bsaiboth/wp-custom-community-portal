<?php if (!isset($post)) return; ?>

<div class="wccp-action-update" data-wccp-edit-container>
    <button
        type="button"
        class="wccp-edit-toggle"
        data-wccp-edit-toggle
        data-post-id="<?php echo esc_attr($post->id); ?>"
        aria-expanded="false"
        aria-controls="wccp-edit-form-<?php echo esc_attr($post->id); ?>"
    >
        Update
    </button>
    <form 
        id="wccp-edit-form-<?php echo esc_attr($post->id); ?>"
        class="wccp-edit-form"
        data-wccp-edit-form
        method="post"
        hidden
    >
        <?php wp_nonce_field('wccp_update_post', 'wccp_update_nonce'); ?>

        <input type="hidden" name="post_id" value="<?php echo esc_attr($post->id); ?>">

        
        <div class="form-group">
            <label for="wccp-edit-title-<?php echo esc_attr($post->id); ?>">Title</label>
            <input
                type="text"
                id="wccp-edit-title-<?php echo esc_attr($post->id); ?>"
                name="wccp_title"
                value="<?php echo esc_attr($post->title); ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="wccp-edit-content-<?php echo esc_attr($post->id); ?>">Content</label>
            <textarea
                id="wccp-edit-content-<?php echo esc_attr($post->id); ?>"
                name="wccp_content"
                required
            ><?php echo esc_textarea($post->content); ?></textarea>
        </div>

        <button type="submit" name="wccp_update_post">Save</button>

    </form>
</div>
