<?php
/**
 * I don't like to use up_root anymore, but it may be used on an old site
 * _deprecated_argument( __FUNCTION__, '4.3.1' );
 */
add_shortcode( 'up_root', 'lct_path_up' );


/**
 * I have no idea what this was for and I don't want it do be used.
 * Originally from: lct-useful-shortcodes-functions/display/options.php
 *
 * @param $hide
 * @param $type
 * @param $v
 *
 * @return array|bool
 */
function lct_select_options_meta_key( $hide, $type, $v ) {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	if( ! $v['options_tax'] )
		return false;

	$meta_keys = explode( ",", ltm_get_ltm_settings( 'meta_keys_' . $v['options_tax'] ) );

	$select_options = [ ];

	if( ! $hide )
		$select_options[] = [ 'label' => '---', 'value' => '' ];

	foreach( $meta_keys as $meta_key ) {
		$select_options[] = [ 'label' => trim( $meta_key ), 'value' => trim( $meta_key ) ];
	}

	return $select_options;
}


add_shortcode( 'custom_php', 'lct_php' );
/**
 * [custom_php page=""]
 * Grab some custom php when this shortcode is called
 *
 * @param $a
 *
 * @return bool|string
 */
function lct_php( $a ) {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	$plugin_dir_path = lct_path_up() . '/lct/';
	extract(
		shortcode_atts(
			[
				'page' => trim( $_SERVER['REQUEST_URI'], "/" ),
			],
			$a
		)
	);

	if( empty( $page ) )
		return false;

	$file = 'php/' . $page . '.php';

	if( file_exists( $plugin_dir_path . $file ) )
		return file_get_contents( $plugin_dir_path . $file );

	return false;
}


add_shortcode( 'get_test', 'lct_get_test' );
/**
 * @param string $deprecated
 *
 * @return string
 */
function lct_get_test( $deprecated = '' ) {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	return 'Deprecated shortcode... Don\'t use it anymore.';
}


add_shortcode( 'copyyear', 'lct_copyyear' );
/**
 * [copyyear]
 * Get the current Year i.e. 2014
 * @return bool|string
 */
function lct_copyyear() {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	return date( 'Y' );
}


add_shortcode( 'css', 'lct_css_uploads_dir' );
/**
 * [css page="" write=""]
 * Grab some custom css when this shortcode is called
 *
 * @param $a
 *
 * @return bool|string
 */
function lct_css_uploads_dir( $a ) {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	$plugin_dir_path = lct_path_up() . '/lct/';
	$plugin_dir_url = lct_url_up() . '/lct/';
	extract(
		shortcode_atts(
			[
				'page'  => trim( $_SERVER['REQUEST_URI'], "/" ),
				'write' => false,
			],
			$a
		)
	);

	if( empty( $page ) )
		return false;

	$file = 'css/' . $page . '.css';

	$full_path = $plugin_dir_path . $file;
	$full_url = $plugin_dir_url . $file;

	if( ! file_exists( $full_path ) ) {
		global $g_lct;

		$full_path = $g_lct->plugin_dir_path . 'lct/' . $file;
		$full_url = $g_lct->plugin_dir_url . 'lct/' . $file;

		if( ! file_exists( $full_path ) )
			return false;
	}

	if( ! empty( $write ) ) {
		$r = '<style>';
		$r .= file_get_contents( $full_path );
		$r .= '</style>';
	} else
		$r = '<link rel="stylesheet" type="text/css" href="' . $full_url . '">';

	return $r;
}


add_shortcode( 'js', 'lct_js_uploads_dir' );
/**
 * [js page="" write=""]
 * Grab some custom js when this shortcode is called
 *
 * @param $a
 *
 * @return bool|string
 */
function lct_js_uploads_dir( $a ) {
	_deprecated_argument( __FUNCTION__, '4.3.1' );

	$plugin_dir_path = lct_path_up() . '/lct/';
	$plugin_dir_url = lct_url_up() . '/lct/';
	extract(
		shortcode_atts(
			[
				'page'  => trim( $_SERVER['REQUEST_URI'], "/" ),
				'write' => false,
			],
			$a
		)
	);

	if( empty( $page ) )
		return false;

	$file = 'js/' . $page . '.js';

	$full_path = $plugin_dir_path . $file;
	$full_url = $plugin_dir_url . $file;

	if( ! file_exists( $full_path ) ) {
		global $g_lct;

		$full_path = $g_lct->plugin_dir_path . 'lct/' . $file;
		$full_url = $g_lct->plugin_dir_url . 'lct/' . $file;

		if( ! file_exists( $full_path ) )
			return false;
	}

	if( ! empty( $write ) ) {
		$r = '<script>';
		$r .= file_get_contents( $full_path );
		$r .= '</script>';
	} else
		$r = '<script type="text/javascript" src="' . $full_url . '"></script>';

	return $r;
}
