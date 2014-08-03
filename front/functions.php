<?php
/**
 * ADD custom stylesheet to front-end
 */
add_action('lct_before_end_of_head', 'lct_front_css', 1001 );
function lct_front_css() {
	if( ! lct_get_lct_useful_settings( 'Enable_Front_css' ) ) return;

	$g_lusf = new g_lusf;

	wp_enqueue_style( 'lct_front_css', $g_lusf->plugin_dir_url . 'assets/css/front.css' );
}


/**
 * ADD autosize.js when needed
 */
add_action( 'lct_jquery_autosize_min_js', 'lct_jquery_autosize_min_js' );
function lct_jquery_autosize_min_js() {
	$g_lusf = new g_lusf;

	wp_register_script( 'lct_jquery_autosize_min_js', $g_lusf->plugin_dir_url . 'includes/autosize/jquery.autosize.min.js', array('jquery') );
	wp_enqueue_script( 'lct_jquery_autosize_min_js' );
}
