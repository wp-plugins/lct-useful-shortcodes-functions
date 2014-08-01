<?php
add_action( 'admin_menu', 'lct_useful_menu' );
function lct_useful_menu() {
	add_object_page( 'LCT Useful', 'LCT Useful', 'manage_options', 'lct_useful_settings', 'lct_useful_settings' );
	//add_submenu_page( 'lct_useful_settings', 'Other', 'Other', 'manage_options', 'lct_other', 'lct_other' );
}


add_action( 'admin_init', 'lct_register_lct_useful_settings' );
function lct_register_lct_useful_settings() {
	register_setting( 'lct_useful_settings', 'lct_useful_settings' );
}


function lct_useful_settings() {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( __( 'You do not have sufficient permissions.' ) ); ?>

	<form method="post" action="options.php">
		<?php
		settings_fields( 'lct_useful_settings' );
		$term_meta = lct_get_lct_useful_settings();
		?>


		<h3>General Options</h3>
		<table class="form-table"><tbody>
			<?php
			$v = 'Enable_Front_css';
			echo lct_f(
				"lct_useful_settings[$v]",
				'checkbox',
				$term_meta[$v],
				array( 'label' => 'Enable front.css' )
			);

			$v = 'Default_Taxonomy';
			echo lct_f(
				"lct_useful_settings[$v]",
				'select',
				$term_meta[$v],
				array( 'label' => 'Default Taxonomy to Use for lct_select_options();', 'label_override' => true, 'lct_select_options' => 'get_taxonomies', 'options_default' => false )
			);
			?>
		</tbody></table>
		<p>&nbsp;</p>


		<h3>Gravity Forms</h3>
		<table class="form-table"><tbody>
			<?php
			$v = 'use_placeholders_instead_of_labels';
			echo lct_f(
				"lct_useful_settings[$v]",
				'checkboxgroup',
				$term_meta[$v],
				array( 'label' => $v, 'lct_select_options' => 'gravity_forms', 'options_default' => false, 'options_hide' => true )
			);
			?>
		</tbody></table>
		<p>&nbsp;</p>


		<?php submit_button(); ?>
	</form>
<?php }
