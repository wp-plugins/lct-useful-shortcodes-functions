<?php
/**
 * Generate HTML for any Wordpress form field
 *
 * @item string option_value
 * @type
 * @selected current option_value
 * @v['label']
 * @v['description']
 * @v['meta_ref_id']
 * @v['meta_type_id']
 * @v['meta_single'] true or false
 * @v['pre_field_class']
 * @v['input_class']
 * @v['pre_field']
 * @v['post_field']
 * @v['pre_label']
 * @v['post_label']
 * @v['pre_input']
 * @v['post_input']
 * @v['options_type']
 * @v['skip_lct_organization']
 * @v['lct_options']
 * @v['lct_options_default']
 * @v['lct_options_hide']
 * @v['lct_organization']
*/
function lct_f( $item = null, $type = null, $selected = '', $v ) {
	if( ! $item ) return;

	if( $v['label'] ) {
		$f = array("lct_", '_');
		$r = array("", " ");
		$v['label'] = ucwords( str_replace( $f, $r, $v['label'] ) );
	}

	$pre_field_class = $v['pre_field_class'];
	$input_class = $v['input_class'];

	if( $type ){
		switch( $type ){
			//text items
			case 'text' :
				$pre_field_class	= "form-field $pre_field_class";
				$input_class		= $input_class;

				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td>";
				$post_input			= "</td>";
				break;

			case 'text_div' :
				$pre_field_class	= "form-field $pre_field_class";
				$input_class		= $input_class;

				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				$pre_input			= "";
				$post_input			= "";
				break;

			case 'text_p' :
				$pre_field_class	= $pre_field_class;
				$input_class		= $input_class;

				$pre_field			= "<p class='form-row $pre_field_class'>";
				$post_field			= "</p>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				$pre_input			= "";
				$post_input			= "";
				break;


			//checkbox items
			case 'checkbox' :
			case 'checkboxgroup' :
			case 'checkboxgroupinput' :
				$pre_field_class	= $pre_field_class;
				$input_class		= $input_class;

				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td class='forminp forminp-checkbox'>";
				$post_input			= "</td>";
				break;

			case 'checkbox_div' :
				$pre_field_class	= $pre_field_class;
				$input_class		= $input_class;

				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				$pre_input			= "";
				$post_input			= "";
				break;


			//select items
			case 'select' :
				$pre_field_class	= "form-field $pre_field_class";
				$input_class		= $input_class;

				$pre_field			= "<tr class='$pre_field_class'>";
				$post_field			= "</tr>";
				$pre_label			= "<th><label for='$item'>";
				$post_label			= "</label></th>";
				$pre_input			= "<td class='forminp forminp-checkbox'>";
				$post_input			= "</td>";
				break;

			case 'select_div' :
				$pre_field_class	= "form-field $pre_field_class";
				$input_class		= $input_class;

				$pre_field			= "<div class='$pre_field_class'>";
				$post_field			= "</div>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				$pre_input			= "";
				$post_input			= "";
				break;

			case 'select_p' :
				$pre_field_class	= $pre_field_class;
				$input_class		= $input_class;

				$pre_field			= "<p class='form-row $pre_field_class'>";
				$post_field			= "</p>";
				$pre_label			= "<label for='$item'>";
				$post_label			= "</label>";
				$pre_input			= "";
				$post_input			= "";
				break;

			default :
				break;
		}

		if( ! isset( $v['input_class'] ) )			$v['input_class']			= $input_class;

		if( ! isset( $v['pre_field'] ) )			$v['pre_field']				= $pre_field;
		if( ! isset( $v['post_field'] ) )			$v['post_field']			= $post_field;
		if( ! isset( $v['pre_label'] ) )			$v['pre_label']				= $pre_label;
		if( ! isset( $v['post_label'] ) )			$v['post_label']			= $post_label;
		if( ! isset( $v['pre_input'] ) )			$v['pre_input']				= $pre_input;
		if( ! isset( $v['post_input'] ) )			$v['post_input']			= $post_input;

		if( ! isset( $v['options_type'] ) ) $v['options_type'] = 'lct_options';

		switch( $v['options_type'] ){
			case 'lct_goal_options':
				if( ! isset( $v['lct_goal_options'] ) )			$v['lct_goal_options']			= $item;
				if( ! isset( $v['lct_goal_options_default'] ) )	$v['lct_goal_options_default']	= 1;
				break;

			default:
				if( ! isset( $v['lct_options'] ) )			$v['lct_options']			= $item;
				if( ! isset( $v['lct_options_default'] ) )	$v['lct_options_default']	= 1;
				break;
		}

		if(strpos($type, "_")!==false){
			$t = explode("_", $type);
			$type = $t[0];
		}

		return call_user_func( 'lct_f_processor_' . $type, $item, $selected, $v );
	}

	return call_user_func( 'lct_f_' . $item, $item, $selected, $v );
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