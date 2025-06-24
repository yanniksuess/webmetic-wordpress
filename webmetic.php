<?php
/**
 * Plugin Name:       Webmetic
 * Plugin URI:        https://webmetic.de/docs/integrationen/wordpress
 * Description:       Adds Webmetic script to your WordPress site. Simply enter your Account ID in the settings.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Yannik Süß
 * Author URI:        https://github.com/yanniksuess
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       webmetic
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Define plugin constants
define( 'WEBMETIC_VERSION', '1.0.0' );
define( 'WEBMETIC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WEBMETIC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function webmetic_activate() {
    // Set default options
    add_option( 'webmetic_account_id', '' );
    add_option( 'webmetic_script_placement', 'footer' );
}
register_activation_hook( __FILE__, 'webmetic_activate' );

/**
 * The code that runs during plugin deactivation.
 */
function webmetic_deactivate() {
    // Nothing to do on deactivation
}
register_deactivation_hook( __FILE__, 'webmetic_deactivate' );

/**
 * Load plugin textdomain for translations.
 */
function webmetic_load_textdomain() {
    load_plugin_textdomain( 'webmetic', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'webmetic_load_textdomain' );

/**
 * The core plugin class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-webmetic.php';

/**
 * Begins execution of the plugin.
 */
function run_webmetic() {
    $plugin = new Webmetic();
    $plugin->run();
}
run_webmetic();