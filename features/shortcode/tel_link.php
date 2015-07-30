<?php
if( ! defined( 'ABSPATH' ) ) {
	die();
}

if( ! defined( 'LCT_CURRENT_PAGE' ) ) {
	define( 'LCT_CURRENT_PAGE', basename( $_SERVER['PHP_SELF'] ) );
}

if( ! defined( 'IS_ADMIN' ) ) {
	define( 'IS_ADMIN', is_admin() );
}


add_action( 'init', [ 'LCT_SC_tel_link', 'init' ] );
add_action( 'plugins_loaded', [ 'LCT_SC_tel_link', 'loaded' ] );


class LCT_SC_tel_link {
	public static function loaded() {
	}


	//Plugin starting point. Will load appropriate files
	public static function init() {
		self::register_scripts();

		add_shortcode( 'lct_tel_link', [ 'LCT_SC_tel_link', 'add_shortcode' ] );

		if( IS_ADMIN ) {
			add_action( 'admin_enqueue_scripts', [ 'LCT_SC_tel_link', 'enqueue_admin_scripts' ] );
			add_action( 'print_media_templates', [ 'LCT_SC_tel_link', 'action_print_media_templates' ] );

			//Adding "embed Tel Link" button
			add_action( 'media_buttons', [ 'LCT_SC_tel_link', 'add_tel_link_button' ], 20 );

			if( self::page_supports_add_tel_link_button() ) {
				add_action( 'admin_footer', [ 'LCT_SC_tel_link', 'add_mce_popup' ] );
			}
		}
	}

	public static function register_scripts() {
		$g_lct = new g_lct;
		$base_url = $g_lct->plugin_dir_url;

		wp_register_script( 'lct_tooltip_init', $base_url . "/assets/js/tooltip_init.js", [ 'jquery-ui-tooltip' ], false );

		wp_register_script( 'LCT_SC_tel_link_shortcode_ui', $base_url . "/assets/js/shortcode_tel_link-shortcode-ui.js", [ 'jquery', 'wp-backbone' ], false, true );
		wp_register_style( 'LCT_SC_tel_link_shortcode_ui', $base_url . "/assets/css/shortcode_tel_link-shortcode-ui.css", [ ], false );
	}

	public static function page_supports_add_tel_link_button() {
		$is_post_edit_page = in_array( LCT_CURRENT_PAGE, [ 'post.php', 'page.php', 'page-new.php', 'post-new.php' ] );

		return $is_post_edit_page;
	}

	public static function add_shortcode( $a ) {
		extract(
				shortcode_atts(
						[
								'phone'    => null,
								'action'   => null,
								'category' => 'tel_link',
								'class'    => null,
								'pre'      => null,
								'post'     => null,
								'text'     => null,
						],
						$a
				)
		);

		if( empty( $phone ) )
			return false;

		if( empty( $action ) )
			$action = $phone;

		if( ! empty( $class ) )
			$class = " class=\"{$class}\"";

		if( ! empty( $pre ) )
			$pre = "{$pre} ";

		if( ! empty( $post ) )
			$post = " {$post}";

		if( empty( $text ) )
			$text = $pre . $phone . $post;

		$stripped_phone = preg_replace( '/[^0-9]/', '', $phone );

		$href = "href=\"tel:{$stripped_phone}\"";

		$onclick = "onclick=\"_gaq.push(['_trackEvent', '{$category}', '{$action}'])\"";

		$tel_link = "<a {$href} {$onclick}{$class}>{$text}</a>";

		return $tel_link;
	}


	//Action target that adds the 'Insert a Tel Link' button to the post/page edit screen

	public static function enqueue_admin_scripts( $hook ) {
		$scripts = [ ];

		if( self::page_supports_add_tel_link_button() ) {
			$g_lct = new g_lct;

			require_once( $g_lct->plugin_dir_path . '/available/tooltips.php' );

			wp_enqueue_script( 'LCT_SC_tel_link_shortcode_ui' );
			wp_enqueue_style( 'LCT_SC_tel_link_shortcode_ui' );
			wp_localize_script( 'LCT_SC_tel_link_shortcode_ui', 'lctShortcodeUIData', [
					'shortcodes'      => self::get_shortcodes(),
					'previewNonce'    => wp_create_nonce( 'LCTSCtellink-shortcode-ui-preview' ),
					'previewDisabled' => true,
					'strings'         => [
							'pleaseEnterAPhone'   => esc_html__( 'Please enter a phone number.', 'lct-useful-shortcodes-functions' ),
							'errorLoadingPreview' => esc_html__( 'Failed to load the preview for this phone number.', 'lct-useful-shortcodes-functions' ),
					]
			] );
		}

		if( empty( $scripts ) ) {
			return;
		}

		foreach( $scripts as $script ) {
			wp_enqueue_script( $script );
		}

	}


