<?php
/**
 * Create the full_field_name so that we can reference it in the DB.
 *
 * @param null   $prefix
 * @param null   $field_name
 * @param string $delimiter
 *
 * @return bool|string
 */
function lct_acf_get_full_field_name( $prefix = null, $field_name = null, $delimiter = ':::' ) {
	if( empty( $prefix ) )
		return false;

	$full_field_name = $prefix . $delimiter . $field_name;

	return $full_field_name;
}


/**
 * Unsave the values in the DB, so the fields are empty again
 *
 * @param       $fields
 * @param       $prefix
 * @param array $custom_exclude
 * @param array $custom_include
 *
 * @return bool
 */
function lct_acf_unsave_db_values( $fields, $prefix, $custom_exclude = [ ], $custom_include = [ ] ) {
	if( empty( $fields['show_params::save_field_values'][0] ) ) {
		foreach( $fields as $field_name => $field_value ) {
			$exclude_from_clear = lct_acf_exclude_from_clear( $custom_exclude, $custom_include );

			if( in_array( $field_name, $exclude_from_clear ) )
				continue;

			$full_field_name = lct_acf_get_full_field_name( $prefix, $field_name );

			update_field( $full_field_name, "" );
		}

		return true;
	}

	return false;
}


/**
 * Set the fields that you don't want to have cleared out of the DB when Save Field Values is not set.
 *
 * @param array $custom_exclude
 * @param array $custom_include
 *
 * @return array
 */
function lct_acf_exclude_from_clear( $custom_exclude = [ ], $custom_include = [ ] ) {
	if( ! empty( $custom_exclude ) ) {
		foreach( $custom_exclude as $excluded_field ) {
			$exclude[$excluded_field] = 1;
		}
	}

	if( ! empty( $custom_include ) ) {
		foreach( $custom_include as $included_field ) {
			$exclude[$included_field] = 0;
		}
	}

	if( ! isset( $exclude['show_params'] ) )
		$exclude['show_params'] = 1;

	$excluded_fields = [ ];

	foreach( $exclude as $excluded_field => $status ) {
		if( $status == 1 || ( $exclude['show_params'] == 1 && strpos( $excluded_field, 'show_params' ) !== false ) )
			$excluded_fields[] = $excluded_field;
	}

	return $excluded_fields;
}


/**
 * Create our $fields array
 *
 * @param $field_names
 * @param $prefix
 *
 * @return mixed
 */
function lct_acf_get_fields_mapped( $field_names, $prefix ) {
	$fields = [ ];

	foreach( $field_names as $field_name ) {
		$full_field_name = lct_acf_get_full_field_name( $prefix, $field_name );

		$field_value = get_field( $full_field_name, "option" );

		$fields[$field_name] = $field_value;
	}

	return $fields;
}


/**
 * Get fields and create our $fields array
 *
 * @param $field_names
 * @param $prefix
 *
 * @return mixed
 */
function lct_acf_get_mapped_fields( $parent, $prefix, $excluded_fields = null, $just_field_name = false, $prefix_2 = null, $delimiter = ':::' ) {
	$fields = [ ];

	$field_names = lct_acf_get_fields_by_parent( $parent, $prefix, $excluded_fields, $just_field_name, $prefix_2 );

	foreach( $field_names as $field_name ) {
		if( $prefix_2 )
			$full_field_name = lct_acf_get_full_field_name( $prefix . $delimiter . $prefix_2, $field_name, null );
		else
			$full_field_name = lct_acf_get_full_field_name( $prefix, $field_name );

		$field_value = get_field( $full_field_name, "option" );

		$fields[$field_name] = $field_value;
	}

	return $fields;
}


function lct_acf_get_fields_by_parent( $parent, $prefix, $excluded_fields, $just_field_name = false, $prefix_2 = null ) {
	$fields = [ ];

	$args = [
		'posts_per_page' => -1,
		'post_type'      => 'acf-field',
		'post_status'    => 'any',
		'post_parent'    => $parent
	];
	$field_objects = get_posts( $args );

	if( ! is_wp_error( $field_objects ) ) {
		foreach( $field_objects as $field_object ) {
			//TODO: cs - Need to make ::: dynamic - 7/24/2015 2:06 PM
			$post_excerpt = str_replace( $prefix . ':::', '', $field_object->post_excerpt );

			if( $prefix_2 )
				$post_excerpt = str_replace( $prefix_2, '', $post_excerpt );

			if( is_array( $excluded_fields ) && in_array( $post_excerpt, $excluded_fields ) )
				continue;

			if( $just_field_name ) {
				$fields[$field_object->menu_order] = $post_excerpt;
			} else {
				$fields[$field_object->post_name] = $post_excerpt;
			}
		}
	}

	sort( $fields );

	$fields = array_filter( $fields );

	return $fields;
}


