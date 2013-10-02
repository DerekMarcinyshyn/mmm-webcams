<?php
/**
 * @package MMM_Webcams
 * @version 1.2
 * @since   October 20, 2012
 */
/*
Plugin Name: MMM Webcams
Plugin URI: https://github.com/DerekMarcinyshyn/mmm-webcams
Description: Displays webcams on your page.
Author: Derek Marcinyshyn
Version: 1.3
Author URI: http://derek.marcinyshyn.com
License: MIT

The MIT License (MIT)

Copyright (c) 2013 Derek Marcinyshyn

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

// Exit if called directly
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

// Plugin version
define( 'MMM_WC_VERSION', '1.3');

// Plugin
define( 'MMM_WC_PLUGIN', __FILE__ );

// Plugin directory
define( 'MMM_WC_DIRECTORY', dirname( plugin_basename(__FILE__) ) );

// Plugin path
define( 'MMM_WC_PATH', WP_PLUGIN_DIR . '/' . MMM_WC_DIRECTORY );

// App path
define( 'MMM_WC_APP_PATH', MMM_WC_PATH . '/app' );

// Lib path
define( 'MMM_WC_LIB_PATH', MMM_WC_PATH . '/lib' );

// URL
define( 'MMM_WC_URL', WP_PLUGIN_URL . '/' . MMM_WC_DIRECTORY );


// Require main class
include_once( MMM_WC_APP_PATH . '/code/Block/Monashee_Webcam_App.php' );

// Require shortcode class
include_once( MMM_WC_APP_PATH . '/code/View/Monashee_Webcam_Shortcode.php' );

// Require custom post type class
include_once( MMM_WC_APP_PATH . '/code/Helper/Monashee_Webcam_CPT.php' );

// Require updater class
include_once( MMM_WC_LIB_PATH . '/updater/updater.php' );

// ====================================
// = Initialize and setup application =
// ====================================

global  $mmm_wc_app,
        $mmm_wc_shortcode,
        $mmm_wc_cpt;

// custom post type class
$mmm_wc_cpt = Monashee_Webcam_CPT::get_instance();

// shortcode class
$mmm_wc_shortcode = Monashee_Webcam_Shortcode::get_instance();

// Main class app initialization in Monashee_Weather::__construct()
$mmm_wc_app = Monashee_Webcam_App::get_instance();
