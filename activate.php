<?php
add_action( 'admin_init', 'activate_' . $g_lusf->lct_us );
function activate_lct_useful_shortcodes_functions() {
	$g_lusf = new g_lusf;

	if( is_admin() && get_option( $g_lusf->lct_us ) == 'activate' ) {
		delete_option( $g_lusf->lct_us );

		//Move /lct/* dir from the plugin dir, to the /uploads dir
		rename( $g_lusf->plugin_dir_path . 'lct', lct_path_up() . '/lct' );
	}
}
