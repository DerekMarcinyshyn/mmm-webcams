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
     * Display the webcams within their respective categories
     * @param $atts
     * @param null $content
     * @return string
     */
    function display_webcams( $atts, $content = null ) {
        $html = '';

        $cat_args = array(
                    'orderby'       => 'name',
                    'order'         => 'ASC',
                    'hide_empty'    => 1,
                    'taxonomy'      => 'cam_categories',
        );

        // cycle through each category
        foreach ( get_categories( $cat_args) as $tax ) :

            $args = array(
                    'post_type'             => 'webcam',
                    'posts_per_page'        => '-1',
                    'orderby'               => 'title',
                    'order'                 => 'ASC',
                    'post_status'           => 'publish',
                    'tax_query'             => array(
                                                    array(
                                                        'taxonomy'  => 'cam_categories',
                                                        'field'     => 'slug',
                                                        'terms'     => $tax->slug
                                                    )
                                                )
                    );

            if ( get_posts($args) ) {
                $html .= '<h3 class="webcams">' . $tax->name . '</h3>';

                $html .= '<ul class="mmm-webcams">';

                foreach ( get_posts($args) as $p ) {
                    $post_id = $p->ID;

                    $html .= '<li class="mmm-webcam">';

                    $img = get_post_meta( $post_id, '_mmm_webcam_url_text', true );

                    $html .= '<a class="fancybox" rel="webcams" href="' . $img . '?' . time() . '" title="' . $p->post_title . '"><img src="' . $img . '?' . time() . '" alt="' . $p->post_title . '" width="150" /></a>';

                    $html .= '<h5>' . $p->post_title . '</h5>';

                    $html .= '<p>' . get_post_meta( $post_id, '_mmm_webcam_description_text', true ) . '</p>';

                    $html .= '</li>';
                } // end while

                $html .= '</ul>';
                $html .= '<div style="clear:both;"></div>';
            }

        endforeach; // end foreach

        return $html;
    }

}
endif; // end if class_exists
