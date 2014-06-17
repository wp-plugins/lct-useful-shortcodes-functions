<?php
//Print All _SERVER vars
if( ! function_exists( 'P_R_SERVER' ) ) {
	function P_R_SERVER( $return = false ) {
		if( $return )
			return P_R( $_SERVER, '$_SERVER', true );

		P_R( $_SERVER, '$_SERVER' );
	}
}


//[P_R_SERVER]
add_shortcode( 'P_R_SERVER', 'lct_sc_P_R_SERVER' );
function lct_sc_P_R_SERVER() {
	return P_R_SERVER( true );
}


//Print All _POST vars
if( ! function_exists( 'P_R_POST' ) ) {
	function P_R_POST( $return = false ) {
		if( $return )
			return P_R( $_POST, '$_POST', true );

		P_R( $_POST, '$_POST' );
	}
}


//[P_R_POST]
add_shortcode( 'P_R_POST', 'lct_sc_P_R_POST' );
function lct_sc_P_R_POST() {
	return P_R_POST( true );
}
