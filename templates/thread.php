<?php 
    $meta = wccp_get_entry_meta($thread); 
?>

<article class="wccp-thread wccp-thread-<?php echo esc_attr($thread->id); ?> wccp-level-1 wccp-entry">
    <header>
        <h2>
            <?php echo esc_html($thread->title); ?>
            <svg class="icon" width="16" height="16" aria-hidden="true">
                <use href="#arrow-down-s-line"></use>
            </svg>
        </h2>

        <small class="wccp-meta">
            Posted by <?php echo esc_html($meta['display_name']); ?>
            on
            <time datetime="<?php echo esc_attr($meta['datetime']); ?>">
                <?php echo esc_html($meta['date']); ?>
            </time>
        </small>
    </header>

    <div class="wccp-content">
        <p><?php echo esc_html($thread->content); ?></p>
        
        <?php wccp_load_template('attachments', ['post_id' => $thread->id]); ?>
        
        <?php wccp_load_template('actions', ['post' => $thread]); ?>
        
    </div>


    <?php
    // Render replies recursively
    wccp_render_replies($thread);
    ?>


    <?php
    // Only allow replies to level 1 topics
    wccp_load_template('form-reply', [
        'parent_id' => $thread->id,
        'parent_level' => $thread->level
    ]);
    ?>
</article>
