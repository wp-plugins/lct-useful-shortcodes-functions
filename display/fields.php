<?php
/**
 * Generate HTML for any Wordpress form field
 *
 * @item string input name
 * @type string input type (text, select, etc.)
 * @selected current input's value
 * @v['label']
 * @v['label_override']
 * @v['description']
 * @v['pre_field_class']
 * @v['input_class']
 * @v['pre_field']
 * @v['post_field']
 * @v['pre_label']
 * @v['post_label']
 * @v['pre_input']
 * @v['post_input']
 * @v['options_tax'] PASS-THRU to lct_select_options
 * @v['lct_select_options'] PASS-THRU to lct_select_options
 * @v['options_default'] PASS-THRU to lct_select_options
 * @v['options_hide'] PASS-THRU to lct_select_options
 * @v['npl_organization'] PASS-THRU to lct_select_options
 * @v['skip_npl_organization'] PASS-THRU to lct_select_options
 * @v['number_start'] PASS-THRU to lct_select_options
 * @v['number_end'] PASS-THRU to lct_select_options
 * @v['number_leading_zero'] PASS-THRU to lct_select_options
 * @v['number_increment'] PASS-THRU to lct_select_options
 * @v['date_start'] PASS-THRU to lct_select_options
 * @v['date_end'] PASS-THRU to lct_select_options
 * @v['other_variables'] html like style, rel, etc.
 * @v['not_set_selected'] mixed default value if the value has never been set before.
*/
function lct_f( $item = null, $type = null, $selected = '', $v ) {
	if( ! $item ) return;

	if( isset( $v['not_set_selected'] ) && $selected === '' )
		$selected = $v['not_set_selected'];

	if( $v['label'] && ! $v['label_override'] ) {
		$f_r = array(
			'lct_' => '',
			'ltm_' => '',
			'lcx_' => '',
			'npl_' => '',
			'_' => ' ',
		);

		$f = array(); $r = array();
		foreach( $f_r as $k=>$tmp ){
			$f[] = $k;
			$r[] = $tmp;
		}

		$v['label'] = ucwords( str_replace( $f, $r, $v['label'] ) );
	}

	$pre_field_class	= $v['pre_field_class'];
	$input_class		= $v['input_class'];
	$pre_field			= $v['pre_field'];
	$post_field			= $v['post_field'];
	$pre_label			= $v['pre_label'];
	$post_label			= $v['post_label'];
	$pre_input			= $v['pre_input'];
	$post_input			= $v['post_input'];

	if( $type ){
		switch( $type ){
			//text items
			case 'text':
				$pre_field_class	= "form-field $pre_field_class";
				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td>";
				$post_input			= "</td>";
				break;

			case 'text_div':
				$pre_field_class	= "form-field $pre_field_class";
				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;

			case 'text_p':
				$pre_field			= "<p class='form-row $pre_field_class'>";
				$post_field			= "</p>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;


			//checkbox items
			case 'checkbox':
			case 'checkboxgroup':
			case 'checkboxgroupinput':
				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td class='forminp forminp-checkbox'>";
				$post_input			= "</td>";
				break;

			case 'checkbox_div':
				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;


			//radio items
			case 'radiogroup':
				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td class='forminp forminp-checkbox'>";
				$post_input			= "</td>";
				break;

			case 'radiogroup_div':
				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;


			//select items
			case 'select':
				$pre_field_class	= "form-field $pre_field_class";
				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td class='forminp forminp-checkbox'>";
				$post_input			= "</td>";
				break;

			case 'select_div':
				$pre_field_class	= "form-field $pre_field_class";
				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;

			case 'select_p':
				$pre_field			= "<p class='form-row $pre_field_class'>";
				$post_field			= "</p>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				break;

			default:
				break;
		}

		if( ! isset( $v['pre_field_class'] ) )		$v['pre_field_class']		= $pre_field_class;
		if( ! isset( $v['input_class'] ) )			$v['input_class']			= $input_class;
		if( ! isset( $v['pre_field'] ) )			$v['pre_field']				= $pre_field;
		if( ! isset( $v['post_field'] ) )			$v['post_field']			= $post_field;
		if( ! isset( $v['pre_label'] ) )			$v['pre_label']				= $pre_label;
		if( ! isset( $v['post_label'] ) )			$v['post_label']			= $post_label;
		if( ! isset( $v['pre_input'] ) )			$v['pre_input']				= $pre_input;
		if( ! isset( $v['post_input'] ) )			$v['post_input']			= $post_input;

		if( ! isset( $v['options_tax'] ) )			$v['options_tax'] = lct_get_lct_useful_settings( 'Default_Taxonomy' );

		if( ! isset( $v['lct_select_options'] ) )	$v['lct_select_options']			= $item;
		if( ! isset( $v['options_default'] ) )		$v['options_default']	= 1;

		if( strpos( $type, "_" ) !== false ) {
			$t = explode("_", $type);
			$type = $t[0];
		}

		return call_user_func( 'lct_f_processor_' . $type, $item, $selected, $v );
	}

	//NOT currently in use
	return; //call_user_func( 'lct_f_' . $item, $item, $selected, $v );
}


