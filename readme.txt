=== LCT Useful Shortcodes & Functions ===
Contributors: ircary
Donate link: http://lookclassy.com/
Stable tag: 4.3.7
Requires at least: 3.5
Tested up to: 4.3
Tags: Functions, Shortcodes
License: GPLv3 or later
License URI: http://opensource.org/licenses/GPL-3.0

Shortcodes & Functions that will help make your life easier.

== Description ==
Shortcodes & Functions that will help make your life easier.

<h4>Site URL Shortcode == [url_site]</h4>
Use this to get youu site URL with a shortcode. EX: if your site was http://www.example.com/, then [url_site] would return http://www.example.com/


<h4>Theme URL Shortcode == [url_theme]</h4>
Use this to get the URL of your theme with a shortcode. This comes in handy when you want to add an image that is stored in your theme folder.

EX: if your site was http://www.example.com/ and your theme folder was my-theme, then [url_theme] would return http://www.example.com/wp-content/themes/my-theme


<h4>Upload folder URL Shortcode == [up]</h4>
Use this to get the URL of your uploads folder with a shortcode. This comes in handy when you want to add an image to a widget that is stored in your uploads folder.

EX: if your site was http://www.example.com/, then [up] would return http://www.example.com/wp-content/uploads


<h4>Upload folder Path Shortcode == [up_root]</h4>
Use this to get the path of your uploads folder with a shortcode. This comes in handy when you want to run file_exists function for an item that is stored in your uploads folder.

EX: if your site was http://www.example.com/ and you public_html folder was located at /home/mysite/public_html/, then [up_root] would return /home/mysite/public_html/wp-content/uploads


<h4>is_blog() Function</h4>
You can call this to check if the page you are on is a blogroll or single post.


<h4>Tel Link Shortcode</h4>
Syntax:
[lct_tel_link phone='{REQUIRED, with formatting}' action='{defaults to "tel_link", but you can change it in the advanced options}' category='{defaults to "{pre} {phone} {post}", but you can change it in the advanced options}' class='{optional}' pre='{optional pre text}' post='{optional post text}' text='{optional link text override}']
converts to
<a class="{class}" href="tel:{phone}" onclick="_gaq.push(['_trackEvent', '{category}', '{action}'])">{pre} {phone} {post}</a>

Examples:
(Basic)
[lct_tel_link phone='(970) 555-1234']
converts to
<a href="tel:9705551234" onclick="_gaq.push(['_trackEvent', 'tel_link', '(970) 555-1234'])">(970) 555-1234</a>

(Advanced)
[lct_tel_link phone='(970) 555-1234' action='My Custom Action' category='Something_NOT_tel_link' class='button' pre='before number:' post='after the number.']
converts to
<a class="button" href="tel:9705551234" onclick="_gaq.push(['_trackEvent', 'Something_NOT_tel_link', 'My Custom Action'])">before number: (970) 555-1234 after the number.</a>

(Link Text Override)
[lct_tel_link phone='(970) 555-1234' text='Link Text Here']
converts to
<a href="tel:9705551234" onclick="_gaq.push(['_trackEvent', 'tel_link', '(970) 555-1234'])">Link Text Here</a>


== Installation ==
1. Upload the zip file contents to your Wordpress plugins directory.
2. Go to the Plugins page in your WordPress Administration area and click 'Activate' for LCT Useful Shortcodes & Functions.

== Screenshots ==
none

== Frequently Asked Questions ==
none


== Upgrade Notice ==
none


== Changelog ==
= 4.3.7 =
	- Tweaked acf.css

= 4.3.6 =
	- Added lct_maintenance_Avada_fix()

= 4.3.5 =
	- Added: add_filter( 'itsec_filter_server_config_file_path', 'lct_itsec_filter_server_config_file_path', 10, 2 );
	- Fixed buggy lct_path_site_wp()

= 4.3.4 =
	- Added strpos_array()

= 4.3.3 =
	- Fixed a bug that will now redirect to the lct directory to check if a file exists and then it will return false. lct_js_uploads_dir() & lct_css_uploads_dir()

= 4.3.2 =
	- Added lct_avada_save_options() to do_action( 'avada_save_options' );
	- Fixed bug that was showing an empty admin bar to visitors

