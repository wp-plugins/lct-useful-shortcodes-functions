<?php
//[lct_admin_onetime_script_run]
// Run a one-time script from an action hook in the theme folder's functions.php file
/* Use
add_action( "lct_admin_onetime_script_run", "lca_admin_onetime_script_run" );
function lca_admin_onetime_script_run() {
	echo 'works';

	return;
}
*/
add_shortcode( 'lct_admin_onetime_script_run', 'lct_admin_onetime_script_run' );
function lct_admin_onetime_script_run( $a ) {
	do_action( "lct_admin_onetime_script_run" );

	return;
}