/**
 * Get fields and create our $fields array
 *
 * @param $field_names
 * @param $prefix
 *
 * @return mixed
 */
function lct_acf_get_mapped_fields_of_object( $prefix, $excluded_fields = null, $just_field_name = false, $prefix_2 = null, $delimiter = ':::' ) {
	$fields = [ ];

	$field_names = lct_acf_get_fields_by_object( $prefix, $excluded_fields, $just_field_name, $prefix_2 );

	foreach( $field_names as $field_name ) {
		if( $prefix_2 )
			$full_field_name = lct_acf_get_full_field_name( $prefix . $delimiter . $prefix_2, $field_name, null );
		else
			$full_field_name = lct_acf_get_full_field_name( $prefix, $field_name );

		$field_value = get_field( $full_field_name, "option" );

		$fields[$field_name] = $field_value;
	}

	return $fields;
}


function lct_acf_get_fields_by_object( $prefix, $excluded_fields, $just_field_name = false, $prefix_2 = null ) {
	$fields = [ ];

	$field_objects = get_field_objects( 'option' );

	foreach( $field_objects as $key => $field_object ) {
		//TODO: cs - Need to make ::: dynamic - 7/24/2015 2:06 PM
		if( $prefix_2 && strpos( $key, $prefix . ':::' . $prefix_2 ) === false )
			continue;

		//TODO: cs - Need to make ::: dynamic - 7/24/2015 2:06 PM
		$post_excerpt = str_replace( $prefix . ':::', '', $key );

		if( $prefix_2 )
			$post_excerpt = str_replace( $prefix_2, '', $post_excerpt );

		if( is_array( $excluded_fields ) && in_array( $post_excerpt, $excluded_fields ) )
			continue;

		if( $just_field_name ) {
			$fields[$field_object['menu_order']] = $post_excerpt;
		} else {
			$fields[$field_object['name']] = $post_excerpt;
		}
	}

	sort( $fields );

	$fields = array_filter( $fields );

	return $fields;
}


function lct_acf_recap_field_settings( $fields, $prefix ) {
	$recap = "<h2 style='color: green;font-weight: bold; margin-bottom: 0;'>Settings Recap:</h2>";


	$recap .= '<ul style="margin-top: 0;">';

	foreach( $fields as $field_name => $field_value ) {
		$excluded_fields = [
			'show_params::save_field_values',
			'run_this'
		];

		if( empty( $field_value ) || in_array( $field_name, $excluded_fields ) ) {
			if( $field_name == 'run_this' )
				$recap .= "<li><span style='float: left;width: 115px;font-weight: bold;'>" . $field_name . ":</span><span style='color: green;font-weight: bold'>Just Ran {$prefix}</span></li>";

			continue;
		}

		if( is_array( $field_value ) ) {
			$field_value = $field_value[0];

			//TODO: cs - We probably need a more dynamic check here - 7/24/2015 12:24 PM
			if( $field_value == 1 )
				$field_value = 'Yes';
		}

		$recap .= "<li><span style='float: left;width: 115px;font-weight: bold;'>" . $field_name . ":</span> " . $field_value . "</li>";

	}

	$recap .= '</ul>';


	return $recap;
}


function lct_acf_create_table( $rows ) {
	$table = '';

	if( ! empty( $rows ) ) {
		$table .= '<table class="wp-list-table widefat fixed striped">';

		foreach( $rows as $row_number => $row ) {
			if( $row_number === 0 )
				$table .= '<thead>';

			if( $row_number === 1 ) {
				$table .= '</thead>';
				$table .= '<tbody id="the-list">';
			}

			$table .= '<tr>';

			foreach( $row as $k => $column ) {
				if( $row_number === 0 ) {
					$table .= '<th scope="col" id="' . $k . '" class="manage-column column-customer_name" style="">' . $column . '</th>';

					continue;
				}

				$table .= '<td class="' . $k . ' column-' . $k . '">' . $column . '</td>';
			}

			$table .= '</tr>';
		}

		$table .= '</tbody>';

		$table .= '</table>';
	}

	return $table;
}
