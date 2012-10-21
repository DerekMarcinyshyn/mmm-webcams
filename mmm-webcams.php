<?php
/**
 * @package MMM_Webcams
 * @version 0.1
 */
/*
Plugin Name: MMM Webcams
Plugin URI: http://monasheemountainmultimedia.com/plugins/mmm-webcams/
Description: Displays webcams on your page.
Author: Derek Marcinyshyn
Version: 0.1
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
define( 'MMM_WC_VERSION', '0.1');

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
require_once( MMM_WC_APP_PATH . '/code/Block/Monashee_Webcam.php' );

// Require updater class
require_once( MMM_WC_LIB_PATH . '/jkudish/updater.php' );

// Initialize and setup application
global  $mmm_wc_app;

// Main class app initialization in Monashee_Weather::__construct()
$mmm_wc_app = Monashee_Webcam::get_instance();