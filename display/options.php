<?php
/**
 * Generate Options for a select, checkbox, etc. form field
 *
 * @type string only is custom, otherwise it will pull from options_tax
 * @default default is 1, use 0 for custom
 * @hide select 'hide' is you don't want to show a blank option
 * @v array {
 *		@type string 'options_tax'
 *		@type int 'gform_id'
 *		@type int 'npl_organization'
 *		@type bool 'skip_npl_organization'
 * }
*/
function lct_select_options( $type, $default = 1, $hide = null, $v = array() ) {
	if( ! $type )
		return;

	$v = lct_initialize_v( $v );

	//Clean up $type
	$f = array( "term_meta[", "lct_useful_settings[", "]" );
	$r = array( "", "", "" );
	$type = str_replace( $f, $r, $type );

	if( ! $v['options_tax'] )
		$v['options_tax'] = lct_get_lct_useful_settings( 'Default_Taxonomy' );

	if( $default )
		return call_user_func( 'lct_select_options_default', $hide , $type, $v );

	return call_user_func( 'lct_select_options_' . $type, $hide , $type, $v );
}

//Uses Taxonomy
function lct_select_options_default( $hide, $type, $v ) {
	$tax = $v['options_tax'];

	if( $v['skip_npl_organization']){
		$parent_term = get_term_by( 'slug', $type, $tax );
	}else{
		if( $v['npl_organization'] )
			$npl_organization = get_term_by( 'id', $v['npl_organization'], 'npl_organization' );
		else
			$npl_organization = get_term_by( 'id', get_user_meta( get_current_user_id(), 'npl_organization', true ), 'npl_organization' );

		$parent_term = get_term_by( 'slug', $npl_organization->slug . '__' . $type, $tax );
	}

	if( ! $parent_term ) return;

	$args = array(
		'type'                     => 'wp-lead',
		'child_of'                 => $parent_term->term_id,
		'orderby'                  => 'term_order',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'taxonomy'                 => $tax,
		'pad_counts'               => false
	);
	$tax_children = get_categories( $args );

	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	foreach ($tax_children as $child) {
		$term_meta = get_option( $tax . "_$child->term_id" );

		if( $term_meta['lct_hide_in_dropdown'] && ! $v['override_lct_hide_in_dropdown'] ) continue;

		$value = array( 'value' => $child->term_id );
		$array = array(
			'label'=>$child->name,
			'color'=> $term_meta['color'],
			'icon'=> $term_meta['icon'],
			'level'=> $term_meta['level'],
		);
		$tmp = array_merge($value, $array);
		$select_options[] = $tmp;
	}
	return $select_options;
}


//Uses Taxonomy
function lct_select_options_all_tax( $hide, $type, $v ) {
	$tax = $v['options_tax'];

	$args = array(
		'orderby'                  => 'term_order',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'taxonomy'                 => $tax,
		'pad_counts'               => false
	);
	$cats = get_categories( $args );

	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	foreach ($cats as $cat) {
		$term_meta = get_option( $tax . "_$cat->term_id" );
		$value = array( 'value' => $cat->term_id );
		$array = array(
			'label'=>$cat->name,
			'color'=> $term_meta['color'],
			'icon'=> $term_meta['icon'],
			'level'=> $term_meta['level'],
		);
		$tmp = array_merge($value, $array);
		$select_options[] = $tmp;
	}
	return $select_options;
}


//Get a list of ALL gravity forms
function lct_select_options_gravity_forms( $hide , $type, $v ) {
	$select_options = array();

	if( ! class_exists( 'RGFormsModel' ) )
		return $select_options;

	$forms = RGFormsModel::get_forms( null, 'title' );

	if( empty( $forms ) )
		return $select_options;

	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	foreach( $forms as $form )
	  $select_options[] = array( 'label'=>$form->title , 'value'=>$form->id );

	return $select_options;
}


