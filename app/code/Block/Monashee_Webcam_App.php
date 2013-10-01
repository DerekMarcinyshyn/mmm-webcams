<?php

if ( ! class_exists( 'Monashee_Webcam_App' ) ) :
/**
 * Monashee Webcams
 * @package     Block
 * @since       October 20, 2012
 * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
 * @version     1.0
 */
class Monashee_Webcam_App {
    /**
     * _instance class variable
     *
     * Class instance
     *
     * @var null | object
     */
    private static $_instance = NULL;

    static function get_instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Constructor
     *
     * Default constructor -- application initialization
     */
    private function __construct() {
        global $mmm_wc_shortcode,
               $mmm_wc_cpt;

        // Setup hooks
        register_activation_hook( MMM_WC_PLUGIN, array( $this, 'mmm_webcam_add_defaults' ) );
        register_uninstall_hook(  MMM_WC_PLUGIN, 'mmm_webcam_delete_plugin_options' );

        // add the custom post type
        add_action( 'init', array( $mmm_wc_cpt, 'register_cpt_webcam' ) );

        // add the custom taxonomy
        add_action( 'init', array( $mmm_wc_cpt, 'register_taxonomy_cam_categories' ) );

        // initialize metaboxes class
        add_action( 'init', array( $mmm_wc_cpt, 'initialize_mmm_webcam_metaboxes' ), 9999, 0 );

        // add the custom metabox fields to the custom post type webcam
        add_filter( 'cmb_meta_boxes', array( $mmm_wc_cpt, 'mmm_webcam_metaboxes' ), 9 );

        // add custom columns to webcam admin
        add_filter( 'manage_edit-webcam_columns', array( $mmm_wc_cpt, 'add_webcam_columns' ), 10, 1 );

        // add content to the custom columns
        add_action( 'manage_webcam_posts_custom_column', array( $mmm_wc_cpt, 'manage_webcam_custom_columns'), 10, 2);

        // add shortcode action
        add_shortcode( 'mmm-webcams', array( $mmm_wc_shortcode, 'display_webcams' ), 10, 1 );

        // add css and js
        add_action( 'init', array( $this, 'mmm_webcam_css_js' ) );

        // add admin stuff
        add_action( 'admin_init',array( $this, 'mmm_webcam_init' ) );
        add_action( 'admin_menu', array( $this, 'mmm_webcam_admin_menu' ) );

        // add updater action
        add_action( 'init', array( $this, 'github_plugin_updater' ), 10, 0 );
    }

    /**
     * Load the CSS
     */
    public function mmm_webcam_css_js() {
        // load mmm-webcams css
        wp_register_style( 'mmm-webcam-css', MMM_WC_URL . '/assets/css/style.css', true, MMM_WC_VERSION );
        wp_enqueue_style( 'mmm-webcam-css' );

        // load fancybox css
        wp_register_style( 'mmm-webcam-fancybox-css', MMM_WC_URL . '/lib/fancybox/jquery.fancybox.css', true, MMM_WC_VERSION );
        wp_enqueue_style( 'mmm-webcam-fancybox-css' );

        // load fancybox jquery
        wp_register_script( 'mmm-webcam-fancybox-jscript', MMM_WC_URL . '/lib/fancybox/jquery.fancybox.pack.js', array( 'jquery' ), MMM_WC_VERSION, true );
        wp_enqueue_script( 'mmm-webcam-fancybox-jscript');

        // load jquery mousewheel
        wp_register_script( 'jquery-mousewheel', MMM_WC_URL . '/lib/jquery/jquery.mousewheel-3.0.6.pack.js', array( 'jquery' ), '3.0.6', true );
        wp_enqueue_script( 'jquery-mousewheel');

        // load mmm-webcams javascript
        wp_register_script( 'mmm-webcam-jscript', MMM_WC_URL . '/assets/js/mmm-webcam.js', array( 'jquery' ), MMM_WC_VERSION, true );
        wp_enqueue_script( 'mmm-webcam-jscript');

        // load greensock animation library
        wp_register_script( 'mmm-greensock', MMM_WC_URL . '/lib/greensock/TweenMax.min.js', array( 'jquery' ), '1.542', true );
        wp_enqueue_script( 'mmm-greensock');

        // load greensock timeline Lite animation library
        wp_register_script( 'mmm-greensock-timelinelite', MMM_WC_URL . '/lib/greensock/TimelineLite.min.js', array( 'jquery' ), '1.486', true );
        wp_enqueue_script( 'mmm-greensock-timelinelite');
    }

