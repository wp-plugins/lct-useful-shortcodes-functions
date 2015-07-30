<?php
add_action( 'avada_save_options', 'lct_avada_save_options' );
function lct_avada_save_options() {
	$Avada_options = get_option( 'Avada_options' );

	foreach( $Avada_options as $k => $Avada_option ) {
		if( strpos( $Avada_option, '//' ) !== false )
			$Avada_options[$k] = lct_remove_site_root( $Avada_option );
	}

	update_option( 'Avada_options', $Avada_options );
}
