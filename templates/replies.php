<?php if (empty($replies)) return; ?>

<section class="wccp-replies">

    <?php foreach ($replies as $reply): ?>

        <?php
        $children = wccp_get_children($reply->id);

        wccp_load_template('reply', [
            'reply'     => $reply,
            'children'  => $children,
            'max_level' => $max_level ?? 3
        ]);
        ?>

    <?php endforeach; ?>

</section>