<?php
function use_placeholders_instead_of_labels_array() {
	$return = lct_get_lct_useful_settings( 'use_placeholders_instead_of_labels' );

	if( ! $return )
		$return = array( 0 );

	return $return;
}


function store_gforms_array() {
	$return = lct_get_lct_useful_settings( 'store_gforms' );

	if( ! $return )
		$return = array( 0 );

	return $return;
}


function lct_custom_redirect_wrapper( $force_exit = true, $headers_sent_already = false ) {
	$current_user = wp_get_current_user();

	if( $headers_sent_already ) {
		$script = '<script type="text/javascript">
			window.location = "/redirect/"
	    </script>';

		echo $script;
		die();
	}

	if( $current_user->ID || $force_exit ) {
		$redirect_to = home_url("/");

		if( function_exists( 'redirect_wrapper' ) )
			$redirect_url = redirect_wrapper( $redirect_to, '', $current_user );

		wp_redirect( $redirect_url );
		die();
	}
}


add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}


add_filter( 'wpseo_opengraph_site_name', 'lct_opengraph_site_name' );
function lct_opengraph_site_name( $title ) {
	if( lct_get_lct_useful_settings( 'hide_og_site_name' ) )
		return false;

	return $title;
}
