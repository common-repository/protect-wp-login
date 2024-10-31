<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Define the path to the uploads directory
$upload_dir = wp_upload_dir()['basedir'] . '/protect-wp-login';

// Use the WP_Filesystem API to remove the directory and files
if ( ! function_exists( 'WP_Filesystem' ) ) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
}

global $wp_filesystem;
WP_Filesystem();

// Check if the directory exists, then delete the directory and its contents
if ( $wp_filesystem->is_dir( $upload_dir ) ) {
    // Remove all contents within the directory
    $wp_filesystem->delete( $upload_dir, true ); // 'true' removes the directory recursively
}
