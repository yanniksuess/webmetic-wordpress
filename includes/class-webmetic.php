<?php
/**
 * The core plugin class.
 *
 * This is used to define admin-specific hooks and public-facing site hooks.
 *
 * @since      1.0.0
 * @package    Webmetic
 * @subpackage Webmetic/includes
 */

class Webmetic {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->actions = array();
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        // Load admin class
        require_once WEBMETIC_PLUGIN_DIR . 'includes/class-webmetic-admin.php';
    }

    /**
     * Register all of the hooks related to the admin area functionality.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new Webmetic_Admin();

        $this->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
        $this->add_action( 'admin_init', $plugin_admin, 'register_settings' );
        
        // Add settings link to plugin page
        $plugin_basename = plugin_basename( WEBMETIC_PLUGIN_DIR . 'webmetic.php' );
        add_filter( 'plugin_action_links_' . $plugin_basename, array( $plugin_admin, 'add_settings_link' ) );
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        // Get script placement option
        $placement = get_option( 'webmetic_script_placement', 'footer' );
        $hook = ( $placement === 'header' ) ? 'wp_head' : 'wp_footer';
        
        $this->add_action( $hook, $this, 'add_tracking_script' );
    }

    /**
     * Add tracking script to the frontend.
     *
     * @since    1.0.0
     */
    public function add_tracking_script() {
        // Don't add script in admin area
        if ( is_admin() ) {
            return;
        }

        // Get account ID from options
        $account_id = get_option( 'webmetic_account_id', '' );

        // Only add script if account ID is set
        if ( ! empty( $account_id ) ) {
            // Sanitize the account ID
            $account_id = sanitize_text_field( $account_id );
            
            // Output script tag directly to avoid WordPress adding ID attribute
            $script_url = 'https://t.webmetic.de/iav.js?id=' . urlencode( $account_id );
            echo '<script src="' . esc_url( $script_url ) . '" async></script>' . "\n";
        }
    }


    /**
     * Add an action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             The name of the WordPress action that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the action is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    protected function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
    }
}