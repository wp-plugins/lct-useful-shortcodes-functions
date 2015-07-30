<?php
add_action( 'init', 'lct_misc_shortcodes_init' );
/**
 * Used to route the lct_wpautop_disable AND lct_wpautop_disable_new functions
 */
function lct_misc_shortcodes_init() {

	//choose which function to use lct_wpautop_disable() OR lct_wpautop_disable_new()
	switch( lct_get_lct_useful_settings( 'choose_a_raw_tag_option' ) ) {
		case 'wpautop':
			break;

		case 'off':
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'wptexturize' );
			break;

		case 'old':
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'wptexturize' );
			add_filter( 'the_content', 'lct_wpautop_disable', 99 );
			break;

		case 'new':
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'wptexturize' );
			add_filter( 'the_content', 'lct_wpautop_disable_new', 1 );
			break;

		default:
	}
}


//Make sure the shortcodes get processed
//TODO: cs - get this in an action - 7/29/2015 2:12 PM
add_filter( 'the_content', 'do_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_execphp', 'do_shortcode' );


add_shortcode( 'up', 'lct_url_up' );
add_shortcode( 'url_up', 'lct_url_up' );
/**
 * [url_up] || [up]
 * Get the site's upload directory
 * @return mixed
 */
function lct_url_up() {
	$wp_upload_dir = wp_upload_dir();

	return $wp_upload_dir['baseurl'];
}


add_shortcode( 'up_path', 'lct_path_up' );
add_shortcode( 'path_up', 'lct_path_up' );
/**
 * [path_up]
 * Get the site's upload directory path
 * @return mixed
 */
function lct_path_up() {
	$wp_upload_dir = wp_upload_dir();

	return $wp_upload_dir['basedir'];
}


add_shortcode( 'url_site', 'lct_url_site' );
/**
 * [url_site]
 * Get the site's URL
 * @return string|void
 */
function lct_url_site() {
	return get_bloginfo( "url" );
}


add_shortcode( 'url_root_site', 'lct_url_root_site' );
/**
 * [url_root_site]
 * Get the site's root URL
 * @return string
 */
function lct_url_root_site() {
	return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
}


add_shortcode( 'path_site', 'lct_path_site' );
/**
 * [path_site]
 * Get the site's URL
 * @return mixed
 */
function lct_path_site() {
	return $_SERVER['DOCUMENT_ROOT'];
}


add_shortcode( 'url_site_wp', 'lct_url_site_wp' );
/**
 * [url_site_wp]
 * Get the site's Wordpress URL
 * @return string
 */
function lct_url_site_wp() {
	return get_site_url();
}


add_shortcode( 'path_site_wp', 'lct_path_site_wp' );
/**
 * [path_site_wp]
 * Get the site's URL
 * @return string
 */
function lct_path_site_wp() {
	if( trim( get_site_url(), '/' ) != trim( get_bloginfo( "url" ), '/' ) )
		return $_SERVER['DOCUMENT_ROOT'] . rtrim( str_replace( trim( get_bloginfo( "url" ), '/' ), "", trim( get_site_url(), '/' ) ) );

	return $_SERVER['DOCUMENT_ROOT'];
}


add_shortcode( 'url_theme', 'lct_url_theme' );
/**
 * [url_theme]
 * Get the child theme's URL
 * @return string
 */
function lct_url_theme() {
	return get_stylesheet_directory_uri();
}


add_shortcode( 'path_theme', 'lct_path_theme' );
/**
 * [path_theme]
 * Get the child theme's path
 * @return string
 */
function lct_path_theme() {
	return get_theme_root() . "/" . get_stylesheet();
}


add_shortcode( 'url_plugin', 'lct_url_plugin' );
/**
 * [url_plugin]
 * Get the plugin directory URL
 * @return array|string
 */
function lct_url_plugin() {
	global $g_lct;

	$path = explode( '/', rtrim( str_replace( '\\', '/', $g_lct->plugin_dir_url ), '/' ) );
	array_pop( $path );
	$path = implode( '/', $path );

	return $path;
}


add_shortcode( 'path_plugin', 'lct_path_plugin' );
/**
 * [path_plugin]
 * Get the plugin directory path
 * @return array|string
 */
function lct_path_plugin() {
	global $g_lct;

	$path = explode( '/', rtrim( str_replace( '\\', '/', $g_lct->plugin_dir_path ), '/' ) );
	array_pop( $path );
	$path = implode( '/', $path );

	return $path;
}


add_shortcode( 'url_theme_parent', 'lct_url_theme_parent' );
/**
 * [url_theme_parent]
 * Get the parent theme's URL
 * @return string
 */