//Get a list of ALL fields for a single gravity form
function lct_select_options_gravity_forms_form_fields( $hide, $type, $v ) {
	$select_options = array();

	if( ! class_exists( 'RGFormsModel' ) )
		return $select_options;

	$form = RGFormsModel::get_form_meta( $v['gform_id'] );

	if( ! $hide )
		$select_options[] = array( 'label' => '---', 'value' => '' );
	foreach( $form['fields'] as $fields ) {
		$exclude_type = array(
			'section',
			'html',
		);

		if( in_array( $fields['type'], $exclude_type ) )
			continue;

		switch( $fields['type'] ){
			case 'address':
				foreach( $fields['inputs'] as $tmp ) {
					$select_options[] = array( 'label' => $tmp['label'], 'value' => $tmp['id'] );
				}
			break;

			case 'checkbox':
				foreach( $fields['inputs'] as $tmp ) {
					$select_options[] = array( 'label' => $fields['label'] . ': ' . $tmp['label'], 'value' => $tmp['id'] );
				}
			break;

			default:
				$select_options[] = array( 'label' => $fields['label'], 'value' => $fields['id'] );
			break;
		}
	}

	return $select_options;
}


//Get a list of ALL Wordpress pages
function lct_select_options_get_pages( $hide, $type, $v ) {
	$args = array();
	$pages = get_pages( $args );

	if( ! $hide )
		$select_options[] = array( 'label' => '---', 'value' => '' );
	foreach( $pages as $page )
		$select_options[] = array( 'label' => $page->post_title . ' (ID: ' . $page->ID . ')', 'value' => $page->ID );

	return $select_options;
}


//Get a list of ALL Wordpress taxonomies
function lct_select_options_get_taxonomies( $hide, $type, $v ) {
	$args = array();
	$taxonomies = get_taxonomies( $args );

	if( ! $hide )
		$select_options[] = array( 'label'=>'---', 'value'=>'' );
	foreach( $taxonomies as $taxonomy )
		$select_options[] = array( 'label'=>$taxonomy, 'value'=>$taxonomy );

	return $select_options;
}


function lct_select_options_meta_key( $hide , $type, $v ) {
	if( ! $v['options_tax'] ) return;

	$meta_keys = explode( ",", ltm_get_ltm_settings( 'meta_keys_' . $v['options_tax'] ) );

	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---', 'value'=>'' );
	foreach( $meta_keys as $meta_key ) {
		$select_options[] = array( 'label'=>trim( $meta_key ), 'value'=>trim( $meta_key ) );
	}

	return $select_options;
}


//Get a list of ALL Wordpress taxonomies
function lct_select_options_get_raw_prefs( $hide, $type, $v ) {
	$prefs = array();
	$prefs[] = array( 'v' => 'wpautop', 'l' => 'Use the default Wordpress wpautop' );
	$prefs[] = array( 'v' => 'off', 'l' => 'Off: turn wpautop off sitewide.' );
	$prefs[] = array( 'v' => 'old', 'l' => 'Old: [raw] tag only works once.' );
	$prefs[] = array( 'v' => 'new', 'l' => '[raw] tags work multi time and only on content contained in tags.' );

	if( ! $hide )
		$select_options[] = array( 'label'=>'---', 'value'=>'' );
	foreach( $prefs as $pref )
		$select_options[] = array( 'label'=>$pref['l'], 'value'=>$pref['v'] );

	return $select_options;
}




//Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants
//Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants
//Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants
//Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants --- Constants
function lct_select_options_lct_user_timezone( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	$select_options[] = array( 'label'=>'Pacific' , 'value'=>'America/Los_Angeles' );
	$select_options[] = array( 'label'=>'Mountain' , 'value'=>'America/Denver' );
	$select_options[] = array( 'label'=>'Central' , 'value'=>'America/Chicago' );
	$select_options[] = array( 'label'=>'Eastern' , 'value'=>'America/New_York' );
	$select_options[] = array( 'label'=>'Mountain no DST' , 'value'=>'America/Phoenix' );
	$select_options[] = array( 'label'=>'Hawaii' , 'value'=>'America/Adak' );
	$select_options[] = array( 'label'=>'Hawaii no DST' , 'value'=>'Pacific/Honolulu' );
	$select_options[] = array( 'label'=>'Alaska' , 'value'=>'America/Anchorage' );
	return $select_options;
}


