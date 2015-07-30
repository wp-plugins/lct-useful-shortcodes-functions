<?php
add_shortcode( 'lct_css', 'lct_css' );
add_shortcode( 'theme_css', 'lct_css' );
add_shortcode( 'lct_js', 'lct_css' );
add_shortcode( 'theme_js', 'lct_css' );
/**
 * [lct_css file="{file_name}" write="{whether you want to write the css to the page or just add a link to it}"]
 * Grab some custom css when this shortcode is called
 * *
 * You can also use shortcode:
 * theme_css
 *
 * @param $a
 *
 * @return bool|string
 */
function lct_css( $a, $content = null, $shortcode ) {
	extract(
		shortcode_atts(
			[
				'file'  => null,
				'write' => false,
			],
			$a
		)
	);

	if( empty( $file ) )
		return false;

	if( empty( $write ) )
		$write = false;

	global $g_lct;

	$type = '';

	switch( $shortcode ) {
		case 'theme_css':
			$type = 'css';
			$base = '/custom/' . $type . '/';
			$path = lct_path_theme() . $base;
			$url = lct_url_theme() . $base;
			break;


		case 'lct_css':
			$type = 'css';
			$base = 'lct/' . $type . '/';
			$path = $g_lct->plugin_dir_path . $base;
			$url = $g_lct->plugin_dir_url . $base;
			break;


		case 'theme_js':
			$type = 'js';
			$base = '/custom/' . $type . '/';
			$path = lct_path_theme() . $base;
			$url = lct_url_theme() . $base;
			break;


		case 'lct_js':
			$type = 'js';
			$base = 'lct/' . $type . '/';
			$path = $g_lct->plugin_dir_path . $base;
			$url = $g_lct->plugin_dir_url . $base;
			break;

		default:
	}

	$args = [
		'file'  => $file,
		'type'  => $type,
		'base'  => $base,
		'path'  => $path,
		'url'   => $url,
		'write' => $write
	];

	$return = lct_shortcode_file_processor( $args );

	return $return;
}


function lct_shortcode_file_processor( $a ) {
	$return = '';

	$f = [
		'full' => $a['file'] . '.' . $a['type'],
		'min'  => $a['file'] . '.min.' . $a['type'],
	];

	$loc = [
		'min_path'  => $a['path'] . $f['min'],
		'min_url'   => $a['url'] . $f['min'],
		'full_path' => $a['path'] . $f['full'],
		'full_url'  => $a['url'] . $f['full']
	];

	$file_path = $loc['min_path'];
	$file_url = $loc['min_url'];

	if( ! file_exists( $loc['min_path'] ) ) {
		if( ! file_exists( $loc['full_path'] ) )
			return false;

		$file_path = $loc['full_path'];
		$file_url = $loc['full_url'];
	}

	switch( $a['type'] ) {
		case 'css' :
			$tag = 'style';
			break;


		case 'js' :
			$tag = 'script';
			break;

		default:
	}


	if( $a['write'] == true ) {
		$return .= "<{$tag}>";
		$return .= file_get_contents( $file_path );
		$return .= "</{$tag}>";;
	} else {
		switch( $a['type'] ) {
			case 'css' :
				$return .= '<link rel="stylesheet" type="text/css" href="' . $file_url . '">';
				break;


			case 'js' :
				$return .= '<script type="text/javascript" src="' . $file_url . '"></script>';
				break;

			default:
		}
	}

	return $return;
}
