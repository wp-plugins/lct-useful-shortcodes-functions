<?php
/**
 * For use in widget logic plugin
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


/**
 * check an array with strpos
 *
 * @param $haystack
 * @param $needle
 *
 * @return bool
 */
function strpos_array( $haystack, $needle ) {
	if( is_array( $needle ) ) {
		foreach( $needle as $need ) {
			if( strpos( $haystack, $need ) !== false ) {
				return true;
			}
		}
	} else {
		if( strpos( $haystack, $needle ) !== false ) {
			return true;
		}
	}

	return false;
}
