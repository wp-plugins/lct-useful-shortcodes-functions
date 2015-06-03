<?php
//disregard siteurl value
if( LCT_DEV == 1 ) {
	add_filter( 'option_siteurl', 'lct_clean_sb_url' );
	add_filter( 'option_home', 'lct_clean_sb_url' );
	function lct_clean_sb_url( $url ) {
		$tmp = explode( '/', $url );
		$tmp[2] = $_SERVER['HTTP_HOST'];

		$new_url = implode( '/', $tmp );

		return $new_url;
	}
}


//Check if a page is a blogroll or single post.
function is_blog() {
	global $post;
	$post_type = get_post_type( $post );

	return ( ( is_home() || is_archive() || is_single() ) && ( $post_type == 'post' ) ) ? true : false;
}


if( ! function_exists( 'the_slug' ) ) {
	function the_slug( $post_id = null, $slash = true ) {
		if( ! $post_id ) return;

		$post_data = get_post( $post_id, ARRAY_A );

		if( ! $slash )
			return $post_data['post_name'];

		return $post_data['post_name'] . '/';
	}
}


//execute php in the text widget
add_filter( 'widget_text', 'lct_execute_php', 100 );
function lct_execute_php( $html ) {
	if( strpos( $html, "<" . "?php" ) !== false ) {
		ob_start();
		eval( "?" . ">" . $html );
		$html = ob_get_contents();
		ob_end_clean();
	}
	return $html;
}



add_filter( 'post_thumbnail_html', 'lct_remove_thumbnail_dimensions', 10, 1 );
add_filter( 'image_send_to_editor', 'lct_remove_thumbnail_dimensions', 10, 1 );
/**
 * Alter the html input when adding media
 *
 * @param $html
 * @param $id
 * @param $caption
 * @param $title
 * @param $align
 * @param $url
 * @param $size
 * @param $alt
 *
 * @return mixed
 */
function lct_remove_thumbnail_dimensions( $html ) {
	//remove width & height tags from img
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );

	return $html;
}


add_filter( 'image_send_to_editor', 'lct_remove_site_root', 10, 1 );
/**
 * Alter the html input when adding media
 *
 * @param $html
 * @param $id
 * @param $caption
 * @param $title
 * @param $align
 * @param $url
 * @param $size
 * @param $alt
 *
 * @return mixed
 */
function lct_remove_site_root( $html ) {
	//remove the root of the url
	$root_site = lct_url_root_site();
	$root_site_without_scheme = str_replace( [ 'http:', 'https:' ], '', $root_site );

	$find = [
		$root_site,
		$root_site_without_scheme,
	];

	$html = str_replace( $find, '', $html );

	return $html;
}


//Update the edit button on posts and pages
add_filter( 'edit_post_link', 'lct_remove_edit_post_link' );
function lct_remove_edit_post_link( $link ) {
	//return '<p><i class="uk-icon-pencil"></i> '. $link .'</p>';
	return;
}


//Fix Multisite plugins_url issue
if( ! function_exists('lct_domain_mapping_plugins_uri') && function_exists('domain_mapping_plugins_uri') ) {
	remove_filter( 'plugins_url', 'domain_mapping_plugins_uri', 1 );
	add_filter( 'plugins_url', 'lct_domain_mapping_plugins_uri', 1 );
	function lct_domain_mapping_plugins_uri( $full_url, $path=NULL, $plugin=NULL ) {
		$pos = stripos( $full_url, PLUGINDIR );
		if($pos === false)
			return $full_url;
		else
			return get_option( 'siteurl' ) . substr( $full_url, $pos - 1 );
	}
}


/**
 * Allow html tags in widget titles
 */
add_filter( 'widget_title', 'lct_html_widget_title', 999 );
function lct_html_widget_title( $title ) {
	$title = str_replace( '[', '<', $title );
	$title = str_replace( '[/', '</', $title );
	$title = str_replace( ']', '>', $title );
	$title = str_replace( '/]', '/>', $title );

	return html_entity_decode( $title );
}


//Set the timezone to the logged in users default Timezone
add_action( 'init', 'set_user_timezone' );
function set_user_timezone( $user_ID = null ) {
	if( ! $user_ID )
		$user_ID = get_current_user_id();

	if( ! $user_ID ) {
		date_default_timezone_set( get_option( 'timezone_string' ) );
		return get_option( 'timezone_string' );
	}

	$npl_user_timezone = get_user_meta( $user_ID, 'npl_user_timezone', true );
	if( $npl_user_timezone ) {
		date_default_timezone_set( $npl_user_timezone );
		return $npl_user_timezone;
	}

	date_default_timezone_set( get_option( 'timezone_string' ) );
	return get_option( 'timezone_string' );
}


/**
 * Get a single value from a WP Term
 *
 * @term_id int
 * @tax string - The terms taxonomy
 * @value string - The value you want to retrieve
 *
 * Possible values to call
 * @name
 * @slug
 * @term_group
 * @term_order
 * @term_taxonomy_id
 * @taxonomy
 * @description
 * @parent
 * @count
 * @filter
 */
function lct_get_term_value( $term_id, $tax="lct_option" , $key=null, $output="OBJECT", $filter="raw" ) {
	$term = get_term( $term_id, $tax, $output, $filter );

	if( ! $term ) return 0;

	if( $key )
		return $term->$key;

	return $term;
}

function lct_get_term_meta( $term_id, $tax="lct_option" , $key=null, $output="OBJECT", $filter="raw" ) {
	if( ! $term_id || ! $tax ) return;

	$tax_term_id = get_option( $tax . "_" . $term_id );

	if( $key )
		return $tax_term_id[$key];
	else
		return $tax_term_id;
}


function lct_get_parent_term_value( $term_id, $tax, $key = null, $output="OBJECT", $filter="raw" ) {
	$term = get_term( $term_id, $tax, $output, $filter );

	$parent_term = get_term( $term->parent, $tax, $output, $filter );

	if( ! $parent_term ) return 0;

	if( $key )
		return $parent_term->$key;

	return $parent_term;
}


function lct_get_parent_term_meta( $term_id = null, $tax = null, $key = null, $output="OBJECT", $filter="raw"  ) {
	if( ! $term_id || ! $tax ) return;

	$term = get_term( $term_id, $tax, $output, $filter );

	$parent_term_id = $term->parent;

	$tax_parent_term_id = get_option( $tax . "_" . $parent_term_id );

	if( $key )
		return $tax_parent_term_id[$key];
	else
		return $tax_parent_term_id;
}


function lct_clean_number_for_math( $number ) {
	$f = ',';
	$r = '';
	$new_number = floatval( preg_replace("/[^-0-9\.]/", "", $number ) );

	return (float) $new_number;
}


add_filter( 'wpseo_opengraph_image', 'lct_opengraph_single_image_filter' );
function lct_opengraph_single_image_filter( $val ) {
	$val = str_replace( '//' . $_SERVER["HTTP_HOST"], '', $val );

	return $val;
}


//Remove front-end admin bar from non-admin users
add_filter( 'show_admin_bar', 'lct_remove_admin_bar', 11 );
function lct_remove_admin_bar() {
	if( ! current_user_can( 'administrator' ) && ! is_admin() )
		return false;
	else
		return true;
}


function lct_excerpt_of_string( $content, $maxchars ) {
	$content = substr( $content, 0, $maxchars );
	$pos = strrpos( $content, " " );

	if( $pos > 0 )
		$content = substr( $content, 0, $pos );

	return $content;
}
