<?php //Version: 1.2.5
//Globals
$g_labob = new g_labob;
class g_labob {
 	public $editzz						= 'editzz';
	public $pre							= 'labob_';
	public $dash						= 'lct-admin-bar-on-bottom';
	public $us							= 'lct_admin_bar_on_bottom';

	public function __construct() {
		$this->plugin_file				= __FILE__;
		$this->plugin_dir_url			= plugin_dir_url( __FILE__ );
		$this->plugin_dir_path			= plugin_dir_path( __FILE__ );
	}
}


add_action( 'admin_init', 'lct_admin_bar_on_bottom_back_css' );
function lct_admin_bar_on_bottom_back_css() {
	global $g_lusf;
	global $g_labob;
	$user = wp_get_current_user();

	if( get_the_author_meta( $g_labob->us . '_back', $user->ID ) )
		wp_enqueue_style( $g_labob->pre . 'back', $g_lusf->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'back.css' );

	wp_enqueue_style( $g_labob->pre . 'profile', $g_lusf->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'profile.css' );
}


add_action( 'wp_enqueue_scripts', 'lct_admin_bar_on_bottom_front_css' );
function lct_admin_bar_on_bottom_front_css() {
	global $g_lusf;
	global $g_labob;
	$user = wp_get_current_user();

	if( get_the_author_meta( $g_labob->us . '_front', $user->ID ) )
		wp_enqueue_style( $g_labob->pre . 'front', $g_lusf->plugin_dir_url . 'assets/css/' . $g_labob->pre . 'front.css' );
}


add_action( 'show_user_profile', $g_labob->us . '_extra_profile_fields' );
add_action( 'edit_user_profile', $g_labob->us . '_extra_profile_fields' );
function lct_admin_bar_on_bottom_extra_profile_fields( $user ) {
	global $g_labob; ?>

	<div id="lct-admin-bar-on-bottom">
		<h3>Admin Bar Settings (lct_admin_bar_on_bottom)</h3>

		<div class="setting-group">
			<h3>Put admin bar at the bottom of the browser window</h3>

			<table class="form-table">
				<tr>
					<th><label for="<?php echo $g_labob->us; ?>_front">Front-end</label></th>
					<td>
						<?php get_the_author_meta( $g_labob->us . '_front', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="<?php echo $g_labob->us; ?>_front" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
				<tr>
					<th><label for="<?php echo $g_labob->us; ?>_back">Back-end</label></th>
					<td>
						<?php get_the_author_meta( $g_labob->us . '_back', $user->ID ) ? $checked = 'checked="checked"' : $checked = ''; ?>
						<input type="checkbox" name="<?php echo $g_labob->us; ?>_back" value="1" <?php echo $checked; ?> />
					</td>
				</tr>
			</table>
		</div>
	</div>
<?php }


add_action( 'personal_options_update', 'save_' . $g_labob->us . '_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_' . $g_labob->us . '_extra_profile_fields' );
function save_lct_admin_bar_on_bottom_extra_profile_fields( $user_id ) {
	global $g_labob;
	if( ! current_user_can( 'edit_user', $user_id ) ) return false;

	update_usermeta( $user_id, $g_labob->us . '_front', $_POST[$g_labob->us . '_front'] );
	update_usermeta( $user_id, $g_labob->us . '_back', $_POST[$g_labob->us . '_back'] );
}
