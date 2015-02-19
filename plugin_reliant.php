<?php
/**
 * Get lct_useful_settings from options table
 */
function lct_get_lct_useful_settings( $value = null ) {
	$lct_useful_settings = get_option( 'lct_useful_settings' );

	if( $value )
		return $lct_useful_settings[$value];

  	if( ! $lct_useful_settings )
  		$lct_useful_settings = array();

	return $lct_useful_settings;
}
