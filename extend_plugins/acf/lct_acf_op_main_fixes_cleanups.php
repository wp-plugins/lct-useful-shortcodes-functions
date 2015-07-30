<?php
add_filter( 'acf/load_field', 'lct_acf_op_main_fixes_cleanups' );
/**
 * populate the fixes_and_cleanups stuff
 *
 * @param $field
 *
 * @return mixed
 */
function lct_acf_op_main_fixes_cleanups( $field ) {
	if(
		! isset( $_GET['page'] ) ||
		$_GET['page'] != 'lct_acf_op_main_fixes_cleanups'
	)
		return $field;

	if(
		$field['type'] == 'oembed' &&
		strpos( $field['name'], ':::lct_fix' ) !== false
	) {
		$fixes_and_cleanup = str_replace( ':::lct_fix', '', $field['name'] );

		unset( $field['width'] );
		unset( $field['height'] );

		$field['type'] = 'message';
		$field['message'] = lca_get_fixes_cleanups_message( $fixes_and_cleanup, $field['parent'] );
		$field['esc_html'] = 0;
	}

	return $field;
}


/**
 * Routes you to the proper fixes_and_cleanups_message
 *
 * @param null $prefix
 * @param null $parent
 *
 * @return mixed
 */
function lca_get_fixes_cleanups_message( $prefix = null, $parent = null ) {
	$message = call_user_func( 'lca_get_fixes_cleanups_message___' . $prefix, $prefix, $parent );

	return $message;
}


/**
 * DB Fix::: Add taxonomy field data to old entries
 * Adds ACF taxonomy meta to newly created fields for existing groups
 *
 * @param $prefix
 * @param $parent
 *
 * @return string
 */
function lca_get_fixes_cleanups_message___db_fix_atfd_7637( $prefix, $parent ) {
	$message = '';

	$excluded_fields = [
		'show_params',
		'lct_fix'
	];

	$fields = lct_acf_get_mapped_fields( $parent, $prefix, $excluded_fields, true );

	//Unsave the values in the DB, so the fields are empty again
	lct_acf_unsave_db_values( $fields, $prefix );


	if( ! isset( $fields['run_this'][0] ) ) {
		$message = "<h1 style='color: green;font-weight: bold'>Select some options below to run this Fix/Cleanup.</h1>";

		return $message;
	}


	//Ok, We are finally able to run the fix if we made it this far.


	$tax_args = [
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'fields'       => 'ids'
	];
	$term_ids = get_terms( $fields['taxonomy'], $tax_args );


	if( ! empty( $term_ids ) && ! is_wp_error( $term_ids ) ) {
		$option_value = '';

		if( $fields['is_array'][0] ) {
			$option_value = explode( ",", $fields['option_value'] );
		}

		$message .= '<h2>Updated Terms</h2>';

		$message .= '<ul>';

		foreach( $term_ids as $k => $term_id ) {
			$option_name = implode( '_', [ $fields['taxonomy'], $term_id, $fields['f_name'] ] );

			if( ! $fields['overwrite_value'][0] ) {
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
		$message = "<h1 style='color: red;font-weight: bold'>Invalid Taxonomy</h1>";

		return $message;
	}


	//Done with the fix


	$message .= lct_acf_recap_field_settings( $fields, $prefix );

	return $message;
}


/**
 * DB Fix::: Add Post Meta to Multiple Posts
 * Adds/Updates your desired post meta key and value to your noted array of posts
 *
 * @param $prefix
 * @param $parent
 *
 * @return string
 */
function lca_get_fixes_cleanups_message___db_fix_apmmp_5545( $prefix, $parent ) {
	$message = '';

	$excluded_fields = [
		'show_params',
		'lct_fix'
	];

	$fields = lct_acf_get_mapped_fields( $parent, $prefix, $excluded_fields, true );

	//Unsave the values in the DB, so the fields are empty again
	lct_acf_unsave_db_values( $fields, $prefix );


	if( ! isset( $fields['run_this'][0] ) ) {
		$message = "<h1 style='color: green;font-weight: bold'>Select some options below to run this Fix/Cleanup.</h1>";

		return $message;
	}


	//Ok, We are finally able to run the fix if we made it this far.


	if( ! empty( $fields['posts'] ) ) {
		$posts = explode( ',', $fields['posts'] );
		$meta_value = '';

		if( $fields['is_array'][0] ) {
			$meta_value = explode( ",", $fields['meta_value'] );
		}

		$message .= '<h2>Updated Post IDs</h2>';

		$message .= '<ul>';

		foreach( $posts as $post_id ) {
			if( ! is_numeric( $post_id ) )
				continue;

			if( ! $fields['overwrite_value'][0] ) {
				$current_value = get_post_meta( $post_id, $fields['meta_key'], true );

				if( ! empty( $current_value ) )
					continue;
			}

			$message .= "<li><span style='font-weight: bold;'>Post ID " . $post_id . ":</span> " . get_the_title( $post_id ) . "</li>";

			update_post_meta( $post_id, $fields['meta_key'], $meta_value );
		}

		$message .= '</ul>';
	} else {
		$message = "<h1 style='color: red;font-weight: bold'>Invalid Post ID Array</h1>";

		return $message;
	}


	//Done with the fix


	$message .= lct_acf_recap_field_settings( $fields, $prefix );

	return $message;
}


//add_filter( 'acf/update_value', 'lct_acf_op_main_fixes_cleanups_update_value', 10, 3 );
/**
 * Not currently in use, just saving for future reference
 *
 * @param $value
 * @param $post_id
 * @param $field
 *
 * @return mixed
 */
function lct_acf_op_main_fixes_cleanups_update_value( $value, $post_id, $field ) {
	if( $post_id != 'options' || ! isset( $_GET['page'] ) )
		return $value;

	return $value;
}
