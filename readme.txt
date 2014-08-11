=== LCT Useful Shortcodes & Functions ===
Contributors: ircary
Donate link: http://lookclassy.com/
Stable tag: 1.4
Requires at least: 3.3
Tested up to: 3.9.2
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