function lct_select_options_lct_standard_month( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	$select_options[] = array( 'label'=>'January' , 'value'=>'01' );
	$select_options[] = array( 'label'=>'February' , 'value'=>'02' );
	$select_options[] = array( 'label'=>'March' , 'value'=>'03' );
	$select_options[] = array( 'label'=>'April' , 'value'=>'04' );
	$select_options[] = array( 'label'=>'May' , 'value'=>'05' );
	$select_options[] = array( 'label'=>'June' , 'value'=>'06' );
	$select_options[] = array( 'label'=>'July' , 'value'=>'07' );
	$select_options[] = array( 'label'=>'August' , 'value'=>'08' );
	$select_options[] = array( 'label'=>'September' , 'value'=>'09' );
	$select_options[] = array( 'label'=>'October' , 'value'=>'10' );
	$select_options[] = array( 'label'=>'November' , 'value'=>'11' );
	$select_options[] = array( 'label'=>'December' , 'value'=>'12' );
	return $select_options;
}


function lct_select_options_lct_standard_day( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );

	for ($i = 1; $i <= 31; $i++){
		if($i<10)
			$value = '0'.$i;
		else
			$value = $i;
		$label = $i;

	    $select_options[] = array( 'label'=>$label , 'value'=>$value );
	}
	return $select_options;
}


function lct_select_options_lct_standard_year( $hide , $type, $v ) {
	$time = current_time( 'timestamp', 1 );
	$v['date_start'] ? $start = $v['date_start'] : $start = date( "Y", $time ) - 1;
	$v['date_end'] ? $end = $v['date_end'] : $end = date( "Y", $time ) + 3;

	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	for( $i = $start; $i <= $end; $i++ ) {
		$value = $i;
		$label = $i;

	    $select_options[] = array( 'label'=>$label , 'value'=>$value );
	}
	return $select_options;
}


function lct_select_options_lct_standard_hour( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );

	for ($i = 1; $i <= 12; $i++){
		if($i<10)
			$value = '0'.$i;
		else
			$value = $i;
		$label = $i;

	    $select_options[] = array( 'label'=>$label , 'value'=>$value );
	}
	return $select_options;
}


function lct_select_options_lct_standard_minute( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );

	for ($i = 0; $i <= 55; $i=$i+5){
		if($i<10){
			$value = '0'.$i;
			$label = '0'.$i;
		}else{
			$value = $i;
			$label = $i;
		}

	    $select_options[] = array( 'label'=>$label , 'value'=>$value );
	}
	return $select_options;
}


function lct_select_options_lct_standard_ampm( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	$select_options[] = array( 'label'=>'AM' , 'value'=>'AM' );
	$select_options[] = array( 'label'=>'PM' , 'value'=>'PM' );
	return $select_options;
}


function lct_select_options_states( $hide , $type, $v ){
	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	$select_options[] = array( 'label'=>'Maryland' , 'value'=>'MD' );
	$select_options[] = array( 'label'=>'Virginia' , 'value'=>'VA' );
	return $select_options;
}


function lct_select_options_store_hide_selected_gforms( $hide , $type, $v ) {
	$select_options = array();

	$options = array(
		0 => 'Don\'t store the selected forms',
		1 => 'Yes, store the selected forms',
	);

	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	foreach( $options as $k=>$v )
	  $select_options[] = array( 'label'=>$v , 'value'=>$k );

	return $select_options;
}


function lct_select_options_number( $hide , $type, $v ) {
	$select_options = array();
	$v['number_start'] ? $start = $v['number_start'] : $start = 1;
	$v['number_end'] ? $end = $v['number_end'] : $end = 1;
	$v['number_increment'] ? $increment = $v['number_increment'] : $increment = 1;

	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	for( $i = $start; $i <= $end; $i = $i + $increment ) {
		if( $i < 10 && $v['number_leading_zero'] )
			$value = '0'.$i;
		else
			$value = $i;
		$label = $i;

	    $select_options[] = array( 'label'=>$label , 'value'=>$value );
	}

	return $select_options;
}
