<?php

if ( ! class_exists( 'Monashee_Webcam_CPT' ) ) :
    /**
     * Monashee Webcams
     * @package     Helper
     * @since       October 21, 2012
     * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
     * @version     1.0
     */
    class Monashee_Webcam_CPT {
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
         * Default constructor
         */
        private function __construct() {

        }

        function initialize_mmm_webcam_metaboxes() {
            if ( !class_exists( ' cmb_Meta_Box' ) ) {
                require_once( MMM_WC_LIB_PATH . '/metabox/init.php' );
            }
        }

        /**
         * @param $meta_boxes
         * @return array
         */
        function mmm_webcam_metaboxes( $meta_boxes ) {
            $prefix = '_mmm_';
            $meta_boxes[] = array(
                    'id'            => 'url_metabox',
                    'title'         => 'Webcam Url',
                    'pages'         => array( 'webcam' ), // post type
                    'context'       => 'normal',
                    'priority'      => 'high',
                    'show_names'    => true, // show field names on the left
                    'fields'        => array(
                                        array(
                                            'name'  => 'Webcam Url',
                                            'desc'  => 'field description (optional)',
                                            'id'    => $prefix . 'webcam_url_text',
                                            'type'  => 'text'
                                        ),
                    ),
            );

            return $meta_boxes;
        }

        /**
         * Register the Custom Post Type -- webcam
         */
        function register_cpt_webcam() {

            $labels = array(
                'name'                  => _x( 'Webcams', 'webcam' ),
                'singular_name'         => _x( 'Webcam', 'webcam' ),
                'add_new'               => _x( 'Add New', 'webcam' ),
                'add_new_item'          => _x( 'Add New Webcam', 'webcam' ),
                'edit_item'             => _x( 'Edit Webcam', 'webcam' ),
                'new_item'              => _x( 'New Webcam', 'webcam' ),
                'view_item'             => _x( 'View Webcam', 'webcam' ),
                'search_items'          => _x( 'Search Webcams', 'webcam' ),
                'not_found'             => _x( 'No webcams found', 'webcam' ),
                'not_found_in_trash'    => _x( 'No webcams found in Trash', 'webcam' ),
                'parent_item_colon'     => _x( 'Parent Webcam:', 'webcam' ),
                'menu_name'             => _x( 'Webcams', 'webcam' ),
            );

            $args = array(
                'labels'                => $labels,
                'hierarchical'          => false,
                'description'           => 'Add your favorite webcam url and title.',
                'supports'              => array(''),

                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 20,

                'show_in_nav_menus'     => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'has_archive'           => true,
                'query_var'             => true,
                'can_export'            => true,
                'rewrite'               => true,
                'capability_type'       => 'post'
            );

            register_post_type( 'webcam', $args );
        }


    }
endif; // end if class_exists
