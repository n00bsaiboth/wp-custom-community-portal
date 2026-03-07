<?php if (!isset($post)) return; ?>

<div class="wccp-actions">

    <?php wccp_load_template('action-update', ['post' => $post ]); ?>
    <?php wccp_load_template('action-delete', ['post' => $post ]); ?>

</div>