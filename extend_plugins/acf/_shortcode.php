<?php
add_shortcode( 'lct_copyright', 'lct_shortcode_copyright' );
/**
 * [lct_copyright]
 * Create some copyright text based on the easy to use ACF form
 * @return bool|mixed
 */
function lct_shortcode_copyright() {
	$prefix = 'lct';
	$prefix_2 = 'sc::';
	$fields = lct_acf_get_mapped_fields( null, $prefix, null, true, $prefix_2 );

	if( ! $fields["use_this_shortcode"][0] )
		return false;

	if( $fields['title_link_blank'][0] == 1 )
		$target = 'target="_blank"';
	else
		$target = '';

	if( $fields['link_title'][0] == 1 && $fields['title_link'] && ( $fields['no_single_link'][0] != 1 || ( $fields['no_single_link'][0] == 1 && ! is_single() ) ) )
		$title = "<a href='{$fields['title_link']}' {$target}>{$fields['title']}</a>";
	else
		$title = $fields['title'];

	$find_n_replace = [
		'{copy_symbol}'  => '&copy;',
		'{year}'         => date( 'Y', current_time( 'timestamp', 1 ) ),
		'{title}'        => $title,
		'{builder_plug}' => $fields['builder_plug'],
		'{XML_sitemap}'  => "<a href='{$fields['xml']}'>XML Sitemap</a>"
	];

	$fnr = lct_create_find_and_replace_arrays( $find_n_replace );

	$copyright = str_replace( $fnr['find'], $fnr['replace'], $fields['copyright_layout'] );

	return $copyright;
}
