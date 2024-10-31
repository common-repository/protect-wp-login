<?php
/**
 * Plugin Name: Protect WP Login
 * Plugin URI:  https://click.ar/plugin-protect-wp-login.php
 * Description: Protects wp-login.php with additional authentication.
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Version: 1.0
 * Author: Click.ar
 * Author URI: https://Click.ar
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: protect-wp-login
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Defines the uploads path to save the file
define( 'PROTECT_WP_LOGIN_UPLOAD_DIR', wp_upload_dir()['basedir'] . '/protect-wp-login' );
define( 'PROTECT_WP_LOGIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Usa WP_Filesystem en lugar de mkdir()
if ( ! function_exists( 'WP_Filesystem' ) ) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
}

global $wp_filesystem;
WP_Filesystem();

if ( ! wp_mkdir_p( PROTECT_WP_LOGIN_UPLOAD_DIR ) ) {
    error_log( 'Error al crear el directorio: ' . PROTECT_WP_LOGIN_UPLOAD_DIR );
}

define( 'PROTECT_WP_LOGIN_PASSWD_FILE', PROTECT_WP_LOGIN_UPLOAD_DIR . '/.htpasswd' );

include_once PROTECT_WP_LOGIN_PLUGIN_DIR . 'includes/htaccess-rules.php';
include_once PROTECT_WP_LOGIN_PLUGIN_DIR . 'admin/admin-page.php';

//register_activation_hook( __FILE__, 'protect_wp_login_activate' );
register_deactivation_hook( __FILE__, 'protect_wp_login_deactivate' );

function protect_wp_login_activate() {
    global $wp_filesystem;
    if ( ! function_exists( 'request_filesystem_credentials' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    request_filesystem_credentials( '', '', false, false, null );

    if ( ! $wp_filesystem ) {
        WP_Filesystem();
    }

    protect_wp_login_add_htaccess_rules();

 if ( ! $wp_filesystem->exists( PROTECT_WP_LOGIN_PASSWD_FILE ) ) {
        //$default_username = 'admin'; // Keep the username as 'admin' or any other you want
        $random_suffix = wp_generate_password( 5, false, false );
        $default_username = 'admin' . $random_suffix;

        $random_password = wp_generate_password( 10, false, false ); // Generate random password with 10 characters (letters and numbers)
        
        $hashed_password = password_hash( $random_password, PASSWORD_BCRYPT ); // Hash the random password
        $default_entry = "$default_username:$hashed_password\n"; // Add the username and hashed password to .htpasswd
        
        $wp_filesystem->put_contents( PROTECT_WP_LOGIN_PASSWD_FILE, $default_entry, FS_CHMOD_FILE );

        // Store the credentials in a transient to display after activation
        set_transient( 'protect_wp_login_credentials', array( 'username' => $default_username, 'password' => $random_password ), 60 );
    }

    // Redirect to admin page after activation
    add_action( 'admin_init', 'protect_wp_login_redirect_after_activation' );
}

function protect_wp_login_redirect_after_activation() {
    if ( get_option( 'protect_wp_login_redirect', true ) ) {
        delete_option( 'protect_wp_login_redirect' );
        wp_redirect( admin_url( 'admin.php?page=protect-wp-login' ) );
        exit;
    }
}

register_activation_hook( __FILE__, 'protect_wp_login_activate' );


function protect_wp_login_deactivate() {
    protect_wp_login_remove_htaccess_rules();
}

add_action( 'admin_menu', 'protect_wp_login_add_admin_menu' );
function protect_wp_login_add_admin_menu() {
    $icon_url = plugin_dir_url( __FILE__ ) . 'assets/images/protect_wp_login.png';
    add_menu_page(
        __( 'Protect WP Login', 'protect-wp-login' ),
        __( 'Protect WP Login', 'protect-wp-login' ),
        'manage_options',
        'protect-wp-login',
        'protect_wp_login_admin_page',
        $icon_url,
        20
    );
}

function protect_wp_login_load_textdomain() {
    load_plugin_textdomain( 'protect-wp-login', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'protect_wp_login_load_textdomain' );


register_uninstall_hook( __FILE__, 'protect_wp_login_uninstall' );

?>
