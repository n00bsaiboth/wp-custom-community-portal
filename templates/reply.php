<div class="wccp-reply wccp-level-<?php echo (int) $reply->level; ?>">

    <h4><?php echo esc_html($reply->title); ?></h4>

    <p><?php echo esc_html($reply->content); ?></p>

    <?php wccp_load_template('attachments', ['post_id' => $reply->id]); ?>

    <?php
    // Render child replies INSIDE this reply div
    if ($reply->level < 3) {
        wccp_render_replies($reply, $max_level ?? 3);
    }
    ?>

    <?php
    // Show reply form only if we are below level 3
    if ($reply->level < 3) {
        wccp_load_template('form-reply', [
            'parent_id' => $reply->id,
            'parent_level' => $reply->level
        ]);
    }
    ?>

</div>