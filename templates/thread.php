<div class="wccp-thread wccp-level-1">

    <h3><?php echo esc_html($thread->title); ?></h3>
    <p><?php echo esc_html($thread->content); ?></p>

    <?php wccp_load_template('attachments', ['post_id' => $thread->id]); ?>

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

</div>
