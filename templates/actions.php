<?php if (!isset($post_id)) return; ?>

<div class="wccp-actions">

    <?php wccp_load_template('action-update', ['post_id' => $post_id ]); ?>
    <?php wccp_load_template('action-delete', ['post_id' => $post_id ]); ?>

</div>