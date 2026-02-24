

<?php if ( !wccp_user_has_permission() ): ?>
    <p>You do not have permission to post a new thread in the community portal.</p>
    <?php return; ?>
<?php endif; ?>

<section id="wccp-form-post" class="wccp-form-post">
    <div>
        <h4>Start a new thread</h4>
    </div>
    <div>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('wccp_create_post', 'wccp_post_nonce'); ?>

            <div class="form-group">
                <label for="wccp-post-title">Title</label>
                <input type="text" id="wccp-post-title" name="wccp_title" class="wccp-post-title" placeholder="Title" required>
            </div>

            <div class="form-group">
                <label for="wccp-post-content">Content</label>
                <textarea name="wccp_content" id="wccp-post-content"class="wccp-post-content" placeholder="Your message" required></textarea>
            </div>

            <div class="form-group">
                <label for="wccp-post-attachment">Attachment (PDF)</label>
                <input type="file" id="wccp-post-attachment" name="wccp_attachment" class="wccp-post-attachment" accept=".pdf, application/pdf">
            </div>

            <div class="wccp-notifications" style="display:none;"></div>            

            <?php if (!empty($GLOBALS['wccp_file_upload_notifications']['create_thread'])): ?>
                <div class="wccp-notifications">
                    <?php foreach ($GLOBALS['wccp_file_upload_notifications']['create_thread'] as $error): ?>
                        <p class="wccp-notification">
                            <?php echo esc_html($error); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="wccp-submit-post"></label>
                <button type="submit" name="wccp_submit_post" id="wccp-submit-post" class="wccp-submit-post">Post</button>
            </div>
        </form>
    </div>
</section>