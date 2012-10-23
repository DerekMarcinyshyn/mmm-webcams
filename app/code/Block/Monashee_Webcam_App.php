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

        // add the custom post type
        add_action( 'init', array( &$mmm_wc_cpt, 'register_cpt_webcam' ) );

        // initialize metaboxes class
        add_action( 'init', array( &$mmm_wc_cpt, 'initialize_mmm_webcam_metaboxes' ), 9999, 0 );

        // add the custom metabox fields to the custom post type webcam
        add_filter( 'cmb_meta_boxes', array( &$mmm_wc_cpt, 'mmm_webcam_metaboxes' ), 9 );

        // add shortcode action
        add_shortcode( 'mmm-webcams', array( &$mmm_wc_shortcode, 'display_webcams' ), 10, 1 );

        // add css
        add_action( 'init', array( &$this, 'mmm_webcam_css' ) );

        // add updater action
        add_action( 'init', array( &$this, 'github_plugin_updater' ), 10, 0 );
    }

    /**
     * Load the CSS
     */
    function mmm_webcam_css() {
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
    }

    /**
     * Github Plugin Updater API
     * @see     /lib/jkudish/updater.php
     * @link    https://github.com/jkudish/WordPress-GitHub-Plugin-Updater
     */
    function github_plugin_updater() {
        if ( !defined( 'WP_GITHUB_FORCE_UPDATE' ) )
            define( 'WP_GITHUB_FORCE_UPDATE', true );

        if ( is_admin() ) {
            $config = array(
                'slug'                  => plugin_basename(__FILE__),
                'proper_folder_name'    => 'mmm-webcams',
                'api_url'               => 'https://api.github.com/repos/DerekMarcinyshyn/mmm-webcams',
                'raw_url'               => 'https://raw.github.com/DerekMarcinyshyn/mmm-webcams/master',
                'github_url'            => 'https://github.com/DerekMarcinyshyn/mmm-webcams',
                'zip_url'               => 'https://github.com/DerekMarcinyshyn/mmm-webcams/zipball/master',
                'sslverify'             => true,
                'requires'              => '3.0',
                'tested'                => '3.5',
                'readme'                => 'README.md',
                'access_token'          => '',
            );

            new WPGitHubUpdater($config);
        }
    }
}
endif; // end if class exists