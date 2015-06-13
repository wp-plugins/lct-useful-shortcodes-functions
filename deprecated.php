<?php
/**
 * I don't like to use up_root anymore, but it may be used on an old site
 */
add_shortcode( 'up_root', 'lct_path_up' );


/**
 * I have no idea what this was for and I don't want it do be used.
 * Originally from: lct-useful-shortcodes-functions/display/options.php
 *
 * @param $hide
 * @param $type
 * @param $v
 *
 * @return array|bool
 */
function lct_select_options_meta_key( $hide, $type, $v ) {
	if( ! $v['options_tax'] )
		return false;

	$meta_keys = explode( ",", ltm_get_ltm_settings( 'meta_keys_' . $v['options_tax'] ) );

	$select_options = array();

	if( ! $hide )
		$select_options[] = array( 'label' => '---', 'value' => '' );

	foreach( $meta_keys as $meta_key ) {
		$select_options[] = array( 'label' => trim( $meta_key ), 'value' => trim( $meta_key ) );
	}

	return $select_options;
}