function lct_url_theme_parent() {
	return get_template_directory_uri();
}


add_shortcode( 'path_theme_parent', 'lct_path_theme_parent' );
/**
 * [path_theme_parent]
 * Get the parent theme's path
 * @return string
 */
function lct_path_theme_parent() {
	return get_theme_root() . "/" . get_template();
}


add_shortcode( 'clear', 'lct_clear' );
/**
 * [clear style=""]
 * add a clear div
 *
 * @param $a
 *
 * @return bool|string
 */
function lct_clear( $a ) {
	extract(
		shortcode_atts(
			[
				'style' => '',
			],
			$a
		)
	);

	if( empty( $style ) )
		return false;

	if( $style )
		$r = '<div class="clear" style="' . $style . '"></div>';
	else
		$r = '<div class="clear"></div>';

	return $r;
}


/**
 * [raw]Content to disable wpautop[/raw]
 *
 * @param $content
 *
 * @return mixed|string
 */
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

	$new_content = str_replace( [ "[raw]", "[/raw]" ], "", $new_content );

	return $new_content;
}


/**
 * [raw]Content to disable wpautop[/raw]
 *
 * @param $content
 *
 * @return mixed|string
 */
function lct_wpautop_disable_new( $content ) {
	if( strpos( $content, '[raw]' ) === false )
		return wptexturize( wpautop( $content ) );

	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

	foreach( $pieces as $piece ) {
		if( preg_match( $pattern_contents, $piece, $matches ) )
			$new_content .= $matches[1];
		else
			$new_content .= wptexturize( wpautop( $piece ) );
	}

	$new_content = str_replace( [ "[raw]", "[/raw]" ], "", $new_content );

	return $new_content;
}


add_shortcode( 'lct_auto_logout', 'lct_auto_logout' );
/**
 * [lct_auto_logout]
 */
function lct_auto_logout() {
	if( is_user_logged_in() ) {
		$time = time();

		echo '<a id="logout' . $time . '" href="' . wp_logout_url() . '">Logout</a>';

		$script = '<script>
			document.getElementById("logout' . $time . '").click();
	    </script>';
		echo $script;

		die();
	}
}


add_shortcode( 'lct_jquery_mask', 'lct_jquery_mask' );
/**
 * [lct_jquery_mask]
 * Add digit mask
 */
function lct_jquery_mask() {
	$g_lct = new g_lct;

	wp_enqueue_script( 'lct_jquery_mask', $g_lct->plugin_dir_url . 'assets/js/jquery_mask.js', [ 'jquery' ] );
}


add_shortcode( 'lct_preload', 'lct_preload' );
/**
 * [lct_preload]
 * preload an image or set of images
 *
 * @param $a
 *
 * @return string
 */
function lct_preload( $a ) {
	extract(
		shortcode_atts(
			[
				'css'    => '',
				'js'     => '',
				'images' => '',
			],
			$a
		)
	);

	$time = current_time( 'timestamp', 1 );

	$html = '';
	$html .= '<div id="lct_preload" style="position: fixed;top: 0;left: 0;height: 1px;width: 100px;z-index:9999;opacity: 0.1;"></div>';
	$html .= '<script>';
	$html .= 'jQuery(window).load( function() {';
	$html .= 'setTimeout(function() {';
	if( ! empty( $css ) ) {
		$tmp = explode( ',', $css );
		foreach( $tmp as $t ) {
			$html .= 'xhr = new XMLHttpRequest();';
			$html .= 'xhr.open(\'GET\', ' . $t . ');';
			$html .= 'xhr.send(\'\');';
		}
	}

	if( ! empty( $js ) ) {
		$tmp = explode( ',', $js );
		foreach( $tmp as $t ) {
			$html .= 'xhr = new XMLHttpRequest();';
			$html .= 'xhr.open(\'GET\', ' . $t . ');';
			$html .= 'xhr.send(\'\');';
		}
	}

	if( ! empty( $images ) ) {
		$tmp = explode( ',', $images );
		$i = 1;
		foreach( $tmp as $t ) {
			$html .= 'jQuery("#lct_preload").append(\'<img id="image_' . $time . '_' . $i . '" src="' . $t . '" style="height: 1px;width: 1px;"></div>\');';
			$i++;
		}
	}
	$html .= '}, 1000 );';

	$html .= 'setTimeout(function() {';
	$html .= 'jQuery("#lct_preload").hide();';
	$html .= '}, 1200 );';
	$html .= '});';
	$html .= '</script>';

	return $html;
}