    public function mmm_webcam_admin_menu() {
        add_submenu_page( 'edit.php?post_type=webcam', 'Settings', 'Settings', 'manage_options', 'mmm-webcam-settings', array( $this, 'webcam_admin_settings' ) );
    }

    public function webcam_admin_settings() {
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __('You do not have sufficient permissions to access this page.' ) );
        }
        ?>
<div class="wrap">
    <div class="icon32" id="icon-options-general"><br></div>
    <h2>MMM Webcams</h2>
    <p>To display your webcams on a page use shortcode <code>[mmm-webcams]</code> where ever you would like the cams to appear.</p>
    <h2>Settings</h2>

    <form action="options.php" method="post">
        <?php settings_fields( 'mmm_webcams_plugin_options' ); ?>
        <?php $options = get_option( 'mmm_webcams_options' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">Webcam Fly-in Animation</th>
                <td><label><input name="mmm_webcams_options[chk_animation]" type="checkbox" value="1" <?php if ( isset ( $options['chk_animation'] ) ) { checked( '1', $options['chk_animation'] ); } ?> /> Check if you want to show animated fly in.</label></td>
            </tr>

            <tr valign="top">
                <th scope="row">Developer Love</th>
                <td><label><input name="mmm_webcams_options[chk_developer]" type="checkbox" value="1" <?php if ( isset ( $options['chk_developer'] ) ) { checked( '1', $options['chk_developer'] ); } ?> /> Check if you want to show link to developer.</label></td>
            </tr>

            <tr><td colspan="2"><div style="margin-top:30px;"></div></td></tr>
            <tr valign="top" style="border-top:#dddddd 1px solid;">
                <th scope="row">Database Options</th>
                <td>
                    <label><input name="mmm_webcams_options[chk_default_options_db]" type="checkbox" value="1" <?php if (isset($options['chk_default_options_db'])) { checked('1', $options['chk_default_options_db']); } ?> /> Restore defaults upon plugin deactivation/reactivation</label>
                    <br /><span style="color:#666666;margin-left:2px;">Only check this if you want to reset plugin settings upon Plugin reactivation</span>
                </td>
            </tr>

        </table>
        <p class="submit"><input type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button button-primary" /></p>
    </form>


</div>
        <?php
    }

    /**
     * Add options default on activation
     */
    public function mmm_webcam_add_defaults() {
        $array = array("chk_animation" => "1", "chk_developer" => "1");
        update_option('mmm_webcams_options', $array);
    }

    /**
     * Delete option table entries ONLY when plugin deactivated and deleted
     */
    public function mmm_webcam_delete_plugin_options() {
        delete_option( 'mmm_webcams_options' );
    }

    /**
     * Init plugin options to white list our options
     */
    public function mmm_webcam_init() {
        register_setting( 'mmm_webcams_plugin_options', 'mmm_webcams_options' );
    }

    /**
     * Github Plugin Updater API
     * @see     /lib/jkudish/updater.php
     * @link    https://github.com/jkudish/WordPress-GitHub-Plugin-Updater
     */
    public function github_plugin_updater() {
        define( 'MMM_WEBCAMS_FORCE_UPDATE', true );

        if ( is_admin() ) {
            $config = array(
                'slug'                  => MMM_WC_DIRECTORY . '/mmm-webcams.php',
                'proper_folder_name'    => 'mmm-webcams',
                'api_url'               => 'https://api.github.com/repos/DerekMarcinyshyn/mmm-webcams',
                'raw_url'               => 'https://raw.github.com/DerekMarcinyshyn/mmm-webcams/master',
                'github_url'            => 'https://github.com/DerekMarcinyshyn/mmm-webcams',
                'zip_url'               => 'https://github.com/DerekMarcinyshyn/mmm-webcams/zipball/master',
                'sslverify'             => false,
                'requires'              => '3.0',
                'tested'                => '3.7',
                'readme'                => 'README.md',
                'access_token'          => '',
            );

            new MMM_Webcams_Updater( $config );
        }
    }
}
endif; // end if class exists