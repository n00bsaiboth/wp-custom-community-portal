<?php

if (!defined('ABSPATH')) exit;

function wccp_portal_shortcode() {

    $threads = wccp_get_threads();

    ob_start();
    wccp_load_template('portal', [
        'threads' => $threads
    ]);
    return ob_get_clean();
}

add_shortcode('wccp_portal', 'wccp_portal_shortcode');

function wccp_form_shortcode() {

    ob_start();
    wccp_load_template('form-post');
    return ob_get_clean();
}

add_shortcode('wccp_form', 'wccp_form_shortcode');