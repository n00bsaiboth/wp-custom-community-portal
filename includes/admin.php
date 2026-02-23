<?php
if (!defined('ABSPATH')) exit;

/**
 * Register admin menu
 */
function wccp_register_admin_menu() {
    add_menu_page(
        'Community Portal Settings',
        'Community Portal',
        'manage_options',
        'wccp-settings',
        'wccp_render_settings_page',
        'dashicons-groups',
        26
    );
}
add_action('admin_menu', 'wccp_register_admin_menu');


/**
 * Render settings page
 */
function wccp_render_settings_page() {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['wccp_save_settings'])) {
        check_admin_referer('wccp_settings_nonce');

        $role = sanitize_text_field($_POST['wccp_required_role']);
        update_option('wccp_required_role', $role);

        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $saved_role = get_option('wccp_required_role', 'community');
    $roles = wp_roles()->roles;
    ?>

    <div class="wrap">
        <h1>Community Portal Settings</h1>

        <form method="post">
            <?php wp_nonce_field('wccp_settings_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">Required Role</th>
                    <td>
                        <select name="wccp_required_role">
                            <?php foreach ($roles as $role_key => $role_data): ?>
                                <option value="<?php echo esc_attr($role_key); ?>"
                                    <?php selected($saved_role, $role_key); ?>>
                                    <?php echo esc_html($role_data['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">
                            Users must have this role to access the community.
                        </p>
                    </td>
                </tr>
            </table>

            <p>
                <input type="submit" name="wccp_save_settings" class="button-primary" value="Save Settings">
            </p>
        </form>
    </div>

    <?php
}