= 4.3.1 =
	- Added shortcode [theme_css]
	- Cleaned up some code bugs in /misc/shortcodes.php
	- Stopped saving lct directory in uploads when the plugin is activated
	- Deprecated lct_get_test()
	- Deprecated lct_php()
	- Deprecated lct_copyyear()
	- Moved /misc/shortcodes.php TO /features/shortcode/shortcode.php
	- Moved /features/lct_post_content_shortcode/index.php TO /features/shortcode/lct_post_content.php
	- Moved /features/shortcode_tel_link.php TO /features/shortcode/tel_link.php
	- Moved /features/misc_functions.php TO /features/function/_function.php
	- Changed all lusf to lct
	- Code Reformat plugin wide
	- Deprecated lct_css_uploads_dir()
	- Deprecated lct_js_uploads_dir()
	- Moved lct_theme_css() into file_processor.php
	- Finished lct_shortcode_file_processor()
	- Added shortcode [lct_css] that grab files from the lct-useful-shortcodes-functions plugin directory
	- Added shortcode [lct_js] that grab files from the lct-useful-shortcodes-functions plugin directory
	- gforms.css tweaks
	- Added add_filter( 'avada_blog_read_more_excerpt', 'lct_acf_avada_blog_read_more_excerpt' );
	- Added ACF Group Theme Settings: Avada
	- Added Fix/Cleanup 'DB Fix::: Add Post Meta to Multiple Posts'
	- Removed lct_acf_get_fields_mapped()
	- Removed lct_acf_get_mapped_fields_of_object()

= 4.3 =
	- WP v4.2.3 Ready
	- Added shortcode.php to ACF
	- Added $prefix_2 to lct_acf_get_fields_by_parent()
	- Added lct_acf_get_mapped_fields()
	- Added Shortcode [lct_copyright]
	- Added lct_acf_get_mapped_fields_of_object()
	- Added lct_acf_get_fields_by_object()
	- Added Shortcodes group to lct_acf_op_main_settings

= 4.2.2.27 =
	- Moved: lct_remove_admin_bar() to lct_show_admin_bar(), under /acf/filter.php
	- Modified lct_show_admin_bar() so that it will be a dynamic setting in LCT Useful ACF, rather than being hard coded.
	- Updated fields in lct_acf_op_main_settings_groups.php to support lct_show_admin_bar()

= 4.2.2.26 =
	- Added: add_filter( 'acf/load_field/type=radio', 'lct_acf_options_check_show_params' );
	- Updated acf.css
	- Modified Fixes and cleanups
	- Completed: TODO: cs - Make this dynamic - 7/23/2015 12:08 AM By adding lct_acf_get_fields_by_parent()\
	- Added lct_acf_recap_field_settings()
	- Added lct_acf_create_table()
	- Added lct_acf_field_groups_columns()
	- Added lct_acf_field_groups_columns_values()
	- Added lct_acf_acf_export_title_mod()
	- Fixed tel_link version bug.
	- Added lct_create_find_and_replace_arrays()
	- Code refactoring
	- acf.css update
	- Added local groups
	- Updated import for:
			- options_page__lct_settings_main_acf_settings___general_settings__lct.json
			- options_page__lct_settings_main_acf_fixes_and_cleanups___db_fix_add_taxonomy_field_data_to_old_entries.json

= 4.2.2.25 =
	- Added extend_plugin dir, now we can properly include functions. But only is the plugin is loaded up first. YAY!
	- Added support for plugin acf
	- changed instances of lca to lct
	- Added lct_acf_print_scripts()
	- Added wp-admin css
	- Added Function to create fixed and clean ups
	- Added a New ACF Fix/Cleanup (db_fix_add_taxonomy_field_data)
	- Added import for:
		- lct_settings_main_acf_fixes_and_cleanups -- DB Fix Add taxonomy field data to old entries.json
		- lct_settings_main_acf_settings -- General Settings.json

= 4.2.2.24 =
	- Added lct_get_dev_emails() function
	- Added lct_is_user_a_dev() function
	- Change C:/s to W:/wamp

= 4.2.2.23 =
	- Added disable_auto_set_user_timezone feature
	- Reformat code

= 4.2.2.22 =
	- Added target as an att to the shortcode lct_shortcode_link()

= 4.2.2.21 =
	- Added query as an att to the shortcode lct_shortcode_link()

= 4.2.2.20 =
	- Added Shortcode lct_post_content_shortcode()
	- Added lct_is_in_url()

= 4.2.2.19 =
	- Updated front.css

= 4.2.2.18 =
	- Reworked all the code for lct_shortcode_link()

= 4.2.2.17 =
	- added lct_tel_link shortcode

= 4.2.2.16 =
	- Added lct_close_all_pings_and_comments()

