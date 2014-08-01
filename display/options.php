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
	if( ! $type ) return;

	//Clean up $type
	$f = array( "term_meta[", "]" );
	$r = array( "", "" );
	$type = str_replace( $f, $r, $type );

	if( ! isset( $v['options_tax'] ) ) $v['options_tax'] = lct_get_lct_useful_settings( 'Default_Taxonomy' );

	if( $default )
		return call_user_func( 'lct_select_options_default', $hide , $type, $v );

	return call_user_func( 'lct_select_options_' . $type, $hide , $type, $v );
}


//Get a list of ALL gravity forms
function lct_select_options_gravity_forms( $hide , $type, $v ) {
	$select_options = array();
	$forms = RGFormsModel::get_forms( null, 'title' );

	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );
	foreach( $forms as $form )
	  $select_options[] = array( 'label'=>$form->title , 'value'=>$form->id );

	return $select_options;
}


//Get a list of ALL fields for a single gravity form
function lct_select_options_gravity_forms_form_fields( $hide, $type, $v ) {
	$select_options = array();
	$form = RGFormsModel::get_form_meta( $v['gform_id'] );

	if( ! $hide )
		$select_options[] = array( 'label' => '---', 'value' => '' );
	foreach( $form['fields'] as $fields )
		$select_options[] = array( 'label' => $fields['label'], 'value' => $fields['id'] );

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
		$select_options[] = array( 'label' => '---', 'value' => '' );
	foreach( $taxonomies as $taxonomy )
		$select_options[] = array( 'label' => $taxonomy, 'value' => $taxonomy );

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


function lct_select_options_lct_standard_year( $hide , $type, $v ){
	$time = current_time( 'timestamp', 1 );

	$select_options = array();
	if( ! $hide ) $select_options[] = array( 'label'=>'---' , 'value'=>'' );

	for ($i = date("Y", $time); $i <= date("Y", $time)+3; $i++){
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
