<?php

if ( ! class_exists( 'Monashee_Webcam_Shortcode' ) ) :
    /**
     * Monashee Webcams
     * @package     Block
     * @since       October 20, 2012
     * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
     * @version     1.0
     */
class Monashee_Webcam_Shortcode {
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

    /**
     * Display the webcams where the shortcode lives
     * @param $atts
     * @param null $content
     * @return string
     */
    function display_webcams( $atts, $content = null ) {
        $loop = new WP_Query(
            array(
                'post_type'         => 'webcam',
                'orderby'           => 'title',
                'order'             => 'ASC',
                'posts_per_page'    => '-1',
            )
        );

        if ( $loop->have_posts() ) {

            $html = '<ul class="mmm-webcams">';

            while ( $loop->have_posts() ) {
                $loop->the_post();

                $img = get_post_meta( get_the_ID(), '_mmm_webcam_url_text', true );

                $html .= '<img src="' . $img . '" alt="' . the_title( '', '', false ) . '" />';

                $html .= the_title(
                    '<li>',
                    '</li>',
                    false
                    );

                $html .= get_post_meta( get_the_ID(), '_mmm_webcam_description_text', true );
            }

            $html .= '</ul>';
        } else {
            $html = '<p>Sorry no webcams created.</p>';
        }

        return $html;
    }

}
endif; // end if class_exists
