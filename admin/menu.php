<?php
add_action( 'admin_menu', 'lct_useful_menu' );
function lct_useful_menu() {
	add_object_page( 'LCT Useful', 'LCT Useful', 'manage_options', 'lct_useful_settings', 'lct_useful_settings' );
	add_submenu_page( 'lct_useful_settings', 'Cleanup Guid Fields', 'Cleanup Guid Fields', 'manage_options', 'lct_cleanup_guid', 'lct_cleanup_guid' );
}


add_action( 'admin_init', 'lct_register_lct_useful_settings' );
function lct_register_lct_useful_settings() {
	register_setting( 'lct_useful_settings', 'lct_useful_settings' );

	$term_meta = lct_get_lct_useful_settings();
	$defaults = lct_term_meta_defaults();

	$defaults = array_merge( $defaults, $term_meta );

	update_option( 'lct_useful_settings', $defaults ); ?>

	<style>
		li [href*="lct_cleanup_guid"]{
			display: none !important;
		}
	</style>
<?php }


function lct_useful_settings() {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( __( 'You do not have sufficient permissions.' ) ); ?>

	<form method="post" action="options.php">
		<?php
		settings_fields( 'lct_useful_settings' );
		$term_meta = lct_get_lct_useful_settings();
		lct_term_meta_default_check( $term_meta );
		?>


		<h3>General Options</h3>
		<table class="form-table"><tbody>
			<?php
			$v = "Enable_Front_css";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "Enable front.css" ]
			);

			$v = "disable_avada_css";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "Disable avada.css" ]
			);

			$v = "Default_Taxonomy";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[
					"label" => "Default Taxonomy to Use for lct_select_options();",
					"label_override" => true,
					"lct_select_options" => "get_taxonomies",
					"options_default" => false
				]
			);

			$v = "print_user_agent_in_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "choose_a_raw_tag_option";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[
					"label" => $v,
					"lct_select_options" => "get_raw_prefs",
					"options_default" => false,
					"options_hide" => true
				]
			);
			?>
			</tbody></table>
		<p>&nbsp;</p>


		<h3>Gravity Forms</h3>
		<table class="form-table"><tbody>
			<?php
			$v = "enable_cj_spam_check";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "enable_cj_spam_check_email";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "use_placeholders_instead_of_labels";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkboxgroup",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v, "lct_select_options" => "gravity_forms", "options_default" => false, "options_hide" => true ]
			);

			$v = "use_gforms_css_tweaks";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "gforms_css_tweaks_gform_footer_margin";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "gform_footer Margin", "label_override" => true ]
			);

			$v = "gforms_css_tweaks_gform_footer_padding";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "gform_footer Padding", "label_override" => true ]
			);

			$v = "gform_button_custom_class";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "bad_red_color";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "good_black_color";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "store_hide_selected_gforms";
			echo lct_f(
				"lct_useful_settings[$v]",
				"radiogroup",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "Store Form Data", "not_set_selected" => "0", "options_default" => false, "options_hide" => true ]
			);

			$v = "store_gforms";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkboxgroup",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => "Select Forms", "lct_select_options" => "gravity_forms", "options_default" => false, "options_hide" => true ]
			);
			?>
			</tbody></table>
		<p>&nbsp;</p>


		<h3>Yoast SEO</h3>
		<table class="form-table"><tbody>
			<?php
			$v = "hide_og_site_name";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => 'Hide OG site_name', 'label_override' => true ]
			);
			?>
			</tbody></table>
		<p>&nbsp;</p>


		<h3>Login Form</h3>
		<table class="form-table"><tbody>
			<?php
			$v = "lct_show_login_logo";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_login_logo";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_show_tag_line";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_tag_line";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_show_register_link";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_register_page";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v, "lct_select_options" => "get_pages", "options_default" => false, "options_hide" => false ]
			);

			$v = "lct_show_login_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_login_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);

			$v = "lct_login_redirect";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				isset( $term_meta[$v] ) ? $term_meta[$v] : '',
				[ "label" => $v ]
			);
			?>
			</tbody></table>
		<p>&nbsp;</p>


		<h3>Fixes and Cleanups</h3>
		<a href="<?php echo admin_url( 'admin.php?page=lct_cleanup_guid' ); ?>" class="button button-primary">Cleanup Guid Fields</a>
		<p>&nbsp;</p>


		<?php submit_button(); ?>
	</form>
<?php }


