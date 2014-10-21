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

	if( strpos( $src, 'fonts.googleapis.com/css?' ) !== false )
		return $src;

	return $parts[0];
}


add_filter( 'wpseo_opengraph_site_name', 'lct_opengraph_site_name' );
function lct_opengraph_site_name( $title ) {
	if( lct_get_lct_useful_settings( 'hide_og_site_name' ) )
		return false;

	return $title;
}


add_action( 'wp_footer', 'do_wp_footer_lct_get_user_agent_info', 99999 );
function do_wp_footer_lct_get_user_agent_info() {
	if( ! lct_get_lct_useful_settings( 'print_user_agent_in_footer' ) )
		return;

	do_action( 'lct_get_user_agent_info', true, true );
}

add_action( 'lct_get_user_agent_info', 'lct_get_user_agent_info', 10, 2 );
function lct_get_user_agent_info( $print = null, $hide = null ) {
	if( file_exists( '/home/_apps/browscap/Browscap.php' ) ) {
		require '/home/_apps/browscap/Browscap.php';
		$bc = new Browscap('/home/_apps/browscap/cache');
		$ready = 1;
	}

	if( file_exists( 'C:/s/apps/browscap/Browscap.php' ) ) {
		require 'C:/s/apps/browscap/Browscap.php';
		$bc = new Browscap('C:/s/apps/browscap/cache');
		$ready = 1;
	}

	if( ! $ready )
		return;

	$getBrowser = $bc->getBrowser();

	if( $print ) {

		if( $hide ) {

			if( WP_CACHE ) {

				$before = '<pre style="display: none !important;">';
				$after = '<pre>';

			} else {

				$before = '<!--';
				$after = '-->';
			}

		} else {

			$before = '<pre>';
			$after = '<pre>';
		}

		echo $before;
			print_r( $getBrowser );
		echo $after;

		return;
	}

	return $getBrowser;
}
