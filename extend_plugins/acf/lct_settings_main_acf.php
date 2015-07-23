<?php
if( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( [
		'page_title' => 'LCT Useful ACF',
		'menu_title' => 'LCT Useful ACF',
		'menu_slug'  => 'lct_settings_main_acf',
		'capability' => 'activate_plugins',
		'redirect'   => true
	] );


	acf_add_options_sub_page( [
		'title'      => 'Main Settings',
		'menu'       => 'Main Settings',
		'slug'       => 'lct_settings_main_acf_settings',
		'parent'     => 'lct_settings_main_acf',
		'capability' => 'activate_plugins'
	] );

	include( 'lct_settings_main_acf_settings.php' );


	acf_add_options_sub_page( [
		'title'      => 'Fixes and Cleanups',
		'menu'       => 'Fixes and Cleanups',
		'slug'       => 'lct_settings_main_acf_fixes_and_cleanups',
		'parent'     => 'lct_settings_main_acf',
		'capability' => 'activate_plugins'
	] );

	include( 'lct_settings_main_acf_fixes_and_cleanups.php' );
}
