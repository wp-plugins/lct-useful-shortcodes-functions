<?php
add_action( 'admin_menu', 'lct_useful_menu' );
function lct_useful_menu() {
	add_object_page( 'LCT Useful', 'LCT Useful', 'manage_options', 'lct_useful_settings', 'lct_useful_settings' );
	//add_submenu_page( 'lct_useful_settings', 'Other', 'Other', 'manage_options', 'lct_other', 'lct_other' );
}


add_action( 'admin_init', 'lct_register_lct_useful_settings' );
function lct_register_lct_useful_settings() {
	register_setting( 'lct_useful_settings', 'lct_useful_settings' );

	$term_meta = lct_get_lct_useful_settings();
	$defaults = lct_term_meta_defaults();

	$defaults = array_merge( $defaults, $term_meta );

	update_option( 'lct_useful_settings', $defaults );
}


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
				$term_meta[$v],
				array( "label" => "Enable front.css" )
			);

			$v = "Default_Taxonomy";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				$term_meta[$v],
				array( "label" => "Default Taxonomy to Use for lct_select_options();", "label_override" => true, "lct_select_options" => "get_taxonomies", "options_default" => false )
			);

			$v = "print_user_agent_in_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "choose_a_raw_tag_option";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				$term_meta[$v],
				array( "label" => $v, "lct_select_options" => "get_raw_prefs", "options_default" => false, "options_hide" => true )
			);
			?>
		</tbody></table>
		<p>&nbsp;</p>


		<h3>Gravity Forms</h3>
		<table class="form-table"><tbody>
			<?php
			$v = "use_placeholders_instead_of_labels";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkboxgroup",
				$term_meta[$v],
				array( "label" => $v, "lct_select_options" => "gravity_forms", "options_default" => false, "options_hide" => true )
			);

			$v = "use_gforms_css_tweaks";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "enable_cj_spam_check";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "enable_cj_spam_check_email";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "gforms_css_tweaks_gform_footer_margin";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => "gform_footer Margin", "label_override" => true )
			);

			$v = "gforms_css_tweaks_gform_footer_padding";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => "gform_footer Padding", "label_override" => true )
			);

			$v = "gform_button_custom_class";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "bad_red_color";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "good_black_color";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "store_hide_selected_gforms";
			echo lct_f(
				"lct_useful_settings[$v]",
				"radiogroup",
				$term_meta[$v],
				array( "label" => "Store Form Data", "not_set_selected" => "0", "options_default" => false, "options_hide" => true )
			);

			$v = "store_gforms";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkboxgroup",
				$term_meta[$v],
				array( "label" => "Select Forms", "lct_select_options" => "gravity_forms", "options_default" => false, "options_hide" => true )
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
				$term_meta[$v],
				array( "label" => 'Hide OG site_name', 'label_override' => true )
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
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_login_logo";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_show_tag_line";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_tag_line";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_show_register_link";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_register_page";
			echo lct_f(
				"lct_useful_settings[$v]",
				"select",
				$term_meta[$v],
				array( "label" => $v, "lct_select_options" => "get_pages", "options_default" => false, "options_hide" => false )
			);

			$v = "lct_show_login_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"checkbox",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_login_footer";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);

			$v = "lct_login_redirect";
			echo lct_f(
				"lct_useful_settings[$v]",
				"text",
				$term_meta[$v],
				array( "label" => $v )
			);
			?>
		</tbody></table>
		<p>&nbsp;</p>


		<?php submit_button(); ?>
	</form>
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
	$defaults = array();
	$defaults['Enable_Front_css']							= 1;		//checkbox
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

	$are_checkbox = array(
		'Enable_Front_css',
		'use_gforms_css_tweaks',
	);

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
