<?php

if (!defined('ABSPATH')) exit;

function wccp_table() {
    global $wpdb;
    return $wpdb->prefix . 'wccp_events';
}

function wccp_attachments_table() {
    global $wpdb;
    return $wpdb->prefix . 'wccp_attachments';
}

function wccp_render_replies($parent, $max_level = 3) {

    if ($parent->level >= $max_level) {
        return;
    }

    $children = wccp_get_children($parent->id);

    foreach ($children as $child) {
        wccp_load_template('reply', [
            'reply' => $child
        ]);

        // Recursive call
        // wccp_render_replies($child, $max_level);
    }
}

function wccp_load_template($template, $vars = []) {

    $file = WCCP_PATH . 'templates/' . $template . '.php';

    if (!file_exists($file)) {
        return;
    }

    extract($vars);
    include $file;
}

function wccp_handle_attachment_upload($file_field) {
    // Check that file exists
    if ( empty($_FILES[$file_field]['name'])) {
        // wp_die('No file selected.');
        return false;
    }

    $upload_dir = WP_CONTENT_DIR . '/private';

    if (!file_exists($upload_dir)) {
        wp_mkdir_p($upload_dir);
    }

    $original_name = sanitize_file_name($_FILES[$file_field]['name']);
    $extension     = pathinfo($original_name, PATHINFO_EXTENSION);
    $random_name   = sha1( uniqid( bin2hex( random_bytes(8) ), true ) ) . '.' . strtolower($extension);
    $destination   = trailingslashit($upload_dir) . $random_name;

    if ( move_uploaded_file($_FILES[$file_field]['tmp_name'], $destination) ) { 
        return [
            'file_path'     => $destination,
            'original_name' => $original_name
        ];
    } else {
        wp_die('File upload failed.');
    }
}

function wccp_secure_download() {
    if (!isset($_GET['wccp_download'])) {
        return;
    }

    global $wpdb;

    $requested = sanitize_file_name($_GET['wccp_download']);

    $table = wccp_attachments_table();

    $file = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table WHERE file_path LIKE %s LIMIT 1",
            '%' . $wpdb->esc_like($requested)
        )
    );

    if (!$file) {
        wp_die('File not found.', '404 Not Found', ['response' => 404]);
    }

    $base_path = WP_CONTENT_DIR . '/private/';
    $absolute_path = realpath($base_path . basename($file->file_path));

        if (!$absolute_path || strpos($absolute_path, realpath($base_path)) !== 0) {
        wp_die('Invalid file path.', '403 Forbidden', ['response' => 403]);
    }

    if (!file_exists($absolute_path) || !is_file($absolute_path)) {
        wp_die('File missing.', '404 Not Found', ['response' => 404]);
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file->original_name) . '"');
    header('Content-Length: ' . filesize($absolute_path));

    readfile($absolute_path);
    exit;
}

add_action('init', 'wccp_secure_download');

/**
 * Check if user has required permissions.
 */
function wccp_user_has_permission() {
    return is_user_logged_in() && wccp_user_has_role('community');
}

/**
 * Check if a user has a specific role.
 */
function wccp_user_has_role( $role, $user_id = null ) {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }

    $user = get_userdata( $user_id );
    if ( ! $user || empty( $user->roles ) ) {
        return false;
    }

    return in_array( $role, (array) $user->roles, true );
}