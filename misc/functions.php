<?php
//Check if a page is a blogroll or single post.
function is_blog() {
	global $post;
	$post_type = get_post_type( $post );

	return ( ( is_home() || is_archive() || is_single() ) && ( $post_type == 'post' ) ) ? true : false;
}