	//Action target that displays the popup to insert a Tel Link to a post/page

	public static function get_shortcodes() {
		$default_attrs = [
				[
						'label'       => 'Phone Number',
						'attr'        => 'phone',
						'type'        => 'text',
						'section'     => 'required',
						'description' => __( "Be sure to INCLUDE the desired formatting.", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'Specify the phone number you are creating the link for. Ex: (970) 555-1234 or 970.555.1234', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'Link Class',
						'attr'        => 'class',
						'type'        => 'text',
						'section'     => 'standard',
						'description' => __( "(optional)", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'Use this to add custom css class to your link', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'Text before the phone number',
						'attr'        => 'pre',
						'type'        => 'text',
						'section'     => 'standard',
						'description' => __( "(optional)", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'Use this to add some link text before the phone number.', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'Text after the phone number',
						'attr'        => 'post',
						'type'        => 'text',
						'section'     => 'standard',
						'description' => __( "(optional)", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'Use this to add some link text after the phone number.', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'Link Text Override',
						'attr'        => 'text',
						'type'        => 'text',
						'description' => __( "Use this to override the default Link text that this shortcode creates.", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'Use this to override the default Link text that this shortcode creates.', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'GATC Action',
						'attr'        => 'action',
						'type'        => 'text',
						'description' => __( "ONLY change this if you do NOT want the action in Google Analytics to be '{pre} {phone} {post}'. See tooltip for more info.", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'See this for more info: <a href="https://developers.google.com/analytics/devguides/collection/gajs/methods/gaJSApiEventTracking">Google Analytics Tracking Code: Event Tracking</a>', 'lct-useful-shortcodes-functions' )
				],
				[
						'label'       => 'GATC Category',
						'attr'        => 'category',
						'type'        => 'text',
						'description' => __( "ONLY change this if you do NOT want the category in Google Analytics to be 'tel_link'. See tooltip for more info.", 'lct-useful-shortcodes-functions' ),
						'tooltip'     => __( 'See this for more info: <a href="https://developers.google.com/analytics/devguides/collection/gajs/methods/gaJSApiEventTracking">Google Analytics Tracking Code: Event Tracking</a>', 'lct-useful-shortcodes-functions' )
				],
		];

		$shortcode = [
				'shortcode_tag' => 'lct_tel_link',
				'action_tag'    => '',
				'label'         => 'Tel Link',
				'attrs'         => $default_attrs,
		];

		$shortcodes[] = $shortcode;

		return $shortcodes;
	}

	public static function add_tel_link_button() {
		$is_add_tel_link_page = self::page_supports_add_tel_link_button();

		if( ! $is_add_tel_link_page ) {
			return;
		}

		// display button matching new UI
		echo ' <style></style>

		<a href="#" class="button LCT_SC_tel_link_media_link" id="add_LCT_SC_tel_link" title="' . esc_attr__( 'Add Tel Link', 'lct-useful-shortcodes-functions' ) . '">
			<div>' . esc_html__( 'Add Tel Link', 'lct-useful-shortcodes-functions' ) . '</div>
		</a>';
	}

	public static function add_mce_popup() { ?>
		<div id="select_LCT_SC_tel_link" style="display:none;">
			<div id="LCT_SC_tel_link-shortcode-ui-wrap" class="wrap">
				<div id="LCT_SC_tel_link-shortcode-ui-container"></div>
			</div>
		</div>
	<?php }

	public static function action_print_media_templates() {
		echo LCT_SC_tel_link::get_view( 'shortcode_tel_link-edit-shortcode-form' );
	}


	public static function get_view( $template ) {
		if( ! file_exists( $template ) ) {
			$g_lct = new g_lct;
			$template_dir = $g_lct->plugin_dir_path . '/templates/';

			$template = $template_dir . $template . '.tpl.php';

			if( ! file_exists( $template ) ) {
				return '';
			}
		}

		ob_start();
		include $template;

		return ob_get_clean();
	}
}
