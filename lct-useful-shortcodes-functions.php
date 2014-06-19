<?php
/*
Plugin Name: LCT Useful Shortcodes & Functions
Plugin URI: http://lookclassy.com/wordpress-plugins/useful-shortcodes-functions/
Description: Shortcodes & Functions that will help make your life easier.
Version: 1.1.1
Text Domain: lct-useful-shortcodes-functions
Author: Look Classy Technologies
Author URI: http://lookclassy.com/
License: GPLv3 (http://opensource.org/licenses/GPL-3.0)
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
$plugin_file = __FILE__;
$plugin_dir_url = plugin_dir_url( __FILE__ );
$plugin_dir_path = plugin_dir_path( __FILE__ );


include ( 'debug/functions.php' );
include ( 'debug/shortcodes.php' );

include ( 'misc/functions.php' );
include ( 'misc/shortcodes.php' );


//Activation, Deactivation & Uninstall
include( 'activate.php' );


function hook_activate_lct_useful_shortcodes_functions() {
	add_option( 'lct_useful_shortcodes_functions', 'activate' );
}
register_activation_hook( __FILE__, 'hook_activate_lct_useful_shortcodes_functions' );


function hook_deactivate_lct_useful_shortcodes_functions() {
	delete_option( 'lct_useful_shortcodes_functions' );

	//Move /lct/* dir from the /uploads dir, back to the plugin dir
	rename( lct_up_path() . '/lct', plugin_dir_path( __FILE__ ) . 'lct' );
}
register_deactivation_hook( __FILE__, 'hook_deactivate_lct_useful_shortcodes_functions' );


function hook_uninstall_lct_useful_shortcodes_functions() {
	delete_option( 'lct_useful_shortcodes_functions' );

	//Move /lct/* dir from the plugin dir, to the /uploads dir
	rename( plugin_dir_path( __FILE__ ) . 'lct', wp_upload_dir()['basedir'] . '/lct' );
	//rename /lct to /lct-old-time
	rename( wp_upload_dir()['basedir'] . '/lct', wp_upload_dir()['basedir'] . '/lct-old-' . current_time( 'timestamp', 1 ) );
}
register_uninstall_hook( __FILE__, 'hook_uninstall_lct_useful_shortcodes_functions' );


include ( 'deprecated/shortcodes.php' );
