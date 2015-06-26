<?php
/**
 * For use in widget logic plugin
 *
 * Checks if the value is in the page's permalink
 */
function lct_is_in_url( $search_this_in_url ) {
	if( empty( $search_this_in_url ) )
		return false;

	if( strpos( get_permalink(), $search_this_in_url ) !== false )
		return true;
	else
		return false;
}
