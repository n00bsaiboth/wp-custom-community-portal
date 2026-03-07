<?php

if (!defined('ABSPATH')) exit;

function wccp_handle_create_post() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    if (!is_user_logged_in()) {
        return;
    }

    if (!isset($_POST['wccp_submit_post'])) {
        return;
    }

    if (
        !isset($_POST['wccp_post_nonce']) ||
        !wp_verify_nonce($_POST['wccp_post_nonce'], 'wccp_create_post')
    ) {
        return;
    }

    $errors = [];
    $attachment = null;

    if (!empty($_FILES['wccp_attachment']['name'])) {

        $attachment = wccp_handle_attachment_upload('wccp_attachment');

        if (is_wp_error($attachment)) {
            $errors[] = $attachment->get_error_message();
        }
    }
    
    if (!empty($errors)) {
    
        foreach ($errors as $error) {
            wccp_add_notification('create_thread', $error);
        }

        wccp_add_notification('global', 'Something went wrong while creating a new thread.');

        return;
    }    

    $post_id = wccp_insert_post([
        'user_id' => get_current_user_id(),
        'title'   => sanitize_text_field($_POST['wccp_title']),
        'content' => sanitize_textarea_field($_POST['wccp_content']),
        'level'   => 1
    ]);

    if ($attachment) {
        wccp_insert_attachment($post_id, $attachment);
    }

    wccp_add_notification('global', 'Thread posted successfully.');

    wccp_redirect();
}

add_action('init', 'wccp_handle_create_post');

function wccp_handle_create_reply() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    if (!is_user_logged_in()) {
        return;
    }

    if (!isset($_POST['wccp_submit_reply'])){
        return;
    }

    if (
        !isset($_POST['wccp_reply_nonce']) ||
        !wp_verify_nonce($_POST['wccp_reply_nonce'], 'wccp_create_reply')
    ) {
        return;
    }

    $parent_level = (int) $_POST['wccp_parent_level'];
    $new_level    = $parent_level + 1;

    // Enforce max depth
    if ($new_level > 3) {
        return;
    }

    $errors = [];
    $attachment = null;

    if (!empty($_FILES['wccp_attachment']['name'])) {

        $attachment = wccp_handle_attachment_upload('wccp_attachment');

        if (is_wp_error($attachment)) {
            $errors[] = $attachment->get_error_message();
        }
    }

    if (!empty($errors)) {
        $form_key = 'reply_' . (int) $_POST['wccp_parent_id'];
        
        foreach ($errors as $error) {
            wccp_add_notification($form_key, $error);
        }

        wccp_add_notification('global', 'Something went wrong while creating a reply.');
        
        return;
    }

    $post_id = wccp_insert_post([
        'user_id'   => get_current_user_id(),
        'parent_id' => (int) $_POST['wccp_parent_id'],
        'title'   => sanitize_textarea_field($_POST['wccp_title']),
        'content'   => sanitize_textarea_field($_POST['wccp_content']),
        'level'     => $new_level
    ]);

    if ($attachment) {
        wccp_insert_attachment($post_id, $attachment);
    }

    wccp_add_notification('global', 'Reply posted successfully.');

    wccp_redirect();
}

add_action('init', 'wccp_handle_create_reply');

function wccp_handle_delete_post() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    if (!is_user_logged_in()) {
        return;
    }

    if (!isset($_POST['wccp_delete_post'])) {
        return;
    }

    if (
        !isset($_POST['wccp_delete_nonce']) ||
        !wp_verify_nonce($_POST['wccp_delete_nonce'], 'wccp_delete_post')
    ) {
        return;
    }

    $post_id = (int) $_POST['post_id'];

    if (wccp_post_has_children($post_id)) {

        wccp_add_notification('global', 'Cannot delete post because it has replies.');

        wccp_redirect();
    }

    // delete files
    wccp_delete_attachment_files($post_id);

    // delete DB row
    wccp_delete_post($post_id);

    wccp_add_notification('global', 'Post deleted successfully.');

    wccp_redirect();
}

add_action('init', 'wccp_handle_delete_post');