function lct_f_processor_text( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];
	$input_value = $selected;
	$other_variables = $v['other_variables'];
	$input = "<input type='text' id='$item' name='$item' class='$input_class' value='$input_value' $other_variables />";
	$v['description'] ? $description = "<p class=\"description\">" . $v['description'] . "</p>" : $description = "";

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
			$output .= $description;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}


function lct_f_processor_checkbox( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];
	$selected ? $checked = 'checked="checked"' : $checked = '';
	$input = "<input type='checkbox' id='$item' name='$item' class='$input_class' value='1' $checked />";
	$v['description'] ? $description = "<p class=\"description\">" . $v['description'] . "</p>" : $description = "";

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
			$output .= $description;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}


function lct_f_processor_checkboxgroup( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];
	$v['description'] ? $description = "<p class=\"description\">" . $v['description'] . "</p>" : $description = "";

	$options = '';
	foreach( lct_select_options( $v['lct_select_options'], $v['options_default'], $v['options_hide'], $v ) as $fe_s ){
		$value = $fe_s['value'];
	 	in_array($value, $selected) ? $checked = 'checked="checked"' : $checked = '';
		$options .= "<input type='checkbox' id='$item' name='".$item."[]' class='$input_class' value='$value' $checked /> <label>" . $fe_s['label'] . "</label><br />";
	}

	$input = $options;

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
			$output .= $description;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}


function lct_f_processor_checkboxgroupinput( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];
	$v['description'] ? $description = "<p class=\"description\">" . $v['description'] . "</p>" : $description = "";

	$options = '';
	foreach( lct_select_options( $v['lct_select_options'], $v['options_default'], $v['options_hide'], $v ) as $fe_s ){
		$value = $fe_s['value'];
		$text_item = str_replace( "]", "_order_".$value."]", $item );
		$org_t_id = $v['npl_organization'];
		$term_meta = get_option( "npl_organization_$org_t_id" );
		$term_meta_key = str_replace( array( "term_meta[", "]" ), "",$text_item );

		 in_array( $value, $selected ) ? $checked = 'checked="checked"' : $checked = '';

		$options .= "<input type='text' id='$text_item' name='$text_item' style='width: 30px;' value='" . $term_meta[$term_meta_key] . "' />";
		$options .= "<input type='checkbox' id='$item' name='".$item."[]' class='$input_class' value='$value' $checked /> <label>" . $fe_s['label'] . "</label><br />";
	}

	$input = $options;

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
			$output .= $description;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}


function lct_f_processor_radiogroup( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];
	$v['description'] ? $description = "<p class=\"description\">" . $v['description'] . "</p>" : $description = "";

	$options = '';
	foreach( lct_select_options( $v['lct_select_options'], $v['options_default'], $v['options_hide'], $v ) as $fe_s ){
		$value = $fe_s['value'];
	 	$value == $selected ? $checked = 'checked="checked"' : $checked = '';
		$options .= "<input type='radio' id='$item' name='$item' class='$input_class' value='$value' $checked /> <label>" . $fe_s['label'] . "</label><br />";
	}

	$input = $options;

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
			$output .= $description;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}


function lct_f_processor_select( $item, $selected, $v ) {
	$output = '';
	$input_class = $v['input_class'];

	$input = "<select id='$item' name='$item' class='$input_class' >";

	$options = '';
	foreach( lct_select_options( $v['lct_select_options'], $v['options_default'], $v['options_hide'], $v ) as $fe_s ) {
		$fe_s['value'] == $selected ? $selected_option = 'selected="selected"' : $selected_option = '';
		$options .= "<option value='" . $fe_s['value'] . "' $selected_option>" . $fe_s['label'] . "</option>";
	}

	$input .= $options;
	$input .= "</select>";

	$output .= $v['pre_field'];
		$output .= $v['pre_label'];
			$output .= $v['label'];
		$output .= $v['post_label'];

		$output .= $v['pre_input'];
			$output .= $input;
		$output .= $v['post_input'];
	$output .= $v['post_field'];

	return $output;
}
