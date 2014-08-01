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
	if( in_array( $form['id'], lct_get_lct_useful_settings( 'use_placeholders_instead_of_labels' ) ) == false ) return $form;

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
			if( $field['isRequired'] ) $placeholder .= ' *';

			echo "jQuery('#$input').val('$placeholder');\n";

			$jQuery_submit .= "if( jQuery('#$input').val() == '$placeholder' )
				jQuery('#$input').val('');\n";

			echo "jQuery('label[for=$input]').hide();\n";

			echo "jQuery('#$input').focus(function(){
				if(jQuery('#$input').val() == '$placeholder')
					jQuery('#$input').val('');

				jQuery('#$input').css({
					'color' : '#000',
				});
			});

			jQuery('#$input').blur(function(){
				if(jQuery('#$input').val() == ''){
					jQuery('#$input').val('$placeholder');

					jQuery('#$input').css({
						'color' : 'red',
					});
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

	<?php return $form;
}
