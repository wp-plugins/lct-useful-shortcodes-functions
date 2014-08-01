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
	if( in_array( $form['id'], use_placeholders_instead_of_labels_array() ) == false ) return $form;

	$valid_types = array( 'text', 'textarea', 'phone', 'email' );
	$f_id = $form['id'];
	$jQuery_submit = '';
	?>

	<script>
	jQuery(document).bind('gform_post_render', function(){
		<?php
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
	});
	</script>


	<style>
	.bad_red,
	.gform_wrapper .gfield input.bad_red,
	.gform_wrapper .gfield textarea.bad_red{
		color: <?php echo lct_get_lct_useful_settings( 'bad_red_color' ); ?> !important;
	}

	.good_black,
	.gform_wrapper .gfield input.good_black,
	.gform_wrapper .gfield textarea.good_black{
		color: <?php echo lct_get_lct_useful_settings( 'good_black_color' ); ?> !important;
	}
	</style>


	<?php return $form;
}
