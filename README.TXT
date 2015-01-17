=== WebMan Amplifier ===
Contributors: webmandesign
Tags: webman, accordion, audio, button, call to action, column, row, section, content, module, countdown, timer, divider, dropcap, icon, list, marker, messabe, box, posts, related, price, pricing table, progress, skillbar, pullquote, separator, heading, slideshow, slider, table, tabs, toggles, testimonials, video, widget area, sidebar, responsive, shortcode, shortcodes, custom post types, projects, portfolio, staff, logos, modules, visual composer, metabox, meta, generator, fonticons, fontello, widgets, twitter, contact, sub navigation, tabbed widgets
Donate link: http://www.webmandesign.eu/
Author URI: http://www.webmandesign.eu/
Plugin URI: http://www.webmandesign.eu/webman-amplifier/
Requires at least: 4.0
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Amplifies functionality of WP themes. Provides custom post types, shortcodes, metaboxes, icons. Theme developer's best friend!

== Description ==

**[WebMan Amplifier](http://www.webmandesign.eu/ "WebMan Design") is WordPress plugin that provides mega pack of features! This is a premium plugin that you can get absolutely for free! The plugin was build to help with and simplify the WordPress theme development process, thus is suited for theme developers mostly.**

This plugin was created primarily for [WebMan Themes](http://www.webmandesign.eu/ "WebMan Themes"), but it works with any other theme as well. The plugin adds several useful custom post types to your WordPress installation. It contains an advanced metabox generator that you can use to create a custom form fields for any custom post types or for WordPress native Posts and Pages. Besides, the WebMan Amplifier features a bunch of useful shortcodes and is completely compatible with popular premium (3rd party) Visual Composer plugin. Using both these plugins you get complete visual control over the content of your website. And finally, the plugin allows you to use a custom icons (icon font from Fontello.com) that are high DPI screen (Retina) ready and contains bunch of useful widgets! WebMan Amplifier is also RTL languages ready and very customizable and extendable via actions and filters!

Don't ever get tied to a theme! **Take all the premium functionality with you** no matter what theme you use!

= Features =

* A lot of useful and well thought shortcodes
* Simple and fast Shortcode Generator
* Visual Composer (3rd party premium plugin) integration
* Projects custom post type to create your own portfolios
* Logos custom post type to manage your clients and/or partners logo lists
* Testimonials custom post type
* Manage your team members via Staff custom post type
* Use Content Modules custom post type to inject a special content or icon box anywhere on your website
* Advanced metabox generator (with Advanced WebMan Metaboxes wrapped around the post visual editor)
* Fontello.com icon font uploader and simple integration
* Widgets
* RTL language support

= Plugin Localization =

Have a translation? Please post it on the [support forum](http://support.webmandesign.eu/ "WebMan Support Forum").

Please, find the instructions on how to localize the plugin in `webman-amplifier/languages/readme.md` file.

= Plugin Support =

Please note that support is provided on [WebMan Support Forum](http://support.webmandesign.eu/forums/forum/webman-amplifier/ "WebMan Support Forum")

== Installation ==

1. Unzip the plugin download file and upload `webman-amplifier` folder into the `/wp-content/plugins/` directory.
2. Activate the plugin through the *"Plugins"* menu in WordPress.
3. Check out the `webman-amplifier/webman-amplifier-setup.php` file for how to use the plugin with your theme ([New WebMan Themes](http://www.webmandesign.eu/ "Best WordPress themes!") supports the plugin already).

== Frequently Asked Questions ==

**Please note that support is provided on [WebMan Support Forum](http://support.webmandesign.eu/forums/forum/webman-amplifier/ "WebMan Support Forum")**

= How to enable plugin features? =

You have to define the plugin support in your theme. Please see the `webman-amplifier/webman-amplifier-setup.php` file for instructions.

= How to upload custom icon font? =

The plugin supports icon font files from Fontello.com. Visit the website, select your icons and download the font. Please note that you should **not use the custom font file name** as the plutin only supports the default "fontello" font name (no need to type it in on Fontello.com website as this is predefined). After the font is downloaded, navigate to *"Appearance > Icon Font"* and upload your Fontello ZIP package file. Save the settings and new icons will be loaded.

= How to translate (localize) the plugin? =

Please, find the instructions on how to localize the plugin in `webman-amplifier/languages/readme.md` file.

== Screenshots ==

1. Custom post types
2. Custom post metabox interface and Shortcode Generator
3. Metabox form fields preview
4. Custom Fontello.com icon font setup screen
5. Visual Composer plugin integration

== Other Notes ==

= Isotope Licensing =

Please note that the plugin integrates an Isotope JavaScript filter. This script is released under GPL v3 licence for non-commercial use. If you inted to use the plugin for commercial purpose, please purchase the [Isotope licence](http://isotope.metafizzy.co/license.html).

== Changelog ==

= 1.1 =
* Added: Visual Composer 4.4 support
* Added: Beaver Builder plugin support
* Added: Plugin action links plugins admin page
* Added: Slovak localization file
* Updated: Optimized and improved code
* Updated: Removed obsolete files
* Updated: Better file organization
* Updated: Scripts updated: Isotope 2.1.0
* Updated: Removed support for old WordPress versions
* Updated: Renamed `type` shortcode attribute to `appearance` (keeping backwards compatibility)
* Updated: Localization functions and files
* Fixed: Fixed hook names
* Fixed: Vertical tabs min tab content height

= 1.0.9.15 =
* Added: Function to register additional custom taxonomies
* Added: 'wma_supports_subfeature( $subfeature )' function
* Updated: Function to check if the theme supports plugin's features
* Updated: Improved disabling shortcodes and icon font classes
* Updated: Improved performance of the code
* Updated: Metabox styles
* Updated: Renamed 'remove_vc_shortcodes' to 'remove-vc-shortcodes' (while keeping backwards compatibility)
* Updated: WebMan Amplifier setup file
* Fixed: Function name for 'WMAMP_LATE_LOAD' feature

= 1.0.9.14 =
* Updated: Allow disabling shortcodes, icon font and metaboxes classes

= 1.0.9.13 =
* Updated: Posts shortcode filter name

= 1.0.9.12 =
* Updated: Updated Twitter OAuth library

= 1.0.9.11 =
* Updated: Optimized code
* Updated: Including Twitter OAuth library conditionally to prevent issues with other plugins

= 1.0.9.10 =
* Updated: Widgets class names
* Updated: Admin styles
* Fixed: Post thumbnails size in WordPress admin
* Fixed: Visual Composer Accordions and Tabs shortcode issue

= 1.0.9.9 =
* Added: Widgets
* Added: Option to deactivate the plugin after theme change
* Updated: Code effectivity
* Updated: Scripts: imagesLoaded 3.1.8, Isotope 2.0.1, jQuery OwlCarousel 1.3.3
* Updated: Admin notice function
* Updated: Localization file

= 1.0.9.8 =
* Improved Tabs shortcode
* Fixed Shortcode Generator shortcode attributes
* Fixed and improved shortcodes scripts enqueuing

= 1.0.9.7 =
* WordPress 4.0 support
* Improved shortcodes scripts enqueuing

= 1.0.9.6 =
* Added additional arguments for `do_action()` for better flexibility.

= 1.0.9.5 =
* Added compatibility with Visual Composer 4.3+

= 1.0.9.4 =
* Added `style` attribute to Icon shortcode
* Fixed applying `active` class on active tab content
* Visual Composer element screen tabs redesigned
* Setup actions updated

= 1.0.9.3 =
* Fixed the non-admin user lockout

= 1.0.9.2 =
* Fix the Shortcode Generator issue in Firefox browser

= 1.0.9.1 =
* Fix the issue with admin notice

= 1.0.9 =
* Added Master Slider shortcode support for Visual Composer
* Added a shortcode to display a custom post meta field value `[wm_meta field="wmamp-meta-field" custom"1/0" /]`
* Added option to define the supported version of plugin for themes
* Column shortcode styling improvements
* Divider shortcode styling option added for Visual Composer
* Taxonomies list sorted by name in shortcodes descriptions in Visual Composer
* Visual Composer inner column support improved
* Visual Composer Image shortcode styling options added
* Localization texts changed

= 1.0.8 =
* Added support for Visual Composer v4.2+
* Updated sample setup file

= 1.0.7 =
* Metabox class improved (not to throw out PHP warning)
* Metabox function name fixed in `webman-amplifier-setup.php`

= 1.0.6 =
* Isotope filter fixed for RTL languages
* Sorting font icons preview alphabetically

= 1.0.5 =
* Added plugin deactivation hook
* Better hooking into `wma_meta_option()` function
* Sorting outputs of `wma_pages_array()` and `wma_taxonomy_array()` functions
* Filter names fixed in `wma_posts_array()`, `wma_pages_array()` and `wma_widget_areas_array()` functions

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.1 =
Major update! Added support for Visual Composer 4.4 and Beaver Builder plugin! Added Slovak localization files, optimized and reorganized code, updated scripts, fixed minor bugs.

= 1.0.9.15 =
Added registering custom taxonomies, updated and improved code performance and logic, fixed naming convention.

= 1.0.9.14 =
Allowing disabling shortcodes, icon font and metaboxes classes.

= 1.0.9.13 =
Updated posts shortcode filter name on $helper variable.

= 1.0.9.12 =
Updated Twitter OAuth library.

= 1.0.9.11 =
Optimized code, conditional loading of Twitter OAuth library.

= 1.0.9.10 =
Fixed post thumbnails size in WordPress admin and Visual Composer Accordions and Tabs shortcode issue.

= 1.0.9.9 =
Added widgets, option to deactivate the plugin after theme change, scripts updated, code improved.

= 1.0.9.8 =
Improved Tabs shortcode, fixed Shortcode Generator shortcode attributes, fixed and improved shortcodes scripts enqueuing.

= 1.0.9.7 =
WordPress 4.0 support. Improved shortcodes scripts enqueuing.

= 1.0.9.6 =
Added additional arguments for `do_action()` for better flexibility.

= 1.0.9.5 =
Added compatibility with Visual Composer 4.3+

= 1.0.9.4 =
Added `style` attribute to Icon shortcode, Tabs shortcode fixes, admin and code improvements.

= 1.0.9.3 =
Fixes the non-admin user lockout.

= 1.0.9.2 =
Fixes Shortcode Generator issue in Firefox browser.

= 1.0.9.1 =
Fixes the issue with admin notice error.

= 1.0.9 =
Added MasterSlider support, shortcodes improvements. Added a shortcode to display a custom post meta field value.

= 1.0.8 =
Added support for Visual Composer v4.2+.

= 1.0.7 =
Metabox class improved.

= 1.0.6 =
Isotope filter fixed for RTL languages, sorting font icons preview alphabetically.

= 1.0.5 =
Added plugin deactivation hook, improved pages and taxonomies sorting, fixed filters names.

= 1.0 =
This is initial plugin release.