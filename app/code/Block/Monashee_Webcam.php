<?php
/**
 * Monashee Webcam
 * @package     Block
 * @since       October 20, 2012
 * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
 * @version     1.0
 */
class Monashee_Webcam {
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
        // ===========
        // = ACTIONS =
        // ===========

        // add updater action
        add_action('init', 'github_plugin_updater');
    }

    function github_plugin_updater() {
        define('WP_GITHUB_FORCE_UPDATE', true);

        if (is_admin()) {
            $config = array(
                'slug'                  => plugin_basename(__FILE__),
                'proper_folder_name'    => 'mmm-webcams',
                'api_url'               => 'https://api.github.com/repos/',
                'raw_url'               => 'https://raw.github.com/',
                'github_url'            => 'https://github.com/',
                'zip_url'               => 'https://github.com/',
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