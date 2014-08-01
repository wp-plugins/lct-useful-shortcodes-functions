<?php
/**
 * Get lct_useful_settings from options table
 */
function lct_get_lct_useful_settings( $value = null ) {
	if( $value )
		return get_option( 'lct_useful_settings' )[$value];

	return get_option( 'lct_useful_settings' );
}
