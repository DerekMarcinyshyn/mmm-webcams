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
    public function display_webcams( $atts, $content = null ) {

        // add the css and js only when the shortcode is used not on every page load
        add_action( 'init', array( $this, 'mmm_webcam_css_js' ) );

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

        // Get options
        $options = get_option( 'mmm_webcams_options' );

        // Show developer love
        if ( isset( $options['chk_developer'] ) )
            $html .= '<p class="mmm-developer">Powered by: <a href="http://monasheemountainmultimedia.com" target="_blank">MMM</a></p>';

        // Show animation
        if ( isset( $options['chk_animation'] ) )
            $html .= '<script type="text/javascript">
jQuery(document).ready( function () {
    TweenMax.to( jQuery("h3.webcams"), 0, {css: { opacity: 0, marginLeft:600 } } );
    TweenMax.to( jQuery("h3.webcams"), 0.7, {css: { opacity: 1, marginLeft:0 }, ease: Bounce.easeOut, delay:0.3 } );
    var tl = new TimelineLite();
    tl.staggerFrom( jQuery(".mmm-webcam"), 0.6, {css: { marginTop:"-=300px", opacity: 0 } }, 0.2 );
});
</script>';

        return $html;
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

        // load greensock TweenMax animation library over CDN
        wp_register_script( 'mmm-greensock-timelinelite', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.10.3/TweenMax.min.js', false, '1.10.3', true );
        wp_enqueue_script( 'mmm-greensock-timelinelite');
    }

}
endif; // end if class_exists
