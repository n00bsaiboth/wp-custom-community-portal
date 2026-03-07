<?php
    $messages = wccp_get_global_notifications();

    if (empty($messages)) {
        return;
    }
?>

<div class="wccp-global-notifications is-visible">

    <?php foreach ($messages as $message): ?>
        <p class="wccp-notification">
            <?php echo esc_html($message); ?>
        </p>
    <?php endforeach; ?>

</div>