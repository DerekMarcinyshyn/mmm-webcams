<?php
/**
 * @package MMM_Webcams
 * @version 1.0
 */
/*
Plugin Name: MMM Webcams
Plugin URI: http://monasheemountainmultimedia.com/plugins/mmm-webcams/
Description: Displays webcams on your page.
Author: Derek Marcinyshyn
Version: 1.0
Author URI: http://derek.marcinyshyn.com
License: GPLv2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// Exit if called directly
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

// Plugin version
define( 'MMM_WC_VERSION', '1.0');

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
require_once( MMM_WC_APP_PATH . '/code/Block/Monashee_Webcam_App.php' );

// Require shortcode class
require_once( MMM_WC_APP_PATH . '/code/View/Monashee_Webcam_Shortcode.php' );

// Require custom post type class
require_once( MMM_WC_APP_PATH . '/code/Helper/Monashee_Webcam_CPT.php' );

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

