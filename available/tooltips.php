<?php
//Prints required tooltip scripts
add_action( 'admin_print_scripts', 'lct_print_tooltip_scripts' );
function lct_print_tooltip_scripts() {
	$g_lusf = new g_lusf;
	$base_url = $g_lusf->plugin_dir_url;

	wp_enqueue_style( 'lct_tooltip', $base_url . "/assets/css/tooltip.css", null );
	wp_enqueue_style( 'lct_font_awesome', $base_url . "/assets/css/font-awesome.css", null );

	wp_print_scripts( 'lct_tooltip_init' );
	wp_print_styles( 'lct_tooltip', 'lct_font_awesome' );

}


global $__lct_tooltips;
$__lct_tooltips = array(
	'none' => __( 'None.', 'lct-useful-shortcodes-functions' ),
);


function lct_tooltip( $name, $css_class = '', $return = false ) {
	global $__lct_tooltips; //declared as global to improve WPML performance

	$css_class     = empty( $css_class ) ? 'tooltip' : $css_class;
	$__lct_tooltips = apply_filters( 'lct_tooltips', $__lct_tooltips );

	//AC: the $name parameter is a key when it has only one word. Maybe try to improve this later.
	$parameter_is_key = count( explode( ' ', $name ) ) == 1;

	$tooltip_text  = $parameter_is_key ? rgar( $__lct_tooltips, $name ) : $name;
	$tooltip_class = isset( $__lct_tooltips[ $name ] ) ? "tooltip_{$name}" : '';
	$tooltip_class = esc_attr( $tooltip_class );

	if ( empty( $tooltip_text ) ) {
		return '';
	}

	$tooltip = "<a href='#' onclick='return false;' class='lct_tooltip " . esc_attr( $css_class ) . " {$tooltip_class}' title='" . esc_attr( $tooltip_text ) . "'><i class='fa fa-question-circle'></i></a>";

	if ( $return ) {
		return $tooltip;
	} else {
		echo $tooltip;
	}
}
