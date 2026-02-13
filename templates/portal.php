<?php if (empty($threads)): ?>
    <p>No threads yet.</p>
    <?php return; ?>
<?php endif; ?>

<div class="wccp-portal">

    <?php foreach ($threads as $thread): ?>

        <?php wccp_load_template('thread', ['thread' => $thread]); ?>

    <?php endforeach; ?>

</div>