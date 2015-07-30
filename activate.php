<?php
add_action( 'admin_init', 'activate_' . $g_lct->lct_us );
function activate_lct_useful_shortcodes_functions() {
	$g_lct = new g_lct;

	if( is_admin() && get_option( $g_lct->lct_us ) == 'activate' ) {
		delete_option( $g_lct->lct_us );

		//TODO: cs - Let's not do this for now. Find a way to completely deprovision this action - 7/29/2015 10:18 AM
		//Move /lct/* dir from the plugin dir, to the /uploads dir
		//rename( $g_lct->plugin_dir_path . 'lct', lct_path_up() . '/lct' );
	}
}
