<?php
/*
Plugin Name: BAW Force Plugin Updates
Description: You may need to reinstall any of your plugins, juste check the plugins, select "Update", and that's all!
Author: Julio Potier
Author URI: http://boiteaweb.fr
Plugin URI: http://boiteaweb.fr/force-plugin-updates-re-installez-vos-plugins-rapidement-8016.html
Version: 1.0
*/

if ( ! function_exists( '__brp_reinstall_plugin' ) ) {
	add_action( 'load-update.php', '__brp_reinstall_plugin', 0 );
	function __brp_reinstall_plugin() {
		//
		// if this is a bulk update
		if ( isset( $_GET['action'], $_GET['plugins'], $_GET['_wpnonce'] ) &&
			'update-selected' == $_GET['action'] &&
			wp_verify_nonce( $_GET['_wpnonce'], 'bulk-update-plugins' )
		) {
			// string to array
			$plugins = explode( ',', $_GET['plugins'] );
			//  hack the transient
			brp_hack_site_transient_update_plugins( $plugins );
		}

	}

	function brp_hack_site_transient_update_plugins( $plugin_paths ) {

		// get the transient
		$plugin_transient = get_site_transient( 'update_plugins' );

		// loop on each selected plugins
		foreach ( $plugin_paths as $plugin_path ) {
			// split folder and file
			list( $plugin_folder, $plugin_file ) = explode( '/', $plugin_path );
			// do the job only if we have the folder/slug
			if ( $plugin_file ) {
				// include plugin-install.php if plugins_api() does not exists
				if ( ! function_exists( 'plugins_api' ) ) {
					include( ABSPATH . '/wp-admin/includes/plugin-install.php' );
				}
				// call wp.org repo to get info anout this plugin
				$plugin_api = plugins_api( 'plugin_information', array( 'slug' => $plugin_folder, 'fields' => array( 'sections' => false, 'compatibility' => false, 'tags' => false ) ) );
				// make my own array
				$temp_array = array(
					'slug'        => $plugin_folder,
					'new_version' => $plugin_api->version,
					'package'     => $plugin_api->download_link
				);
				// cast array to object
				$temp_object = (object) $temp_array;
				// add/modify this plugin into the transient
				$plugin_transient->response[ $plugin_path ] = $temp_object;
			}
		}
		// set the modified transient
		set_site_transient( 'update_plugins', $plugin_transient );
	}
}
