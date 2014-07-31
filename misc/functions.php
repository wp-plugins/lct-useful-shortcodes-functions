<?php
//disregard siteurl value
if( LCT_DEV == 1 ) {
	add_filter( 'option_siteurl', 'lct_clean_siteurl' );
	function lct_clean_siteurl( $url ) {
		return "http://" . $_SERVER[HTTP_HOST] . '/x';
	}

	add_filter( 'option_home', 'lct_clean_home' );
	function lct_clean_home( $url ) {
		return "http://" . $_SERVER[HTTP_HOST];
	}
}


//Check if a page is a blogroll or single post.
function is_blog() {
	global $post;
	$post_type = get_post_type( $post );

	return ( ( is_home() || is_archive() || is_single() ) && ( $post_type == 'post' ) ) ? true : false;
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


//remove width & height tags from img
add_filter( 'post_thumbnail_html', 'lct_remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'lct_remove_thumbnail_dimensions', 10 );
function lct_remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}


//Update the edit button on posts and pages
add_filter( 'edit_post_link', 'lct_remove_edit_post_link' );
function lct_remove_edit_post_link( $link ) {
	//return '<p><i class="uk-icon-pencil"></i> '. $link .'</p>';
	return;
}


//Fix Multisite plugins_url issue
if( ! function_exists('lct_domain_mapping_plugins_uri') && function_exists('domain_mapping_plugins_uri') ){
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
