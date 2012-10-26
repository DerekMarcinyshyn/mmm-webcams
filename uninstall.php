<?php
/**
 * Monashee Webcams
 * @package     uninstall
 * @since       October 25, 2012
 * @author      Derek Marcinyshyn <derek@marcinyshyn.com>
 * @version     1.0
 */

// if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

delete_option( 'mmm_webcams_options' );