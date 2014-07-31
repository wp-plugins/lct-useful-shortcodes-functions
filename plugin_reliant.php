<?php
//ADD custom stylesheet to front-end
add_action('lct_before_end_of_head', 'lct_front_css', 1001 );
function lct_front_css() {
	if( ! lct_get_lct_useful_settings( 'Enable_Front_css' ) ) return;

	$g_lusf = new g_lusf;

	wp_enqueue_style( 'lct_front_css', $g_lusf->plugin_dir_url . 'assets/css/front.css' );
}


function lct_get_lct_useful_settings( $value = null ) {
	if( $value )
		return get_option( 'lct_useful_settings' )[$value];

	return get_option( 'lct_useful_settings' );
}
