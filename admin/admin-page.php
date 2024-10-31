<?php
// admin-page.php

function protect_wp_login_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wp_filesystem;

    if ( ! function_exists( 'request_filesystem_credentials' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    
    if ( ! WP_Filesystem() ) {
        request_filesystem_credentials( '', '', false, false, null );
        if ( ! WP_Filesystem() ) {
            echo '<div class="error"><p>' . esc_html__( 'Unable to initialize the file system. Please check your permissions.', 'protect-wp-login' ) . '</p></div>';
            return;
        }
    }

// Check for the transient with generated credentials
$credentials = get_transient( 'protect_wp_login_credentials' );
if ( $credentials ) {
    // Show the generated username and password with enhanced design
    echo '<div class="updated" style="padding: 20px; background-color: #f1f1f1; border-left: 4px solid #0073aa; margin-bottom: 20px;">';
    echo '<h1 style="margin: 0 0 10px;">' . esc_html__( 'Login Credentials Generated', 'protect-wp-login' ) . '</h1>';
    
    echo '<p><strong>' . esc_html__( 'Username:', 'protect-wp-login' ) . '</strong> ' . esc_html( $credentials['username'] ) . '</p>';
    echo '<p><strong>' . esc_html__( 'Password:', 'protect-wp-login' ) . '</strong> ' . esc_html( $credentials['password'] ) . '</p>';
    
    // Add a legend/warning
    echo '<p style="color: #d63638;"><strong>' . esc_html__( 'Important:', 'protect-wp-login' ) . '</strong> <strong>' . esc_html__( 'Please note these credentials now. Once this message disappears, you won’t be able to view them again.', 'protect-wp-login' ) . '</strong></p>';
    
    echo '<p><strong>' . esc_html__( 'You can create your own usernames and passwords.', 'protect-wp-login' ) . '</strong></p>';
    echo '</div>';

    // Delete the transient so it doesn't show up again
    delete_transient( 'protect_wp_login_credentials' );
}

    $error_message = '';

    if ( isset( $_POST['protect_wp_login_delete_user'] ) ) {
    check_admin_referer( 'protect_wp_login_delete_user_nonce' );

    if ( isset( $_POST['protect_wp_login_delete_username'] ) ) {
        $delete_username = sanitize_text_field( wp_unslash( $_POST['protect_wp_login_delete_username'] ) );


        if ( ! empty( $delete_username ) ) {
            $passwd_content = $wp_filesystem->get_contents( PROTECT_WP_LOGIN_PASSWD_FILE );

            $pattern = '/^' . preg_quote( $delete_username, '/' ) . ':.*$/m';
            $passwd_content = preg_replace( $pattern, '', $passwd_content );

            $remaining_users = array_filter( explode( "\n", trim( $passwd_content ) ) );

            if ( count( $remaining_users ) > 0 ) {
                if ( $wp_filesystem->put_contents( PROTECT_WP_LOGIN_PASSWD_FILE, implode( "\n", $remaining_users ) . "\n", FS_CHMOD_FILE ) ) {
                    echo '<div class="updated"><p>' . esc_html__( 'User successfully deleted.', 'protect-wp-login' ) . '</p></div>';
                } else {
                    echo '<div class="error"><p>' . esc_html__( 'Error deleting user.', 'protect-wp-login' ) . '</p></div>';
                }
            } else {
                echo '<div class="error"><p>' . esc_html__( 'Cannot delete the last user. There must be at least one user.', 'protect-wp-login' ) . '</p></div>';
            }
        } else {
            echo '<div class="error"><p>' . esc_html__( 'Please select a user to delete.', 'protect-wp-login' ) . '</p></div>';
        }
    }
}

    if ( isset( $_POST['protect_wp_login_save_passwd'] ) ) {
    check_admin_referer( 'protect_wp_login_passwd_nonce' );

    if ( isset( $_POST['protect_wp_login_username'] ) && isset( $_POST['protect_wp_login_password'] ) ) {
        $username = sanitize_text_field( wp_unslash( $_POST['protect_wp_login_username'] ) );
        $password = sanitize_text_field( wp_unslash( $_POST['protect_wp_login_password'] ) );


        if ( ! empty( $username ) && ! empty( $password ) ) {
            $passwd_content = $wp_filesystem->get_contents( PROTECT_WP_LOGIN_PASSWD_FILE );

            $existing_users = array();
            $lines = explode( "\n", $passwd_content );
            foreach ( $lines as $line ) {
                if ( ! empty( trim( $line ) ) ) {
                    list( $user, $pass ) = explode( ':', $line, 2 );
                    $existing_users[] = $user;
                }
            }

            if ( in_array( $username, $existing_users ) ) {
                $error_message = esc_html__( 'This username already exists, please choose another one.', 'protect-wp-login' );
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $entry = "$username:$hashed_password\n";

                if ( ! empty( $passwd_content ) ) {
                    $passwd_content .= $entry;
                } else {
                    $passwd_content = $entry;
                }

                if ( $wp_filesystem->is_writable( PROTECT_WP_LOGIN_PASSWD_FILE ) ) {
                    if ( $wp_filesystem->put_contents( PROTECT_WP_LOGIN_PASSWD_FILE, $passwd_content, FS_CHMOD_FILE ) ) {
                        echo '<div class="updated"><p>' . esc_html__( 'User successfully added.', 'protect-wp-login' ) . '</p></div>';
                    } else {
                        echo '<div class="error"><p>' . esc_html__( 'Error writing to the password file.', 'protect-wp-login' ) . '</p></div>';
                    }
                } else {
                    echo '<div class="error"><p>' . esc_html__( 'Cannot write to the password file. Please check the permissions.', 'protect-wp-login' ) . '</p></div>';
                }
            }
        } else {
            $error_message = esc_html__( 'Please enter a username and password.', 'protect-wp-login' );
        }
    }
}

    $existing_users = array();
    $passwd_content = $wp_filesystem->get_contents( PROTECT_WP_LOGIN_PASSWD_FILE );
    $lines = explode( "\n", $passwd_content );
    foreach ( $lines as $line ) {
        if ( ! empty( trim( $line ) ) ) {
            list( $user, $hashed_password ) = explode( ':', $line, 2 );
            $password_warning = '';

            if ( password_verify($user, $hashed_password) ) {
                $password_warning = ' <span style="color:red;">(' . esc_html__('Attention: Username and Password are equal', 'protect-wp-login') . ')</span>';
            }

            $existing_users[] = [
                'user' => $user,
                'warning' => $password_warning
            ];
        }
    }

    ?>
    <div class="wrap">
        <h1>
            <img src="<?php echo esc_url(plugins_url( '../assets/images/protect_wp_login_title.png', __FILE__ )); ?>" alt="Logo" style="vertical-align: middle; margin-right: 10px; height: 62px;">
            <?php echo esc_html__( 'Protect WP Login', 'protect-wp-login' ); ?>
        </h1>
        <?php if ( ! empty( $error_message ) ) : ?>
            <div class="notice notice-error"><p><?php echo esc_html( $error_message ); ?></p></div>
        <?php endif; ?>

        <h2><?php echo esc_html__( 'Add New User', 'protect-wp-login' ); ?></h2>
        <form method="post" class="validate">
            <?php wp_nonce_field( 'protect_wp_login_passwd_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="protect_wp_login_username"><?php echo esc_html__( 'Username', 'protect-wp-login' ); ?></label></th>
                    <td><input name="protect_wp_login_username" type="text" id="protect_wp_login_username" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="protect_wp_login_password"><?php echo esc_html__( 'Password', 'protect-wp-login' ); ?></label></th>
                    <td><input name="protect_wp_login_password" type="password" id="protect_wp_login_password" class="regular-text" required></td>
                </tr>
            </table>
            <input type="hidden" name="protect_wp_login_save_passwd" value="1">
            <?php submit_button( esc_html__( 'Save', 'protect-wp-login' ) ); ?>
        </form>

        <h2><?php echo esc_html__( 'Existing Users', 'protect-wp-login' ); ?></h2>
        <p><?php echo esc_html__( 'Note: There will always be at least 1 username. There is no maximum limit on users.', 'protect-wp-login' ); ?></p>
        <table class="wp-list-table widefat fixed striped users">
            <thead>
                <tr>
                    <th scope="col" id="username" class="manage-column column-username"><?php echo esc_html__('Username', 'protect-wp-login'); ?></th>
                    <th scope="col" id="actions" class="manage-column column-actions"><?php echo esc_html__('Actions', 'protect-wp-login'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $existing_users as $user_data ) : ?>
                    <tr>
                        <td>
                            <?php echo esc_html( $user_data['user'] ); ?>
                            
                            <?php
                            if (!empty($user_data['warning'])) {
                                echo '<span style="color:red;">' . esc_html__('(Attention: Username and Password are equal)', 'protect-wp-login') . '</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ( count( $existing_users ) > 1 ) : ?>
                                <form method="post" style="display: inline;">
                                    <?php wp_nonce_field( 'protect_wp_login_delete_user_nonce' ); ?>
                                    <input type="hidden" name="protect_wp_login_delete_username" value="<?php echo esc_attr( $user_data['user'] ); ?>">
                                    <input type="submit" name="protect_wp_login_delete_user" class="button-link-delete" value="<?php echo esc_html__('Delete', 'protect-wp-login'); ?>">
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
