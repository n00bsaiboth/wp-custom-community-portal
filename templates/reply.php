<?php 
    $meta = wccp_get_entry_meta($reply); 
?>

<article class="wccp-reply wccp-reply-<?php echo esc_attr($reply->id); ?> wccp-level-<?php echo (int) $reply->level; ?> wccp-entry">
    <header>
        <h3><?php echo esc_html($reply->title); ?>
            <svg class="icon" width="16" height="16" aria-hidden="true">
                <use href="#arrow-down-s-line"></use>
            </svg>
        </h3>

        <small class="wccp-meta">
            Posted by <?php echo esc_html($meta['display_name']); ?>
            on
            <time datetime="<?php echo esc_attr($meta['datetime']); ?>">
            <?php echo esc_html($meta['date']); ?>
            </time>
        </small>
    </header>
    
    <div class="wccp-content">
        <p><?php echo esc_html($reply->content); ?></p>
        
        <?php wccp_load_template('attachments', ['post_id' => $reply->id]); ?>

        <?php wccp_load_template('actions', ['post_id' => $reply->id]); ?>        
    </div>

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

</article>
