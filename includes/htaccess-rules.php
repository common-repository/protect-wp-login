<?php
// htaccess-rules.php

function protect_wp_login_add_htaccess_rules() {
    global $wp_filesystem;

    $htaccess_file = ABSPATH . '.htaccess';
    $rules = "#BEGIN --- Protect WP Login ---\n" .
    "ErrorDocument 401 \"Unauthorized Access\"\n" .
    "ErrorDocument 403 \"Forbidden\"\n" .
    "<FilesMatch \"wp-login.php\">\n" .
    "AuthName \"Authorized Only\"\n" .
    "AuthType Basic\n" .
    "AuthUserFile " . PROTECT_WP_LOGIN_PASSWD_FILE . "\n" .
    "Require valid-user\n" .
    "</FilesMatch>\n" .
    "#END --- Protect WP Login ---\n";

    if ( ! function_exists( 'request_filesystem_credentials' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    request_filesystem_credentials( '', '', false, false, null );

    if ( ! $wp_filesystem ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    if ( $wp_filesystem->exists( $htaccess_file ) && $wp_filesystem->is_writable( $htaccess_file ) ) {
        $existing_rules = $wp_filesystem->get_contents( $htaccess_file );
        $new_rules = $existing_rules . "\n" . $rules;
        $wp_filesystem->put_contents( $htaccess_file, $new_rules, FS_CHMOD_FILE );
    }
}

function protect_wp_login_remove_htaccess_rules() {
    global $wp_filesystem;

    $htaccess_file = ABSPATH . '.htaccess';
    $rules = "#BEGIN --- Protect WP Login ---\n" .
    "ErrorDocument 401 \"Unauthorized Access\"\n" .
    "ErrorDocument 403 \"Forbidden\"\n" .
    "<FilesMatch \"wp-login.php\">\n" .
    "AuthName \"Authorized Only\"\n" .
    "AuthType Basic\n" .
    "AuthUserFile " . PROTECT_WP_LOGIN_PASSWD_FILE . "\n" .
    "Require valid-user\n" .
    "</FilesMatch>\n" .
    "#END --- Protect WP Login ---\n";

    if ( ! function_exists( 'request_filesystem_credentials' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    request_filesystem_credentials( '', '', false, false, null );

    if ( ! $wp_filesystem ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    if ( $wp_filesystem->exists( $htaccess_file ) && $wp_filesystem->is_writable( $htaccess_file ) ) {
        $existing_rules = $wp_filesystem->get_contents( $htaccess_file );
        $new_rules = str_replace( $rules, '', $existing_rules );
        $wp_filesystem->put_contents( $htaccess_file, $new_rules, FS_CHMOD_FILE );
    }
}

