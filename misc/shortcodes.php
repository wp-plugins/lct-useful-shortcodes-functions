<?php
//Make sure shortcodes get processed
add_filter( 'the_content', 'do_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );


//[up]
add_shortcode( 'up', 'lct_up' );
function lct_up() {
	return wp_upload_dir()['baseurl'];
}


//[up_path]
add_shortcode( 'up_path', 'lct_up_path' );
function lct_up_path() {
	return wp_upload_dir()['basedir'];
}


//[url_site]
add_shortcode( 'url_site', 'lct_url_site' );
function lct_url_site() {
	return get_bloginfo( "url" );
}


//[url_theme]
add_shortcode( 'url_theme', 'lct_url_theme' );
function lct_url_theme() {
	return get_stylesheet_directory_uri();
}