<?php
add_action( 'lct_login_css', 'lct_login_css' );
function lct_login_css() {
	$g_lct = new g_lct;

	wp_register_style( 'lct_login_css', $g_lct->plugin_dir_url . 'assets/css/login.css' );
	wp_enqueue_style( 'lct_login_css' );
}


function getLostLink( $c ) {
	$params = [ 'action' => "lostpassword" ];
	$url = add_query_arg( $params, get_permalink() );

	return $url;
}

add_filter( 'lostpassword_url', 'getLostLink' );


function logout_redirect( $c ) {
	$params = [ 'redirect_to' => get_permalink() ];
	$url = add_query_arg( $params, $c );

	return $url;
}

add_filter( 'logout_url', 'logout_redirect' );


function retrieve_my_password() {
	global $wpdb, $current_site;

	$errors = new WP_Error();

	if( empty( $_POST['user_login'] ) ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or e-mail address.' ) );
	} else
		if( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
			if( empty( $user_data ) )
				$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no user registered with that email address.' ) );
		} else {
			$login = trim( $_POST['user_login'] );
			$user_data = get_user_by( 'login', $login );
		}

	do_action( 'lostpassword_post' );

	if( $errors->get_error_code() )
		return $errors;

	if( ! $user_data ) {
		$errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: Invalid username or e-mail.' ) );

		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action( 'retreive_password', $user_login ); // Misspelled and deprecated
	do_action( 'retrieve_password', $user_login );

	$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	if( ! $allow )
		return new WP_Error( 'no_password_reset', __( 'Password reset is not allowed for this user' ) );
	else
		if( is_wp_error( $allow ) )
			return $allow;

	$key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );
	if( empty( $key ) ) {
		// Generate something random for a key...
		$key = wp_generate_password( 20, false );
		do_action( 'retrieve_password_key', $user_login, $key );
		// Now insert the new md5 key into the db
		$wpdb->update( $wpdb->users, [ 'user_activation_key' => $key ], [ 'user_login' => $user_login ] );
	}
	$message = __( 'Someone requested that the password be reset for the following account:' ) . "\r\n\r\n";
	$message .= network_site_url() . "\r\n\r\n";
	$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
	$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
	$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
	$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";

	if( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else // The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.

		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

	$title = sprintf( __( '[%s] Password Reset' ), $blogname );

	$title = apply_filters( 'retrieve_password_title', $title );
	$message = apply_filters( 'retrieve_password_message', $message, $key );

	if( $message && ! wp_mail( $user_email, $title, $message ) ) {

		$errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: The e-mail could not be sent. <br /> Possible reason: your host may have disabled the mail() function...' ) );

		return $errors;
	}

	return true;
}


function displayForm( $atts ) {
	do_action( 'lct_login_css' );

	if( isset( $_POST['submit'] ) ) {
		if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			$creds = [ ];
			$creds['user_login'] = $_POST['username'];
			$creds['user_password'] = $_POST['password'];
			$creds['remember'] = true;

			$user = wp_signon( $creds, false );
			if( is_wp_error( $user ) )
				$jerror = '<div class="jerror">' . $user->get_error_message() . '</div>';
		} else {
			$jerror = '<div class="jerror">Enter Username and password.</div>';
		}
	}

	//Password retrive section
	if( isset( $_POST['user_login'] ) ) {
		$result = retrieve_my_password();
		if( is_wp_error( $result ) )
			$jerror = '<div class="jerror">' . $result->get_error_message() . '</div>';
	}


	if( isset( $_GET['action'] ) && ! is_user_logged_in() ) { ?>
		<section id="contentForm">
			<!--form name="lostpasswordform" id="lostpasswordform" action="<?php echo home_url( '/' ); ?>/wp-login.php?action=lostpassword" method="post"-->
			<form name="lostpasswordform" id="lostpasswordform" action="" method="post">
				<h1>Reset</h1>

				<div>
					<input type="text" name="user_login" id="user_login" placeholder="Username or E-mail" value="" required="" size="20" tabindex="10"></label>
				</div>
				<div>
					<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Get Password" tabindex="100">
					<a href="<?php echo get_permalink(); ?>">Login Now</a>
				</div>
			</form>
		</section><!-- content -->


	<?php } else if( ! is_user_logged_in() ) {


		if( function_exists( 'presscore_get_logo_image' ) && lct_get_lct_useful_settings( 'lct_show_login_logo' ) ) {
			if( $bottom_logo = presscore_get_logo_image( presscore_get_header_logos_meta() ) ) {
				echo "<p class='login_logo'>$bottom_logo</p>";
			}
		}

		if( ! $bottom_logo && lct_get_lct_useful_settings( 'lct_show_login_logo' ) && lct_get_lct_useful_settings( 'lct_login_logo' ) ) {
			echo "<p class='login_logo'><img src='" . lct_get_lct_useful_settings( 'lct_login_logo' ) . "' /></p>";
		} ?>

		<?php echo $jerror; ?>
		<section id="contentForm">
			<form name="loginform" id="loginform" action="" method="post">

				<?php if( lct_get_lct_useful_settings( 'lct_tag_line' ) && lct_get_lct_useful_settings( 'lct_show_tag_line' ) ) {
					echo "<h1>" . lct_get_lct_useful_settings( 'lct_tag_line' ) . "</h1>";
				} elseif( get_bloginfo( 'description' ) && lct_get_lct_useful_settings( 'lct_show_tag_line' ) ) {
					echo "<h1>" . get_bloginfo( 'description' ) . "</h1>";
				} else {
					echo "<h1></h1>";
				} ?>

				<div>
					<input type="text" placeholder="USER" value="" id="username" name="username" />
				</div>
				<div>
					<input type="password" placeholder="PASSWORD" value="" id="password" name="password" />
				</div>
				<div>
					<input type="submit" value="Login" name="submit" id="submit" style="display: none;" />

					<p>
						<a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>

						<?php if( lct_get_lct_useful_settings( 'lct_show_register_link' ) ) { ?>
							&nbsp;<span class="hide-a-pipe">|</span>
							<a href="/<?php echo the_slug( lct_get_lct_useful_settings( 'lct_register_page' ) ); ?>">New to <?php echo get_bloginfo( 'name' ); ?>?</a>
						<?php } ?>
					</p>
				</div>
				<?php if( lct_get_lct_useful_settings( 'lct_show_login_footer' ) ) {
					if( lct_get_lct_useful_settings( 'lct_login_footer' ) ) {
						echo '<div style="margin-top: 30px;"><p>';
						echo lct_get_lct_useful_settings( 'lct_login_footer' );
						echo '</p></div>';
					} else if( function_exists( 'of_get_option' ) ) {
						if( $credits = of_get_option( 'bottom_bar-copyrights', false ) ) { ?>
							<div style="margin-top: 30px;">
								<p><?php echo $credits ?></p>
							</div>
						<?php }
					}
				} ?>
			</form>
			<!-- form -->

		</section><!-- content -->

		<script>
			var $login = jQuery.noConflict();
			$login( window ).load( function() {
				if( $login( '#username' ).val() != 'USER' && $login( '#username' ).val() != '' )
					$login( '#submit' ).show();
				else
					$login( '#submit' ).hide();

				$login( '#username' ).keyup( function() {
					if( $login( '#username' ).val() != 'USER' && $login( '#username' ).val() != '' )
						$login( '#submit' ).show();
					else
						$login( '#submit' ).hide();
				} );
			} );
		</script>


	<?php } else if( is_user_logged_in() ) {

		if( $redirect = lct_get_lct_useful_settings( 'lct_login_redirect' ) ) {
			if( $_GET['redirect_to'] )
				$redirect = $_GET['redirect_to'];

			$script = '<script type="text/javascript">
				window.location = "' . $redirect . '"
		    </script>';

			echo $script;
			die();
		}


		$current_user = wp_get_current_user();

		echo '<section id="contentForm">';
		echo '<form method="post"><h1>Profile</h1>';
		echo '<div>' . get_avatar( $current_user->user_email, 200 );
		'</div> <br />';
		echo '<div>Username: ' . $current_user->user_login . '</div><br />';
		echo '<div>User email: ' . $current_user->user_email . '</div><br />';
		echo '<div>User first name: ' . $current_user->user_firstname . '</div><br />';
		echo '<div>User last name: ' . $current_user->user_lastname . '</div><br />';
		echo '<div>User display name: ' . $current_user->display_name . '</div><br />';
		echo '<div><a href="' . wp_logout_url() . '" title="Logout">Logout</a><br /></div></form>';
		echo '</section>';


	}
}

add_shortcode( 'login_form', 'displayForm' );
