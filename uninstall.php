<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 * @package    Webmetic
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete plugin options
delete_option( 'webmetic_account_id' );
delete_option( 'webmetic_script_placement' );

// For multisite installations
if ( is_multisite() ) {
    // Get all blogs in the network
    $blog_ids = get_sites( array( 'fields' => 'ids' ) );
    
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        delete_option( 'webmetic_account_id' );
        delete_option( 'webmetic_script_placement' );
        restore_current_blog();
    }
}