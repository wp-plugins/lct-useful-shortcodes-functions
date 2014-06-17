<?php
add_action( 'admin_init', 'activate_lct_useful_shortcodes_functions' );
function activate_lct_useful_shortcodes_functions() {
	if ( is_admin() && get_option( 'lct_useful_shortcodes_functions' ) == 'activate' ) {
		delete_option( 'lct_useful_shortcodes_functions' );

		//Move /lct/* dir from the plugin dir, to the /uploads dir
		rename( plugin_dir_path( __FILE__ ) . 'lct', lct_up_path() . '/lct' );
	}
}
