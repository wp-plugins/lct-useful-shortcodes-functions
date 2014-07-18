<?php
/*
Plugin Name: LCT Useful Shortcodes & Functions
Plugin URI: http://lookclassy.com/wordpress-plugins/useful-shortcodes-functions/
Version: 1.2.5
Text Domain: lct-useful-shortcodes-functions
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
Description: Shortcodes & Functions that will help make your life easier.
Copyright 2013 Look Classy Technologies  (email : info@lookclassy.com)
*/

/*
Copyright (C) 2013 Look Classy Technologies

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


//Globals
$g_lusf = new g_lusf;
class g_lusf {
 	public $editzz						= 'editzz';
	public $lct_dash					= 'lct-useful-shortcodes-functions';
	public $lct_us						= 'lct_useful_shortcodes_functions';

	public function __construct() {
		$this->plugin_file				= __FILE__;
		$this->plugin_dir_url			= plugin_dir_url( __FILE__ );
		$this->plugin_dir_path			= plugin_dir_path( __FILE__ );

		register_activation_hook( $this->plugin_file, 'hook_activate_' . $this->lct_us );
		register_deactivation_hook( $this->plugin_file, 'hook_deactivate_' . $this->lct_us );
		register_uninstall_hook( $this->plugin_file, 'hook_uninstall_' . $this->lct_us );
	}
}

include ( 'debug/functions.php' );
include ( 'debug/shortcodes.php' );

include ( 'misc/functions.php' );
include ( 'misc/shortcodes.php' );


//Activation, Deactivation & Uninstall
include ( 'activate.php' );


function hook_activate_lct_useful_shortcodes_functions() {
	$g_lusf = new g_lusf;

	add_option( $g_lusf->lct_us, 'activate' );
}


function hook_deactivate_lct_useful_shortcodes_functions() {
	global $g_lusf;

	delete_option( $g_lusf->lct_us );

	//Move /lct/* dir from the /uploads dir, back to the plugin dir
	rename( lct_path_up() . '/lct', $g_lusf->plugin_dir_path . 'lct' );
}



function hook_uninstall_lct_useful_shortcodes_functions() {
	global $g_lusf;

	delete_option( $g_lusf->lct_us );

	//Move /lct/* dir from the plugin dir, to the /uploads dir
	rename( $g_lusf->plugin_dir_path . 'lct', wp_upload_dir()['basedir'] . '/lct' );
	//rename /lct to /lct-old-time
	rename( wp_upload_dir()['basedir'] . '/lct', wp_upload_dir()['basedir'] . '/lct-old-' . current_time( 'timestamp', 1 ) );
}



include ( 'deprecated/shortcodes.php' );
