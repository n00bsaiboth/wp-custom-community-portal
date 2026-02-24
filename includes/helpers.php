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

    if (empty($children)) {
        return;
    }

    wccp_load_template('replies', [
        'replies'   => $children,
        'max_level' => $max_level
    ]);

    // foreach ($children as $child) {
    //    wccp_load_template('reply', [
    //        'reply' => $child
    //    ]);

        // Recursive call
        // wccp_render_replies($child, $max_level);
    // }
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

    $validation_result = wccp_validate_file($_FILES[$file_field]);

    if (is_wp_error($validation_result)) {
        return $validation_result;
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
        return new WP_Error('upload_failed', 'File upload failed.');
    }
}

/**
 * Validate uploaded file.
 *
 */
function wccp_validate_file($file) {
    // Max file size: 5 MB
    $max_file_size = 5 * 1024 * 1024;
    if ($file['size'] > $max_file_size) {
        return new WP_Error('file_too_large', 'File is too large. Maximum size is 5MB.');
    }

    // Validate MIME type using finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if ($mime_type !== 'application/pdf') {
        return new WP_Error('invalid_file_type', 'Invalid file type. Only PDF files are allowed.');
    }

    return true;
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
    $required_role = get_option('wccp_required_role', 'community');
    return is_user_logged_in() && wccp_user_has_role($required_role);}

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

function wccp_get_entry_meta($entry) {

    $user = get_userdata($entry->user_id);

    $display_name = $user ? $user->display_name : __('Unknown', 'wccp');

    $formatted_date = '';
    $datetime_attr  = '';

    if (!empty($entry->created_at)) {

        $timestamp = strtotime($entry->created_at);

        // Human readable (localized)
        $formatted_date = date_i18n(
            get_option('date_format') . ' ' . get_option('time_format'),
            $timestamp
        );

        // Machine readable (ISO 8601)
        $datetime_attr = date('c', $timestamp); 
        // Example: 2026-02-13T00:56:00+02:00
    }

    return [
        'display_name' => $display_name,
        'date'         => $formatted_date,
        'datetime'     => $datetime_attr,
        'time_ago'     => !empty($entry->created_at)
            ? human_time_diff($timestamp, current_time('timestamp')) . ' ' . __('ago')
            : ''
    ];
}

