<?php 

/**
 * This will be needed to print out the the arrows on the headlines
 */
add_action('wp_footer', function () {
    echo file_get_contents(WCCP_PATH . 'assets/images/sprite.svg');
});