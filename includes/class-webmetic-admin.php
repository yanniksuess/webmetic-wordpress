<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Webmetic
 * @subpackage Webmetic/includes
 */

class Webmetic_Admin {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Nothing to initialize
    }

    /**
     * Add admin menu item.
     *
     * @since    1.0.0
     */
    public function add_admin_menu() {
        add_options_page(
            __( 'Webmetic Settings', 'webmetic' ),
            __( 'Webmetic', 'webmetic' ),
            'manage_options',
            'webmetic',
            array( $this, 'settings_page' )
        );
    }

    /**
     * Add settings link to plugin actions.
     *
     * @since    1.0.0
     * @param    array $links Array of plugin action links.
     * @return   array        Modified array of plugin action links.
     */
    public function add_settings_link( $links ) {
        $settings_link = '<a href="' . admin_url( 'options-general.php?page=webmetic' ) . '">' . __( 'Settings', 'webmetic' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    /**
     * Register plugin settings.
     *
     * @since    1.0.0
     */
    public function register_settings() {
        // Register account ID setting
        register_setting(
            'webmetic_settings',
            'webmetic_account_id',
            array(
                'type'              => 'string',
                'description'       => __( 'Webmetic Account ID', 'webmetic' ),
                'sanitize_callback' => array( $this, 'sanitize_account_id' ),
                'default'           => ''
            )
        );

        // Register script placement setting
        register_setting(
            'webmetic_settings',
            'webmetic_script_placement',
            array(
                'type'              => 'string',
                'description'       => __( 'Script Placement', 'webmetic' ),
                'sanitize_callback' => array( $this, 'sanitize_placement' ),
                'default'           => 'footer'
            )
        );

        add_settings_section(
            'webmetic_settings_section',
            __( 'Configuration', 'webmetic' ),
            array( $this, 'settings_section_callback' ),
            'webmetic'
        );

        add_settings_field(
            'webmetic_account_id',
            __( 'Account ID', 'webmetic' ),
            array( $this, 'account_id_field_callback' ),
            'webmetic',
            'webmetic_settings_section'
        );

        add_settings_field(
            'webmetic_script_placement',
            __( 'Script Placement', 'webmetic' ),
            array( $this, 'script_placement_field_callback' ),
            'webmetic',
            'webmetic_settings_section'
        );
    }

    /**
     * Sanitize account ID input.
     *
     * @since    1.0.0
     * @param    string    $input    The account ID to sanitize.
     * @return   string              The sanitized account ID.
     */
    public function sanitize_account_id( $input ) {
        // Remove any whitespace
        $input = trim( $input );
        
        // Allow alphanumeric characters, hyphens, and underscores
        $sanitized = preg_replace( '/[^a-zA-Z0-9_-]/', '', $input );
        
        // Limit length to 100 characters
        $sanitized = substr( $sanitized, 0, 100 );
        
        return $sanitized;
    }

    /**
     * Sanitize placement option.
     *
     * @since    1.0.0
     * @param    string    $input    The placement option to sanitize.
     * @return   string              The sanitized placement option.
     */
    public function sanitize_placement( $input ) {
        $valid_options = array( 'header', 'footer' );
        
        if ( in_array( $input, $valid_options ) ) {
            return $input;
        }
        
        return 'footer';
    }

    /**
     * Settings section callback.
     *
     * @since    1.0.0
     */
    public function settings_section_callback() {
        echo '<p>' . esc_html__( 'Configure your Webmetic settings below.', 'webmetic' ) . '</p>';
    }

    /**
     * Account ID field callback.
     *
     * @since    1.0.0
     */
    public function account_id_field_callback() {
        $value = get_option( 'webmetic_account_id', '' );
        ?>
        <input type="text" 
               id="webmetic_account_id" 
               name="webmetic_account_id" 
               value="<?php echo esc_attr( $value ); ?>" 
               class="regular-text" />
        <p class="description">
            <?php 
            /* translators: %s: URL to Webmetic dashboard */
            printf(
                wp_kses(
                    /* translators: %s: URL to Webmetic dashboard */
                    __( 'Your Webmetic Account ID. You can find it in your <a href="%s" target="_blank">Webmetic Dashboard under Tracking Code</a>.', 'webmetic' ),
                    array(
                        'a' => array(
                            'href' => array(),
                            'target' => array(),
                        ),
                    )
                ),
                esc_url( 'https://webmetic.de/dashboard/?menu=tracking_code' )
            );
            ?>
        </p>
        <?php
    }

    /**
     * Script placement field callback.
     *
     * @since    1.0.0
     */
    public function script_placement_field_callback() {
        $value = get_option( 'webmetic_script_placement', 'footer' );
        ?>
        <select id="webmetic_script_placement" name="webmetic_script_placement">
            <option value="footer" <?php selected( $value, 'footer' ); ?>>
                <?php esc_html_e( 'Footer (Recommended)', 'webmetic' ); ?>
            </option>
            <option value="header" <?php selected( $value, 'header' ); ?>>
                <?php esc_html_e( 'Header', 'webmetic' ); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e( 'Choose where to place the Webmetic script. Footer placement is recommended for better performance.', 'webmetic' ); ?>
        </p>
        <?php
    }

    /**
     * Settings page output.
     *
     * @since    1.0.0
     */
    public function settings_page() {
        // Check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // Output security fields for the registered setting
                settings_fields( 'webmetic_settings' );
                
                // Output setting sections and their fields
                do_settings_sections( 'webmetic' );
                
                // Output save settings button
                submit_button( esc_html__( 'Save Settings', 'webmetic' ) );
                ?>
            </form>
        </div>
        <?php
    }
}