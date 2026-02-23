<?php
/**
 * Plugin Name: WP Custom Community Portal
 * Description: A custom community portal for WordPress users.
 * Version: 0.0.1
 * Author: Jussi Jokinen
 * Author URI: https://openinnovations.io
 * License: MIT
 */

if (!defined('ABSPATH')) exit;

define('WCCP_PATH', plugin_dir_path(__FILE__));
define('WCCP_URL', plugin_dir_url(__FILE__));


require_once WCCP_PATH . 'includes/db.php';
require_once WCCP_PATH . 'includes/svg.php';
require_once WCCP_PATH . 'includes/helpers.php';
require_once WCCP_PATH . 'includes/handlers.php';
require_once WCCP_PATH . 'includes/shortcodes.php';
require_once WCCP_PATH . 'includes/admin.php';

/**
 * Enqueue plugin's necessary styles and scripts.
 */
function wccp_enqueue_assets() {
    wp_enqueue_style( 'wccp-styles', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
    wp_enqueue_script( 'wccp-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/script.js');
}
add_action( 'wp_enqueue_scripts', 'wccp_enqueue_assets' );



