<?php
add_action( 'admin_init', 'activate_' . $lct_g->lct_us );
function activate_lct_useful_shortcodes_functions() {
	$lct_g = new lct_g;

	if( is_admin() && get_option( $lct_g->lct_us ) == 'activate' ) {
		delete_option( $lct_g->lct_us );

		//Move /lct/* dir from the plugin dir, to the /uploads dir
		rename( $lct_g->plugin_dir_path . 'lct', lct_path_up() . '/lct' );
	}
}
