<?php
/**
 * Return ALL Gravity form fields adminLabel's $field['id']
 *
 * @since 1.2.7
 *
 * @param array $fields ALL form field's data
 * @param array $lead Optional. If set the adminLabel's entered value is returned
 *
 * @return array {
 *     @type int '{adminLabel}' = $field['id'] OR $lead[] value
 * }
 */
function lct_map_adminLabel_to_field_id( $fields, $lead = null ) {
	$adminLabel_map = array();

	foreach( $fields as $field ) {
		if( $field['inputName'] ) $field['adminLabel'] = $field['inputName'];

		$field['adminLabel'] ? $k = $field['adminLabel'] : $k = $field['id'];

		if( $lead )
			$v = $lead[ $field['id'] ];
		else
			$v = $field['id'];

		$adminLabel_map[$k] = $v;
	}

	return $adminLabel_map;
}


/**
 * lct_use_placeholders_instead_of_labels
 *
 * @since 1.2.7
 *
 * @param array $form ALL form data
 * @return array $form ALL form data
 */
add_filter( 'gform_pre_render', 'lct_use_placeholders_instead_of_labels', 1 );
function lct_use_placeholders_instead_of_labels( $form ) {
	$is_placeholder = in_array( $form['id'], use_placeholders_instead_of_labels_array() );
	$valid_types = array( 'text', 'textarea', 'phone', 'email' );
	$f_id = $form['id'];
	$jQuery_submit = '';
	$useful_settings = lct_get_lct_useful_settings();

	do_action( 'lct_jquery_autosize_min_js' );
	?>

	<script>
	jQuery(document).bind( 'gform_post_render', function() {
		jQuery('textarea').autosize();

		<?php if( $is_placeholder ){
			foreach( $form['fields'] as &$field ){
				if( ! in_array( $field['type'], $valid_types ) || strpos( $field['cssClass'], 'no-placeholder' ) !== false ) continue;

				$input = "input_" . $f_id . "_" . $field['id'];

				$field['defaultValue'] ? $placeholder = $field['defaultValue'] : $placeholder = $field['label'];
				if( $field['isRequired'] ){
					$placeholder .= ' *';
					$focus_Class = "jQuery('#$input').addClass('good_black');\n";
					$focus_Class .= "jQuery('#$input').removeClass('bad_red');\n";
					$blur_Class = "jQuery('#$input').removeClass('good_black');\n";
					$blur_Class .= "jQuery('#$input').addClass('bad_red');\n";
				}else{
					$focus_Class = "";
					$blur_Class = "";
				}

				echo "var placeholder = '$placeholder';\n";

				if( strpos( $placeholder, ";" ) === false )
					echo "jQuery('#$input').val('$placeholder');\n";
				else{
					$tmp = explode( ";", $placeholder );
					$placeholder = trim( $tmp[1] );
				}

				$jQuery_submit .= "if( jQuery('#$input').val() == '$placeholder' )
					jQuery('#$input').val('');\n";

				echo "jQuery('label[for=$input]').hide();\n";

				echo "jQuery('#$input').focus(function(){
					if(jQuery('#$input').val() == '$placeholder' || placeholder.indexOf(';') != -1 )
						jQuery('#$input').val('');

					$focus_Class
				});

				jQuery('#$input').blur(function(){
					if(jQuery('#$input').val() == ''){
						jQuery('#$input').val('$placeholder');

						$blur_Class
					}
				});";
		 	}
		 	?>

			jQuery('#gform_submit_button_<?php echo $f_id; ?>').click( function() {
				<?php echo $jQuery_submit; ?>
				return true;
			});
		<?php } ?>
	});
	</script>


	<style>
	<?php if( $is_placeholder ){ ?>
		.bad_red,
		.gform_wrapper .gfield input.bad_red,
		.gform_wrapper .gfield textarea.bad_red{
			color: <?php echo $useful_settings['bad_red_color']; ?> !important;
		}

		.good_black,
		.gform_wrapper .gfield input.good_black,
		.gform_wrapper .gfield textarea.good_black{
			color: <?php echo $useful_settings['good_black_color']; ?> !important;
		}
	<?php } ?>

	<?php if( $useful_settings['use_gforms_css_tweaks'] ) {
		$pre = 'gforms_css_tweaks_';
		isset( $useful_settings[$pre . 'gform_footer_margin'] ) ? $margin = 'margin: ' . $useful_settings[$pre . 'gform_footer_margin'] . ';' : $margin = '';
		isset( $useful_settings[$pre . 'gform_footer_padding'] ) ? $padding = 'padding: ' . $useful_settings[$pre . 'gform_footer_padding'] . ';' : $padding = '';

		echo "
		.gform_wrapper .gform_footer{
			$margin
			$padding
		}
		";
	} ?>
	</style>


	<?php return $form;
}


/**
 * filter the Gravity Forms button type
 */
add_filter( 'gform_submit_button', 'lct_gform_submit_button', 10, 2 );
function lct_gform_submit_button( $button, $form ) {
	$custom_class = lct_get_lct_useful_settings( 'gform_button_custom_class' );

	if( ! $custom_class ) return $button;

	$find = array( "class='button " );
	$replace = array( "class='$custom_class " );

    return str_replace( $find, $replace, $button );
}


/**
 * store or remove entry based on settings.
 *
 * @since 1.2.9
 *
 * @param array $entry ALL entry data
 * @param array $form ALL form data
 */
add_action( 'gform_after_submission', 'lct_remove_form_entry', 13, 2 );
function lct_remove_form_entry( $entry, $form ) {
	$is_in_array = in_array( $form['id'], store_gforms_array() );

	if( lct_get_lct_useful_settings( 'store_hide_selected_gforms' ) ) {
    	if( $is_in_array )
    		return;
	}else{
		if( ! $is_in_array )
    		return;
	}

	global $wpdb;

    $lead_id = $entry['id'];
    $lead_table = RGFormsModel::get_lead_table_name();
    $lead_detail_table = RGFormsModel::get_lead_details_table_name();
    $lead_detail_long_table = RGFormsModel::get_lead_details_long_table_name();
    $lead_meta_table = RGFormsModel::get_lead_meta_table_name();
    $lead_notes_table = RGFormsModel::get_lead_notes_table_name();

	//Delete from detail long
	$sql = $wpdb->prepare(
		"DELETE FROM $lead_detail_long_table
		WHERE lead_detail_id IN
		(SELECT id FROM $lead_detail_table WHERE lead_id=%d)",
		$lead_id
	);
	$wpdb->query($sql);

	//Delete from lead details
	$sql = $wpdb->prepare(
		"DELETE FROM $lead_detail_table WHERE lead_id=%d",
		$lead_id
	);
	$wpdb->query($sql);

	//Delete from lead meta
	$sql = $wpdb->prepare(
		"DELETE FROM $lead_meta_table WHERE lead_id=%d",
		$lead_id
	);
	$wpdb->query($sql);

	//Delete from lead notes
	$sql = $wpdb->prepare(
		"DELETE FROM $lead_notes_table WHERE lead_id=%d",
		$lead_id
	);
	$wpdb->query($sql);

	//Delete from lead
	$sql = $wpdb->prepare(
		"DELETE FROM $lead_table WHERE id=%d",
		$lead_id
	);
	$wpdb->query($sql);
}