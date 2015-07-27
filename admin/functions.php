<?php
function lct_use_placeholders_instead_of_labels_array() {
	$return = lct_get_lct_useful_settings( 'use_placeholders_instead_of_labels' );

	if( ! $return )
		$return = [ 0 ];

	return $return;
}


function lct_store_gforms_array() {
	$return = lct_get_lct_useful_settings( 'store_gforms' );

	if( ! $return )
		$return = [ 0 ];

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
		$redirect_url = $redirect_to = home_url( "/" );

		if( function_exists( 'redirect_wrapper' ) )
			$redirect_url = redirect_wrapper( $redirect_to, '', $current_user );

		wp_redirect( $redirect_url );
		die();
	}
}


add_filter( 'script_loader_src', 'lct_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'lct_remove_script_version', 15, 1 );
function lct_remove_script_version( $src ) {
	$parts = explode( '?', $src );

	if( strpos( $src, 'fonts.googleapis.com/css?' ) !== false || strpos( $src, '/?' ) !== false )
		return $src;

	return $parts[0];
}


add_filter( 'wpseo_opengraph_site_name', 'lct_opengraph_site_name' );
function lct_opengraph_site_name( $title ) {
	if( lct_get_lct_useful_settings( 'hide_og_site_name' ) )
		return false;

	return $title;
}


add_action( 'wp_footer', 'lct_wp_footer_lct_get_user_agent_info', 99999 );
function lct_wp_footer_lct_get_user_agent_info() {
	if( ! lct_get_lct_useful_settings( 'print_user_agent_in_footer' ) )
		return;

	do_action( 'lct_get_user_agent_info', true, true );
}

add_action( 'lct_get_user_agent_info', 'lct_get_user_agent_info', 10, 2 );
function lct_get_user_agent_info( $print = null, $hide = null ) {
	$ready = 0;

	if( file_exists( '/home/_apps/browscap/Browscap.php' ) ) {
		require '/home/_apps/browscap/Browscap.php';
		$bc = new Browscap( '/home/_apps/browscap/cache' );
		$ready = 1;
	}

	if( ! $ready && file_exists( 'W:/wamp/apps/browscap/Browscap.php' ) ) {
		require 'W:/wamp/apps/browscap/Browscap.php';
		$bc = new Browscap( 'W:/wamp/apps/browscap/cache' );
		$ready = 1;
	}

	if( ! $ready && file_exists( '/home8/visartsa/_apps/browscap/Browscap.php' ) ) {
		require '/home8/visartsa/_apps/browscap/Browscap.php';
		$bc = new Browscap( '/home8/visartsa/_apps/browscap/cache' );
		$ready = 1;
	}

	if( ! $ready )
		return false;

	$getBrowser = $bc->getBrowser();

	if( $print ) {

		if( $hide ) {

			if( WP_CACHE ) {

				$before = '<pre id="browscap" style="display: none !important;">';
				$after = '</pre>';

			} else {

				$before = '<!-- ## id="browscap" ';
				$after = '-->';
			}

		} else {

			$before = '<pre>';
			$after = '</pre>';
		}

		echo $before;
		print_r( $getBrowser );
		echo $after;

		return false;
	}

	return $getBrowser;
}


function lct_get_dev_emails() {
	$emails = [
		'info@ircary.com',
		'cary@capital-designs.com',
		'cary@l-wconsulting.com',
		'dev@eetah.com'
	];

	return $emails;
}


function lct_is_user_a_dev( $emails = null ) {
	if( ! is_user_logged_in() )
		return false;

	if( empty( $emails ) )
		$emails = lct_get_dev_emails();

	$current_user = wp_get_current_user();

	foreach( $emails as $email ) {
		$user = get_user_by( 'email', $email );

		if( $current_user->ID == $user->ID )
			return true;
	}

	return false;
}


function lct_create_find_and_replace_arrays( $both_find_and_replace ) {
	$find = [ ];
	$replace = [ ];

	if( is_array( $both_find_and_replace ) ) {
		foreach( $both_find_and_replace as $k => $v ) {
			$find[] = $k;
			$replace[] = $v;
		}
	}

	return [
		'find'    => $find,
		'replace' => $replace
	];
}
