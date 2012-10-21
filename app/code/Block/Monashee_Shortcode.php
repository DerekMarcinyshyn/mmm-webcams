<?php

if ( ! class_exists( 'Monashee_Shortcode' ) ) :
    /**
     * Monashee Webcams
     * @package     Block
     * @since       October 20, 2012
     * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
     * @version     1.0
     */
class Monashee_Shortcode {
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
     * Default constructor -- shortcode [mmm-webcams]
     */
    private function __construct() { }

    function display_webcams( $atts, $content = null ) {
        $html = '<img src="http://images.drivebc.ca/bchighwaycam/pub/cameras/101.jpg?' . time() . '" alt="" />';

        return $html;
    }

}
endif; // end if class_exists