function  lct_cleanup_guid() {
	global $wpdb;

	$siteurl = get_option( 'siteurl' );
	$siteurl_tmp = explode( '/', $siteurl );
	$siteurl_scheme = $siteurl_tmp[0];
	$siteurl_root = $siteurl_tmp[2];

	$post_types = get_post_types();
	unset( $post_types['revision'] );

	$post_info = [];

	foreach( get_post_types() as $post_type ) {
		$args = [
			'posts_per_page'   => -1,
			'post_type'        => $post_type,
			'fields'        => 'ids',
		];
		$posts = get_posts( $args );

		if( ! empty( $posts ) ) {
			foreach( $posts as $post_id ) {
				$guid = get_the_guid( $post_id );
				$post_info_tmp = '<strong>' . $post_id . ': (' . $post_type . ') ' . '</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;' . $guid;

				$guid_tmp = explode( '/', $guid );
				$guid_tmp[2] = $siteurl_root;
				$guid_new = implode( '/', $guid_tmp );

				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET guid = %s WHERE ID = %d", $guid_new, $post_id ) );

				$post_info[] = $post_info_tmp . '<br />&nbsp;&nbsp;&nbsp;&nbsp;' . $guid_new . '<br />';
			}
		}
	} ?>

	<h3>Fixes and Cleanups: Cleanup Guid</h3>

	<h4>New Scheme: <?php echo $siteurl_scheme; ?></h4>

	<h4>New URL: <?php echo $siteurl_root; ?></h4>

	<h4>Post Types</h4>
	<p><?php echo implode( '<br />', $post_types ); ?></p>

	<h4>Posts Updated</h4>
	<p><?php echo implode( '<br />', $post_info ); ?></p>
	<h1>Done</h1>
<?php }


function lct_term_meta_default_check( $term_meta = null ) {
	if( ! $term_meta )
		return false;

	$defaults = lct_term_meta_defaults( null, false );

	foreach( $term_meta as $k => $v ) {
		if( ! isset( $defaults[$k] ) )
			echo_br( '<strong>' . $k . '</strong>', 'Add to Defaults' );
	}
}


function lct_term_meta_defaults( $v = null, $unset = true ) {
	$defaults = [];
	$defaults['Enable_Front_css']							= 1;		//checkbox
	$defaults['disable_avada_css']							= 'ignore';	//checkbox
	$defaults['Default_Taxonomy']							= 'ignore';
	$defaults['print_user_agent_in_footer']					= 'ignore'; //checkbox
	$defaults['choose_a_raw_tag_option']					= 'old';
	$defaults['use_placeholders_instead_of_labels']			= 'ignore'; //checkbox
	$defaults['use_gforms_css_tweaks']						= 1;		//checkbox
	$defaults['enable_cj_spam_check']						= '';
	$defaults['enable_cj_spam_check_email']					= '';
	$defaults['gforms_css_tweaks_gform_footer_margin']		= '0';
	$defaults['gforms_css_tweaks_gform_footer_padding']		= '0';
	$defaults['gform_button_custom_class']					= 'ignore';
	$defaults['bad_red_color']								= 'red';
	$defaults['good_black_color']							= '#bbb';
	$defaults['store_hide_selected_gforms']					= 0;
	$defaults['store_gforms']								= 'ignore'; //checkbox
	$defaults['hide_og_site_name']							= 'ignore'; //checkbox
	$defaults['lct_show_login_logo']						= 'ignore'; //checkbox
	$defaults['lct_login_logo']								= 'ignore';
	$defaults['lct_show_tag_line']							= 'ignore'; //checkbox
	$defaults['lct_tag_line']								= 'ignore';
	$defaults['lct_show_register_link']						= 'ignore'; //checkbox
	$defaults['lct_register_page']							= 'ignore';
	$defaults['lct_show_login_footer']						= 'ignore'; //checkbox
	$defaults['lct_login_footer']							= 'ignore';
	$defaults['lct_login_redirect']							= 'ignore';
	$defaults['lct_cleanup_guid']							= 'ignore';

	$are_checkbox = [
		'Enable_Front_css',
		'use_gforms_css_tweaks',
	];

	if( $v )
		return $defaults[$v];

	if( $unset ) {
		foreach( $defaults as $k => $v ) {
			if ( $v == 'ignore' )
				unset( $defaults[$k] );

			if( in_array( $k, $are_checkbox ) ) {
				$is_default_set = get_option( 'lct_useful_settings_default_set_' . $k );

				if( $is_default_set )
					unset( $defaults[$k] );
				else
					update_option( 'lct_useful_settings_default_set_' . $k, 1 );
			}
		}
	}

	return $defaults;
}
