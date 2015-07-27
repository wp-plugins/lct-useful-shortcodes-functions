<?php
if( function_exists( 'acf_add_options_page' ) ) :

	acf_add_options_page( [
		'page_title' => 'LCT Useful ACF',
		'menu_title' => 'LCT Useful ACF',
		'menu_slug'  => 'lct_acf_op_main',
		'capability' => 'activate_plugins',
		'redirect'   => true
	] );


	acf_add_options_sub_page( [
		'title'      => 'Main Settings',
		'menu'       => 'Main Settings',
		'slug'       => 'lct_acf_op_main_settings',
		'parent'     => 'lct_acf_op_main',
		'capability' => 'activate_plugins'
	] );

	include( 'lct_acf_op_main_settings_groups.php' );

	include( 'lct_acf_op_main_settings.php' );


	acf_add_options_sub_page( [
		'title'      => 'Fixes and Cleanups',
		'menu'       => 'Fixes and Cleanups',
		'slug'       => 'lct_acf_op_main_fixes_cleanups',
		'parent'     => 'lct_acf_op_main',
		'capability' => 'activate_plugins'
	] );

	include( 'lct_acf_op_main_fixes_cleanups_groups.php' );

	include( 'lct_acf_op_main_fixes_cleanups.php' );

endif;
