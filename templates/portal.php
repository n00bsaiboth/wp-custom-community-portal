<?php if ( !wccp_user_has_permission() ): ?>
    <p>You do not have permission to view the community portal.</p>
    <?php return; ?>
<?php endif; ?>

<?php if (empty($threads)): ?>
    <p>No threads yet.</p>
    <?php return; ?>
<?php endif; ?>

<section id="wccp-portal" class="wccp-portal">

    <?php wccp_load_template('notifications'); ?>
    
    <?php foreach ($threads as $thread): ?>

        <?php wccp_load_template('thread', ['thread' => $thread]); ?>

    <?php endforeach; ?>

</section>