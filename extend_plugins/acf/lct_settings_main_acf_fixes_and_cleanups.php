<?php
add_filter( 'acf/load_field', 'lct_settings_main_acf_fixes_and_cleanups' );
/**
 * populate the fixes_and_cleanups stuff
 *
 * @param $field
 *
 * @return mixed
 */
function lct_settings_main_acf_fixes_and_cleanups( $field ) {
	if(
		! isset( $_GET['page'] ) ||
		$_GET['page'] != 'lct_settings_main_acf_fixes_and_cleanups'
	)
		return $field;

	if(
		$field['type'] == 'oembed' &&
		strpos( $field['name'], 'lct_fix__' ) !== false
	) {
		$fixes_and_cleanup = str_replace( 'lct_fix__', '', $field['name'] );

		unset( $field['width'] );
		unset( $field['height'] );

		$field['type'] = 'message';
		$field['message'] = lca_get_fixes_and_cleanups_message( $fixes_and_cleanup );
		$field['esc_html'] = 0;
	}

	return $field;
}


/**
 * Routes you to the proper fixes_and_cleanups_message
 *
 * @param null $fixes_and_cleanup
 *
 * @return mixed
 */
function lca_get_fixes_and_cleanups_message( $fixes_and_cleanup = null ) {
	$message = call_user_func( 'lca_get_fixes_and_cleanups_message_' . $fixes_and_cleanup, $fixes_and_cleanup );

	return $message;
}


/**
 * Addes ACF taxonomy meta to newly created fields for existing groups
 *
 * @param $fixes_and_cleanup
 *
 * @return string
 */
function lca_get_fixes_and_cleanups_message_db_fix_add_taxonomy_field_data( $fixes_and_cleanup ) {
	$message = '';
	$fields = [ ];
	//TODO: cs - Make this dynamic - 7/23/2015 12:08 AM
	$name_prefixes = [
		'run_this__',
		'overwrite_value__',
		'taxonomy__',
		'f_key__',
		'f_name__',
		'option_value__',
		'is_array__',
	];

	foreach( $name_prefixes as $name_prefix ) {
		$full_field_name = $name_prefix . $fixes_and_cleanup;
		$field_name = str_replace( '__', '', $name_prefix );

		$field_value = get_field( $full_field_name, "option" );

		$fields[$field_name] = $field_value;

		update_field( $full_field_name, "" );
	}

	if( ! isset( $fields['run_this'][0] ) ) {
		$message = "<p style='color: green;font-weight: bold'>Select some options below to run this Fix/Cleanup.</p>";

		return $message;
	}

	$tax_args = [
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'fields'       => 'ids'
	];
	$term_ids = get_terms( $fields['taxonomy'], $tax_args );


	if( ! empty( $term_ids ) && ! is_wp_error( $term_ids ) ) {
		if( $fields['is_array'] ) {
			$option_value = explode( ",", $fields['option_value'] );
		}

		$message .= '<h2>Updated Terms</h2>';

		$message .= '<ul>';

		foreach( $term_ids as $k => $term_id ) {
			$option_name = implode( '_', [ $fields['taxonomy'], $term_id, $fields['f_name'] ] );

			if( ! $fields['overwrite_value'] ) {
				$current_option = get_option( '_' . $option_name );

				if( ! empty( $current_option ) && $current_option == $fields['f_key'] )
					continue;
			}

			$message .= "<li><span style='font-weight: bold;'>Term ID " . $term_id . ":</span> " . $fields['option_value'] . "</li>";

			update_option( $option_name, $option_value );
			update_option( '_' . $option_name, $fields['f_key'] );
		}

		$message .= '</ul>';
	} else {
		$message = "<p style='color: red;font-weight: bold'>Invalid Taxonomy</p>";

		return $message;
	}

	$message .= '<ul>';

	foreach( $fields as $k => $v ) {
		if( ! empty( $v ) && $k != 'run_this' ) {
			if( is_array( $v ) ) {
				$v = $v[0];

				if( $v == 1 )
					$v = 'Yes';
			}

			$message .= "<li><span style='float: left;width: 115px;font-weight: bold;'>" . $k . ":</span> " . $v . "</li>";
		} else if( $k == 'run_this' )
			$message .= "<li><span style='color: green;font-weight: bold'>Just Ran This Fix/Cleanup</span></li>";
	}

	$message .= '</ul>';

	return $message;
}


//add_filter( 'acf/update_value', 'lct_settings_main_acf_fixes_and_cleanups_update_value', 10, 3 );
/**
 * Not currently in use, just saving for future reference
 *
 * @param $value
 * @param $post_id
 * @param $field
 *
 * @return mixed
 */
function lct_settings_main_acf_fixes_and_cleanups_update_value( $value, $post_id, $field ) {
	if( $post_id != 'options' || ! isset( $_GET['page'] ) )
		return $value;

	return $value;
}
