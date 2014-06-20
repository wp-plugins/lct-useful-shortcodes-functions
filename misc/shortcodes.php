<?php
//Make sure the shortcodes get processed
add_filter( 'the_content', 'do_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_execphp', 'do_shortcode' );


//[css page="" write=""]
// Grab some custom css when this shortcode is called
add_shortcode( 'css', 'lct_css' );
function lct_css( $a ) {
	$plugin_dir_path = lct_path_up() . '/lct/';
	$plugin_dir_url = lct_url_up() . '/lct/';
	extract(
		shortcode_atts(
			array(
				'page' => trim( $_SERVER['REQUEST_URI'], "/" ),
				'write' => false,
			),
			$a
		)
	);

	$file = 'css/' . $page . '.css';

	if( ! file_exists( $plugin_dir_path . $file ) ) return;

	if( $write ) {
		$r = '<style>';
		$r .= file_get_contents( $plugin_dir_path . $file );
		$r .= '</style>';
	}else
		$r = '<link rel="stylesheet" type="text/css" href="' . $plugin_dir_url . $file . '">';

	return $r;
}


//[js page="" write=""]
// Grab some custom js when this shortcode is called
add_shortcode( 'js', 'lct_js' );
function lct_js( $a ) {
	$plugin_dir_path = lct_path_up() . '/lct/';
	$plugin_dir_url = lct_url_up() . '/lct/';
	extract(
		shortcode_atts(
			array(
				'page' => trim( $_SERVER['REQUEST_URI'], "/" ),
				'write' => false,
			),
			$a
		)
	);

	$file = 'js/' . $page . '.js';

	if( ! file_exists( $plugin_dir_path . $file ) ) return;

	if( $write ) {
		$r = '<script>';
		$r .= file_get_contents( $plugin_dir_path . $file );
		$r .= '</script>';
	}else
		$r = '<script type="text/javascript" src="' . $plugin_dir_url . $file . '"></script>';

	return $r;
}


//[custom_php page=""]
// Grab some custom php when this shortcode is called
add_shortcode( 'custom_php', 'lct_php' );
function lct_php( $a ) {
	$plugin_dir_path = lct_path_up() . '/lct/';
	extract(
		shortcode_atts(
			array(
				'page' => trim( $_SERVER['REQUEST_URI'], "/" ),
			),
			$a
		)
	);

	$file = 'php/' . $page . '.php';

	if( file_exists( $plugin_dir_path . $file ) )
		return file_get_contents( $plugin_dir_path . $file );

	return ;
}


//[get_test page=""]
// Grab a test page when this shortcode is called
add_shortcode( 'get_test', 'lct_get_test' );
function lct_get_test( $a ) {
	$plugin_dir_path = lct_path_up() . '/lct/';
	extract(
		shortcode_atts(
			array(
				'page' => 't',
			),
			$a
		)
	);

	$file = $page . '.php';

	if( file_exists( $plugin_dir_path . $file ) ){
		$r = '[raw]' . file_get_contents( $plugin_dir_path . $file ) . '[/raw]';
		$r = str_replace("[self]", $plugin_dir_path . $file, $r );
		return $r;
	}
}


//[url_up] || [up]
//Get the site's upload directory
add_shortcode( 'up', 'lct_url_up' );
add_shortcode( 'url_up', 'lct_url_up' );
function lct_url_up() {
	return wp_upload_dir()['baseurl'];
}


//[path_up]
//Get the site's upload directory path
add_shortcode( 'up_path', 'lct_path_up' );
add_shortcode( 'path_up', 'lct_path_up' );
function lct_path_up() {
	return wp_upload_dir()['basedir'];
}


//[url_site]
//Get the site's URL
add_shortcode( 'url_site', 'lct_url_site' );
function lct_url_site() {
	return get_bloginfo( "url" );
}


//[path_site]
//Get the site's URL
add_shortcode( 'path_site', 'lct_path_site' );
function lct_path_site() {
	return $_SERVER['DOCUMENT_ROOT'];
}


//[url_site_wp]
//Get the site's Wordpress URL
add_shortcode( 'url_site_wp', 'lct_url_site_wp' );
function lct_url_site_wp() {
	return get_site_url();
}


//[path_site_wp]
//Get the site's URL
add_shortcode( 'path_site_wp', 'lct_path_site_wp' );
function lct_path_site_wp() {
	if( trim( get_site_url(), '/' ) != trim( get_bloginfo( "url" ), '/' ) )
		return $_SERVER['DOCUMENT_ROOT'] . rtrim( str_replace( trim( get_bloginfo( "url" ), '/' ), "", trim( get_site_url(), '/' ) ) );
	return $_SERVER['DOCUMENT_ROOT'];
}


//[url_theme]
//Get the child theme's URL
add_shortcode( 'url_theme', 'lct_url_theme' );
function lct_url_theme() {
	return get_stylesheet_directory_uri();
}


//[path_theme]
//Get the child theme's path
add_shortcode( 'path_theme', 'lct_path_theme' );
function lct_path_theme() {
	return get_theme_root() . "/" . get_stylesheet();
}


//[url_theme_parent]
//Get the parent theme's URL
add_shortcode( 'url_theme_parent', 'lct_url_theme_parent' );
function lct_url_theme_parent() {
	return get_template_directory_uri();
}


//[path_theme_parent]
//Get the parent theme's path
add_shortcode( 'path_theme_parent', 'lct_path_theme_parent' );
function lct_path_theme_parent() {
	return get_theme_root() . "/" . get_template();
}


//[clear style=""]
//add a clear div
add_shortcode( 'clear', 'lct_clear' );
function lct_clear( $a ) {
	extract(
		shortcode_atts(
			array(
				'style' => '',
			),
			$a
		)
	);

	if( $style )
		$r = '<div class="clear" style="' . $style . '"></div>';
	else
		$r = '<div class="clear"></div>';

	return $r;
}


//[copyyear]
//Get the current Year i.e. 2014
add_shortcode( 'copyyear', 'lct_copyyear' );
function lct_copyyear() {
	return date( 'Y' );
}


//[raw]Content to disable wpautop[/raw]
//Disable wpautop when you use [raw] tags
if( ! function_exists( 'wpautop_Disable' ) ) {
	function lct_wpautop_disable( $content ) {
		$new_content = '';
		$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

		foreach( $pieces as $piece ) {
			if( preg_match( $pattern_contents, $piece, $matches ) ) {
				$new_content .= $matches[1];
			} else {
				$new_content .= wptexturize( wpautop( $piece ) );
			}
		}

		$new_content = str_replace(array("[raw]", "[/raw]"), "", $new_content);

		return $new_content;
	}
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'wptexturize' );
	add_filter( 'the_content', 'lct_wpautop_disable', 99 );
}
