<?php
$attachments = wccp_get_attachments($post_id);
if (empty($attachments)) {
    return;
}
?>

<section class="wccp-attachments">
    <ul>
        <?php foreach ($attachments as $att): ?>
            <?php 
                $download_url = add_query_arg(
                    'wccp_download',
                    basename($att->file_path),
                    home_url('/')
                );    
            ?>
            <li>
                <a href="<?php echo esc_url($download_url); ?>" target="_blank">
                    <?php echo esc_html($att->original_name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>