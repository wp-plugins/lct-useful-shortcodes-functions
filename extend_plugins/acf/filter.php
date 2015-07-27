<?php
add_filter( 'acf/load_field/type=radio', 'lct_acf_op_show_params_check' );
/*
* hide params for people who don't know what they are.
*/
function lct_acf_op_show_params_check( $field ) {
	if(
		strpos( $field['name'], ':::show_params' ) === false ||
		! isset( $_GET['page'] )
	)
		return $field;

	$user_is_dev = lct_is_user_a_dev();

	if( empty( $user_is_dev ) && strpos( $field['name'], ':::show_params' ) !== false && $field['value'] != 1 ) {
		$conditional_logic = [
			[
				'field'    => $field['key'],
				'operator' => '==',
				'value'    => 1
			]
		];

		$field['conditional_logic'] = $conditional_logic;
	}

	return $field;
}


add_filter( 'manage_edit-acf-field-group_columns', 'lct_acf_field_groups_columns', 11 );
/**
 * Add some custom columns to help us know where the heck the Field Groups go to.
 *
 * @param $columns
 *
 * @return mixed
 */
function lct_acf_field_groups_columns( $columns ) {
	$columns['rule'] = 'Primary Rule';

	return $columns;
}


add_action( 'manage_acf-field-group_posts_custom_column', 'lct_acf_field_groups_columns_values', 11 );
/**
 * Process the values for our custom columns
 *
 * @param $column
 * @param $post_id
 */
function lct_acf_field_groups_columns_values( $column, $post_id ) {
	// vars
	if( $column == 'rule' ) {
		$group = get_post( $post_id );
		$group_array = unserialize( $group->post_content );
		$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		echo $group_array['location'][0][0]['param'] . $space . '<strong>' . $group_array['location'][0][0]['operator'] . '</strong>' . $space . $group_array['location'][0][0]['value'];
	}
}


add_filter( 'acf/get_field_groups', 'lct_acf_acf_export_title_mod', 11 );
/**
 * We need to know what we are exporting. The title is just not enough info.
 *
 * @param $field_groups
 *
 * @return mixed
 */
function lct_acf_acf_export_title_mod( $field_groups ) {
	if(
		! isset( $_GET['page'] ) ||
		$_GET['page'] != 'acf-settings-export'
	)
		return $field_groups;

	foreach( $field_groups as $key => $field_group ) {
		$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$title_addition = $field_group['location'][0][0]['param'] . $space . $field_group['location'][0][0]['operator'] . $space . $field_group['location'][0][0]['value'] . '|' . $field_groups[$key]['title'];

		$fnr = lct_create_find_and_replace_arrays(
			[
				' '    => 'zzspzz', //space
				$space => 'zzsp5zz', //space
				'-'    => 'zzuszz', //underscore
				'|'    => 'zzus3zz', //underscore x 3
				'='    => 'zzeqzz', //= sign
			]
		);

		$fnr_back = lct_create_find_and_replace_arrays(
			[
				'zzspzz'  => '_',
				'zzsp5zz' => '__',
				'zzuszz'  => '_',
				'zzus3zz' => '___',
				'zzeqzz'  => '=',
				'_=_'     => '_',
				'__==__'  => '__',
			]
		);

		$file_name = str_replace( $fnr_back['find'], $fnr_back['replace'], sanitize_title( str_replace( $fnr['find'], $fnr['replace'], $title_addition ) ) ) . '.json';


		$field_groups[$key]['title'] .= $space . '<strong>Filename(' . $space . $file_name . $space . ')</strong>';
	}

	return $field_groups;
}