= 4.2.2.14 - 4.2.2.15 =
	- Fixed up functions to be better:
		- lct_select_options()
		- lct_select_options_default()
		- lct_get_select_blank()

= 4.2.2.13 =
	- Moved lct_select_options_meta_key() to deprecated
	- added lct_get_select_blank() in display/options.php
	- reformatted code in display/options.php

= 4.2.2.11 - 4.2.2.12 =
	- Tweaks to gforms CSS
	- Tweaks to css

= 4.2.2.10 =
	- Tweaks to lct_remove_site_root

= 4.2.2.9 =
	- Minor Tweaks

= 4.2.2.5 - 4.2.2.8 =
	- ADDED Cleanup Guid

= 4.2.2.4 =
	- Debug function tweaks

= 4.2.2.2 - 4.2.2.3 =
	- Additions to Avada.css

= 4.2.2.1 =
	- Additions to Avada.css
	- ADDED to gforms.css

= 4.2.2 =
	- WP 4.2.2 Ready
	- Additions to front.css

= 4.2.1.3 =
	- Minor Tweaks

= 4.2.1.2 =
	- Updated to iFrame Resizer v2.8.6
	- Code cleanup

= 4.2.1.1 =
	- Avada.css Tweaks

= 4.2.1 =
	- WP 4.2.1 Ready

= 4.1.26 =
	- Removed labob
	- WP v4.2 Ready

= 4.1.25 =
	- Removed CRLF

= 4.1.22 - 4.1.24 =
	- BAW test
	- ADDED lct_baw_force_plugin_updates

= 4.1.15 - 4.1.21 =
	- Added Avada Theme Support
	- gform css tweaks
	- Code Cleanup

= 4.1.14 =
	- CJ Spam Filter

= 4.1.13 =
	- added includes: iframe_resizer

= 4.1.12 =
	- ADDED lct_preload

= 4.1.11 =
	- WP 4.1.1 Ready
	- Fixed lct_get_user_agent_info
	- Fixed Browscap.php

= 4.1.9 - 4.1.10 =
	- changes to wpauto selection
	- lct_useful_settings default settings and checker

= 4.1.2 - 4.1.8 =
	- Minor tweaks

= 4.1.1 =
	- Fixed lct_sitemap_generator call to english-us.php

= 4.1 =
	- WP 4.1 Ready
	- jumped version to match WP

= 1.4.28 =
	- ADDED Shortcode: P_R_O

= 1.4.27 =
	- Minor tweaks

= 1.4.26 =
	- ADDED Shortcode: admin_onetime_script_run

= 1.4.17 thru 1.4.25 =
	- Minor tweaks

= 1.4.16 =
	- ADDED lca_debug_to_console()

= 1.4.8 thru 1.4.15 =
	- Minor tweaks

= 1.4.7 =
	- WP 4.0 Ready

= 1.4.6 =
	- ADDED lct_opengraph_site_name

= 1.4.5 =
	- Minor tweaks

= 1.4.4 =
	- Fixed login shortcode

= 1.4.3 =
	- Fixed ")[" issues
	- Added ga.js

= 1.4.2 =
	- Fixed global class issue

= 1.4.1 =
	- Fixed global class issue

= 1.4 =
	- Changed the lct-useful-shortcodes-functions is_plugin_active() code

= 1.2.95 =
	- minor tweaks
	- Added lct_opengraph_single_image_filter

= 1.2.94 =
	- Tested for WP 3.9.2 Compatibility

= 1.2.93 =
	- minor tweaks
	- added sitemap-generator

= 1.2.92 =
	- minor tweaks

= 1.2.91 =
	- minor tweaks

= 1.2.9 =
	- ADDED lct_textimage_linking_shortcode
	- ADDED lct_admin_bar_on_bottom

= 1.2.8 =
	- Fixed Bugs in Gravity Form Placeholder Functionality
	- Added Login Form

= 1.2.7 =
	- Added Gravity Form Placeholder Functionality

= 1.2.6 =
	- Add Setting Menu

= 1.2.5 =
	- Added function echo_br()

= 1.2.4 =
	- Added Fix Multisite plugins_url issue

= 1.2.3 =
	- Fixed conflict with function 'wpautop_Disable'

= 1.2.2 =
	- Updated Globals

= 1.2.1 =
	- Updated Globals

= 1.2 =
	- Tested for WP 3.9.1 Compatibility
	- Cleaned up code.
	- Updated Globals

= 1.1.1 =
	- [get_test] bug fix.

= 1.1 =
	- Added debug/functions.php
	- Added new shortcode items

= 1.0 =
	- First Release
