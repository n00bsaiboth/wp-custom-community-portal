<?php

if (!defined('ABSPATH')) exit;

function wccp_get_threads() {
    global $wpdb;

    return $wpdb->get_results(
        "SELECT * FROM " . wccp_table() . " WHERE level = 1 ORDER BY created_at DESC"
    );
}

function wccp_get_replies($parent_id) {
    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM " . wccp_table() . " WHERE parent_id = %d ORDER BY created_at ASC",
            $parent_id
        )
    );
}

function wccp_get_children($parent_id) {
    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM " . wccp_table() . " WHERE parent_id = %d ORDER BY created_at ASC",
            $parent_id
        )
    );
}

function wccp_insert_post($data) {
    global $wpdb;

    $wpdb->insert(
        wccp_table(),
        $data
    );

    return $wpdb->insert_id;
}

function wccp_insert_attachment($post_id, $attachment) {
    global $wpdb;

    $wpdb->insert(
        wccp_attachments_table(),
        [
            'post_id'       => $post_id,
            'file_path'     => $attachment['file_path'],
            'original_name' => $attachment['original_name']
        ]
    );
}

function wccp_get_attachments($post_id) {
    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM " . wccp_attachments_table() . " WHERE post_id = %d",
            $post_id
        )
    );
}