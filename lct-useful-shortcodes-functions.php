<?php /**
 * Plugin Name: LCT Useful Shortcodes & Functions
 * Plugin URI: http://lookclassy.com/wordpress-plugins/useful-shortcodes-functions/
 * Version: 4.3.7
 * Text Domain: lct-useful-shortcodes-functions
 * Author: Look Classy Technologies
 * Author URI: http://lookclassy.com/
 * License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
 * Description: Shortcodes & Functions that will help make your life easier.
 * Copyright 2014 Look Classy Technologies  (email : info@lookclassy.com)
 */

/*
Copyright (C) 2014 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


//PLUGIN PREFIX: lct


//Globals
$g_lct = new g_lct;

class g_lct {
	public $editzz = 'editzz';
	public $pre = 'lct_';
	public $lct_dash = 'lct-useful-shortcodes-functions';
	public $lct_us = 'lct_useful_shortcodes_functions';

	public function __construct() {
		$this->plugin_file = __FILE__;
		$this->plugin_dir_url = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );

		register_activation_hook( $this->plugin_file, 'hook_activate_' . $this->lct_us );
		register_deactivation_hook( $this->plugin_file, 'hook_deactivate_' . $this->lct_us );
		register_uninstall_hook( $this->plugin_file, 'hook_uninstall_' . $this->lct_us );
	}
}


include( 'plugin_reliant.php' );

include( 'deprecated.php' );

include( 'admin/functions.php' );
include( 'admin/shortcodes.php' );
include( 'admin/menu.php' );

include( 'debug/functions.php' );
include( 'debug/shortcodes.php' );

include( 'display/fields.php' );
include( 'display/options.php' );

include( 'features/__init.php' );

include( 'front/functions.php' );

include( 'gforms/functions.php' );

include( 'helpers/helper.php' );

include( 'misc/functions.php' );
include( 'misc/login.php' );


include( 'lct_baw_force_plugin_updates/index.php' );
include( 'lct_sitemap_generator/index.php' );
include( 'lct_textimage_linking_shortcode/index.php' );


//Activation, Deactivation & Uninstall
include( 'activate.php' );


add_action( 'plugins_loaded', 'lct_plugins_loaded' );
function lct_plugins_loaded() {
	include( 'extend_plugins/acf/__init.php' );
	include( 'extend_plugins/Adava/__init.php' );
	include( 'extend_plugins/better-wp-security/__init.php');
	include( 'extend_plugins/maintenance/__init.php');
}


function hook_activate_lct_useful_shortcodes_functions() {
	$g_lct = new g_lct;

	add_option( $g_lct->lct_us, 'activate' );
}


function hook_deactivate_lct_useful_shortcodes_functions() {
	global $g_lct;

	delete_option( $g_lct->lct_us );

	//TODO: cs - Let's not do this for now. Find a way to completely deprovision this action - 7/29/2015 10:18 AM
	//Move /lct/* dir from the /uploads dir, back to the plugin dir
	//rename( lct_path_up() . '/lct', $g_lct->plugin_dir_path . 'lct' );
}


function hook_uninstall_lct_useful_shortcodes_functions() {
	global $g_lct;
	$wp_upload_dir = wp_upload_dir();

	delete_option( $g_lct->lct_us );

	//TODO: cs - Let's not do this for now. Find a way to completely deprovision this action - 7/29/2015 10:18 AM
	//Move /lct/* dir from the plugin dir, to the /uploads dir
	//rename( $g_lct->plugin_dir_path . 'lct', $wp_upload_dir['basedir'] . '/lct' );

	//TODO: cs - Let's not do this for now. Find a way to completely deprovision this action - 7/29/2015 10:18 AM
	//rename /lct to /lct-old-time
	//rename( $wp_upload_dir['basedir'] . '/lct', $wp_upload_dir['basedir'] . '/lct-old-' . current_time( 'timestamp', 1 ) );
}
