<?php
//Prints required acf scripts
add_action( 'admin_print_scripts', 'lct_acf_print_scripts' );
function lct_acf_print_scripts() {
	$g_lct = new g_lct;

	wp_enqueue_style( 'lct_acf', $g_lct->plugin_dir_url . "assets/wp-admin/css/extend_plugins/acf.min.css", null );
}
