<?php

function wccp_handle_create_post() {

    if (!isset($_POST['wccp_submit_post'])) {
        return;
    }

    if (
        !isset($_POST['wccp_post_nonce']) ||
        !wp_verify_nonce($_POST['wccp_post_nonce'], 'wccp_create_post')
    ) {
        return;
    }

    if (!is_user_logged_in()) {
        return;
    }

    $post_id = wccp_insert_post([
        'user_id' => get_current_user_id(),
        'title'   => sanitize_text_field($_POST['wccp_title']),
        'content' => sanitize_textarea_field($_POST['wccp_content']),
        'level'   => 1
    ]);


    $attachment = wccp_handle_attachment_upload('wccp_attachment');

    if ($attachment) {
        wccp_insert_attachment($post_id, $attachment);
    }
    
    $redirect_url = wccp_get_safe_redirect_url();
    wp_safe_redirect(add_query_arg('posted', '1', $redirect_url));

    exit;
}

add_action('init', 'wccp_handle_create_post');

function wccp_handle_reply() {

    if (!isset($_POST['wccp_submit_reply'])){
        return;
    }

    if (
        !isset($_POST['wccp_reply_nonce']) ||
        !wp_verify_nonce($_POST['wccp_reply_nonce'], 'wccp_create_reply')
    ) {
        return;
    }

    if (!is_user_logged_in()) {
        return;
    }

    $parent_level = (int) $_POST['wccp_parent_level'];
    $new_level    = $parent_level + 1;

    // Enforce max depth
    if ($new_level > 3) {
        return;
    }

    $post_id = wccp_insert_post([
        'user_id'   => get_current_user_id(),
        'parent_id' => (int) $_POST['wccp_parent_id'],
        'content'   => sanitize_textarea_field($_POST['wccp_content']),
        'level'     => $new_level
    ]);

    $attachment = wccp_handle_attachment_upload('wccp_attachment');

    if ($attachment) {
        wccp_insert_attachment($post_id, $attachment);
    }

    $redirect_url = wccp_get_safe_redirect_url();
    wp_safe_redirect(add_query_arg('replied', '1', $redirect_url));

    exit;
}

add_action('init', 'wccp_handle_reply');

function wccp_get_safe_redirect_url() {

    $redirect_url = wp_get_referer();

    if (!$redirect_url) {
        $redirect_url = remove_query_arg(['posted', 'replied', 'wccp_error']);
    }

    if (!$redirect_url) {
        $redirect_url = home_url('/');
    }

    return $redirect_url;
}
