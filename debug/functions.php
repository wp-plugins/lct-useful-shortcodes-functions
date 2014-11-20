<?php
//Used instead of print_r() function. It gives you a better understnading of how array's are laid out.
if( ! function_exists( 'P_R' ) ) {
	function P_R( $var, $name = 'Name Not Set', $return = false ) {
		if( ! is_user_logged_in() ) return;

		$skip = array( 'HTTP_COOKIE' );

		$c = 'odd';

		$h = '';
		$h .= '<table class="P_R" style="max-width: 1000px;width: 100%;margin: 0 auto;">';
		$h .= '<tr><th class="' . $c . '" colspan="2">' . $name . '</th></tr>';

		foreach( $var as $k => $v ) {
			if( in_array( $k, $skip ) && $k !== 0 ) continue;

			if( $c == 'even' )
				$c = 'odd';
			else
				$c = 'even';

			$h .= '<tr>';
			$h .= '<td class="' . $c . '">';
			$h .= $k;
			$h .= '</td>';
			$h .= '<td class="' . $c . '">';

			if( is_array( $v ) ) {
				$h .= '<table style="width:100%;margin:0 auto;">';
				foreach( $v as $k2 => $v2 ) {
					if( $c2 == 'even' )
						$c2 = 'odd';
					else
						$c2 = 'even';

					$h .= '<tr>';
					$h .= '<td class="' . $c2 . '">';
					$h .= $k2;
					$h .= '</td>';
					$h .= '<td class="' . $c2 . '">';

					if( is_array( $v2 ) ) {
						$h .= '<pre>';
						$h .= print_r( $v2, true );
						$h .= '</pre>';
					} else
						$h .= $v2;

					$h .= '</td>';
					$h .= '</tr>';
				}

				$h .= '</table>';
			} else
				$h .= $v;

			$h .= '</td>';
			$h .= '</tr>';
		}

		if( ! $var )
			$h .= '<tr><td class="' . $c . '">none</td></tr>';

		$h .= '</table>';

		$h .= P_R_STYLE();

		if( $return === true )
			return $h;

		echo $h;

		if( $return === 'exit' )
			exit;
	}
}

//For Objects - Used instead of print_r() function. It gives you a better understnading of how array's are laid out.
if( ! function_exists( 'P_R_O' ) ) {
	function P_R_O( $var ) {
		echo '<pre>';
		print_r( $var );
		echo '</pre>';
	}
}


//Creates the table styling for the P_R function
if( ! function_exists( 'P_R_STYLE' ) ) {
	function P_R_STYLE() {
		$style = '<style>
		.P_R p{
			text-align: center;
			margin: 0;
			padding: 0;
		}

		.P_R input[type="file"]{
			border: 1px solid #BBB;
		}

		.P_R td{
			padding: 5px;
			margin: 2px 15px;
		}

		.P_R .even{
			background-color: #aaa;
		}

		.P_R .odd{
			background-color: #ccc;
		}
		</style>';
		return $style;
	}
}


//A quick solution for echo when debuging.
function echo_br( $value, $label = '', $position = 'before' ){
	if( $position == 'before' || $position == 'both' )
		echo '<br />';

	echo $label . ' : ' . $value;

	if( $position == 'after' || $position == 'both')
		echo '<br />';
}


function lca_debug_to_console( $data ) {
    $bt = debug_backtrace();
    $caller = array_shift( $bt );

    if( is_array( $data ) )
        error_log( '_editzz: ' . end( split( '/', $caller['file'] ) ) . ':' . $caller['line'] . ' => ' . implode( ',', $data ) );
    else
        error_log( '_editzz: ' . end( split( '/', $caller['file'] ) ) . ':' . $caller['line'] . ' => ' . $data );
}
