<?php if (!is_user_logged_in()) return; ?>

<?php $form_key = 'reply_' . (int) $parent_id; ?>

<section id="wccp-form-reply-<?php echo (int) $parent_id; ?>" class="wccp-form-reply">
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('wccp_create_reply', 'wccp_reply_nonce'); ?>

        <input type="hidden" name="wccp_parent_id" value="<?php echo (int) $parent_id; ?>">
        <input type="hidden" name="wccp_parent_level" value="<?php echo (int) $parent_level; ?>">

        <div class="form-group">
            <label for="wccp-reply-title-<?php echo (int) $parent_id; ?>">Title:</label>
            <input type="text" id="wccp-reply-title-<?php echo (int) $parent_id; ?>" name="wccp_title" class="wccp-reply-title" placeholder="Reply title..." required>
        </div>

        <div class="form-group">
            <label for="wccp-reply-content-<?php echo (int) $parent_id; ?>">Reply:</label>
            <textarea id="wccp-reply-content-<?php echo (int) $parent_id; ?>" name="wccp_content" class="wccp-reply" placeholder="Reply..." required></textarea>
        </div>

        <div class="form-group">
            <label for="wccp-reply-attachment-<?php echo (int) $parent_id; ?>">Attachment</label>
            <input type="file" id="wccp-reply-attachment-<?php echo (int) $parent_id; ?>" name="wccp_attachment" class="wccp-attachment" accept=".pdf, application/pdf">
        </div>

        <div class="wccp-notifications" style="display:none;"></div>

        <?php if (!empty($GLOBALS['wccp_file_upload_notifications'][$form_key])): ?>
            <div class="wccp-notifications">
                <?php foreach ($GLOBALS['wccp_file_upload_notifications'][$form_key] as $error): ?>
                    <p class="wccp-notification">
                        <?php echo esc_html($error); ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="wccp-submit-reply-<?php echo (int) $parent_id; ?>"></label>
            <button type="submit" name="wccp_submit_reply" class="wccp-submit-reply">Reply</button>
        </div>
    </form>
</section>
