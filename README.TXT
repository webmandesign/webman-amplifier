=== WebMan Amplifier ===
Contributors: webmandesign
Tags: webman, accordion, audio, button, call to action, column, row, section, content, module, countdown, timer, divider, dropcap, icon, list, marker, messabe, box, posts, related, price, pricing table, progress, skillbar, pullquote, separator, heading, slideshow, slider, table, tabs, toggles, testimonials, video, widget area, sidebar, responsive, shortcode, shortcodes, custom post types, projects, portfolio, staff, logos, modules, visual composer, beaver builder, page builder, metabox, meta, generator, fonticons, fontello, widgets, twitter, contact, sub navigation, tabbed widgets
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

This plugin was created primarily for [WebMan Themes](http://www.webmandesign.eu/ "WebMan Themes"), but it works with any other theme as well. The plugin adds several useful custom post types to your WordPress installation. It contains an advanced metabox generator that you can use to create a custom form fields for any custom post types or for WordPress native Posts and Pages. Besides, the WebMan Amplifier features a bunch of useful shortcodes and is completely compatible with popular Beaver Builder and premium Visual Composer page builder plugins. Using both these plugins you get complete visual control over the content of your website. And finally, the plugin allows you to use a custom icons (icon font from Fontello.com) that are high DPI screen (Retina) ready and contains bunch of useful widgets! WebMan Amplifier is also RTL languages ready and very customizable and extendable via actions and filters!

Don't ever get tied to a theme! **Take all the premium functionality with you** no matter what theme you use!

= Features =

* A lot of useful and well thought shortcodes
* Simple and fast Shortcode Generator
* [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/) and Visual Composer page builder integration
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

= Additional Resources =

* [Write a review](http://wordpress.org/support/view/plugin-reviews/webman-amplifier#postform)
* [Have a question?](http://support.webmandesign.eu/)
* [Follow @webmandesigneu](https://twitter.com/webmandesigneu)
* [Visit WebMan Design](http://www.webmandesign.eu)

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

Please see the [`CHANGELOG.md` file](https://github.com/webmandesign/webman-amplifier/blob/master/CHANGELOG.md) for details.

== Upgrade Notice ==

= 1.1.5 =
Improved support with Beaver Builder (unfortunatelly, not backwards compatible as custom modules file names have been renamed).

= 1.1.4 =
IMPORTANT: Custom posts issue introduced in update 1.1.3 was fixed.

= 1.1.3 =
Icon font updated to Font Awesome v4.1 (resave the font to regenerate), fixed code and conditions for including Shortcode Generator button (fixes issue with MasterSlider plugin).

= 1.1.2 =
Improved support with Visual Composer, improved file and folder creation functions.

= 1.1.1 =
Improved and fixed support for Beaver Builder plugin, improved Schema.org generator function, updated hook names.

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