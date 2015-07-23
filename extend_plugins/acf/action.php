<?php
//Prints required acf scripts
add_action( 'admin_print_scripts', 'lct_acf_print_scripts' );
function lct_acf_print_scripts() {
	$g_lusf = new g_lusf;

	wp_enqueue_style( 'lct_acf', $g_lusf->plugin_dir_url . "assets/wp-admin/css/extend_plugins/acf.css", null );
}
