=== WebMan Amplifier ===
Contributors:      webmandesign
Donate link:       https://www.webmandesign.eu/contact/
Author URI:        https://www.webmandesign.eu
Plugin URI:        https://github.com/webmandesign/webman-amplifier
Requires at least: 4.3
Tested up to:      5.2
Stable tag:        1.5.8
License:           GNU General Public License v3
License URI:       http://www.gnu.org/licenses/gpl-3.0.html
Tags:              accordion, beaver builder, box, button, call to action, content modules, custom post types, divider, fontello, generator, icons, logos, message, meta, metabox, page builder, portfolio, posts, projects, shortcodes, staff, tabs, testimonials, toggles, webman design, wpml

Amplifies functionality of WP themes. Provides custom post types, shortcodes, metaboxes, icons. Theme developer's best friend!


== Description ==

> **Before you rate/review the plugin:**
>
> Please note that the plugin was created **for WordPress theme developers**. *If you are a normal, non-tech-savvy WordPress user*, this plugin will be disappointing for you and you don't need to install it as it was created for different purpose.
>
> *If you are a theme developer* and experience any issue with the plugin, please submit a support ticket.

**WebMan Amplifier is WordPress plugin that provides pack of features for theme developers. The plugin was build to help with, and simplify the WordPress theme development process.**

This plugin was created primarily for [WebMan Design themes](https://www.webmandesign.eu/), but it works with any other theme as well  if you declare a support for it in the theme's code.

= Features =

* Well thought shortcodes with simple and fast Shortcode Generator and integration with [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/) page builder (with support for [WPML](https://wpml.org) multilingual plugin)
* Custom post types:<br>
  &bull; **Projects** - to create your own portfolios<br>
  &bull; **Testimonials** - to manage your customers or partners testimonies<br>
  &bull; **Staff** - to manage your team members<br>
  &bull; **Content Modules** - to create an icon boxes, services boxes or a content injection anywhere on your website<br>
  &bull; **Logos** - to manage your clients and/or partners logos list<br>
* Custom widgets<br>
  &bull; **Contact** - to display your contact information<br>
  &bull; **Submenu** - to display a subpages of the current page<br>
  &bull; **Tabbed Widgets** - to display any widgets in tabbed interface<br>
  &bull; **Posts** - to list posts or portfolio projects<br>
  &bull; **Content Module** - to display any Content Module post<br>
* Metabox generator
* Fontello.com icon font uploader and simple integration

= Additional Resources =

* [Have a question?](https://wordpress.org/support/plugin/webman-amplifier/)
* [Grab a free theme](https://profiles.wordpress.org/webmandesign/#content-themes)
* [Visit WebMan Design](https://www.webmandesign.eu)


== Installation ==

1. Unzip the plugin download file and upload `webman-amplifier` folder into the `/wp-content/plugins/` directory.
2. Activate the plugin through the *"Plugins"* menu in WordPress.
3. Check out the `webman-amplifier/webman-amplifier-setup.php` file for how to use the plugin with your theme ([WebMan Design Themes](http://www.webmandesign.eu/ "Best WordPress themes!") supports the plugin by default).


== Frequently Asked Questions ==

= How to enable plugin features? =

You have to define the plugin support in your theme. Please see the `webman-amplifier/webman-amplifier-setup.php` file for instructions. There is only an icon font feature enabled by default (under **Appearance > Icon Font**).

= How to upload custom icon font? =

The plugin supports icon font files from Fontello.com. Visit the website, select your icons and download the font. Please note that you should **not use the custom font file name** as the plugin only supports the default "fontello" font name (no need to type it in on Fontello.com website as this is predefined). After the font is downloaded, navigate to **Appearance > Icon Font** and upload your Fontello ZIP package file. Save the settings and new icons will be loaded.

= How to translate (localize) the plugin? =

Translate the plugin by clicking the "Translate WebMan Amplifier into your language." link under "Development" section here on WordPress.org plugin repository page.

= Is it compatible with WPML? =

Yes! The plugin's custom Beaver Builder page builder elements/modules are compatible with [WPML multilingual plugin](https://wpml.org).


== Screenshots ==

1. Custom post types
2. Custom post metabox interface and Shortcode Generator
3. Metabox form fields preview
4. Custom Fontello.com icon font setup screen


== Other Notes ==

= Isotope Licensing =

Please note that the plugin integrates an Isotope JavaScript filter. This script is released under GPL v3 license for non-commercial use. If you intend to use the plugin for commercial purpose, please purchase the [Isotope license](http://isotope.metafizzy.co/license.html).


== Changelog ==

Please see the [`changelog.md` file](https://github.com/webmandesign/webman-amplifier/blob/master/changelog.md) for details.


== Upgrade Notice ==

= 1.5.8 =
Adding more explanatory info for Beaver Builder "Posts" module parameters setup.

= 1.5.7 =
Fixing issue when custom metabox not displaying on new post edit page.

= 1.5.6 =
Improving compatibility with WordPress 5.0, fixing shortcodes pagination and metaboxes display, fixing bugs.

= 1.5.5 =
Fixing compatibility with WordPress 5.0.

= 1.5.4 =
Fixing compatibility with WooSidebars plugin.

= 1.5.3 =
Fixing compatibility with WPBakery Page Builder (Visual Composer).

= 1.5.2 =
Fixing compatibility with most Beaver Builder 2.0.4

= 1.5.1 =
Fixing PHP error when loading Visual Composer compatible file.

= 1.5.0 =
Making custom Beaver Builder elements translatable with WPML plugin.

= 1.4.11 =
Fixing shortcode related scripts enqueuing function.

= 1.4.10 =
Fixing issue introduced in version 1.4.9.

= 1.4.9 =
Fixing Visual Composer compatibility.

= 1.4.8 =
Fixing carousel item wrapper custom class not being applied.

= 1.4.7 =
Improving accessibility.

= 1.4.6 =
Fixing Beaver Builder Agency super-admin screen integration.

= 1.4.5 =
Fixing Beaver Builder admin screen integration.

= 1.4.4 =
Fixing `wma_meta_option()` function premature output filter.

= 1.4.3 =
Fixing widget title displaying HTML tags, adding option for custom sorting to posts shortcodes, updated some default shortcodes attribute values, adding compatibility with Jetpack Sitemaps, improved accessibility.

= 1.4.2 =
Fixing compatibility with old PHP version.

= 1.4.1 =
Fixing compatibility with Visual Composer plugin, notifying of empty output of shortcodes (and page builder modules), fixing displaying of empty metaboxes, improved custom post types and their compatibility with WordPress admin tables.

= 1.4 =
Added WordPress 4.7 support, improved RTL support, improved Subnav widget, improved custom post types, improved icon font manager, updating Font Awesome icons to version 4.7.

= 1.3.22 =
Added integration with WooSidebars plugin.

= 1.3.21 =
Cleaning and improving custom post types permalinks setup, improving metaboxes and icons font admin screen styles.

= 1.3.20 =
Fixing styling issue in icons list in WordPress dashboard.

= 1.3.19 =
Fixing JavaScript errors in Safari browser, improving accessibility, improving custom post types.

= 1.3.18 =
Fixing JavaScript errors in Beaver Builder page builder editor.

= 1.3.17 =
Fixing compatibility issue with OwlCarousel script.

= 1.3.16 =
Removing obsolete CSS and JavaScript files.

= 1.3.15 =
Fixing shortcodes JavaScript update when editing with Beaver Builder.

= 1.3.14 =
Fixing enqueuing of shortcode scripts. Removing bxSlider script. Removing closing PHP tag from the end of files.

= 1.3.13 =
Fixing Visual Composer compatibility, improving security, fixing typo and removing arrow from Subnav widget title.

= 1.3.12 =
Fixing metabox output if there are no metabox fields set.

= 1.3.11 =
Fixing compatibility with Beaver Builder page builder plugin, removing obsolete IE8 scripts.

= 1.3.10 =
Added support for customizer selective refresh on widgets, removed custom `admin-thumbnail` image size, updated scripts.

= 1.3.9 =
Fixing icon font CSS styles conflict.

= 1.3.8 =
Improved Slick slider functionality.

= 1.3.7 =
Fixing typos and duplicate button ID when set via Beaver Builder page builder issue.

= 1.3.6 =
Visual Composer 4.11+ compatible.

= 1.3.5 =
Added Slick script, improved support for SSL, updated plugin info.

= 1.3.4 =
Improved scripts registering and loading, updated scripts versions (ImagesLoaded 4.1.0, Isotope 2.2.2).

= 1.3.3 =
Improved icon font admin page, removed Isotope admin notice, updated localization.

= 1.3.2 =
Improved compatibility with child themes and passed attributes into widget title filter.

= 1.3.1 =
Removing Beaver Builder Lite Version WordPress multisite installation fix.

= 1.3 =
Beaver Builder 1.7 compatible (partial refresh activated for all modules), removing obsolete page builder modules, improved page builder modules setup, improved Tabs and Content Modules accessibility, improved flexibility of shortcodes, improved Staff post labels.

= 1.2.9.2 =
Improved Testimonials shortcode accessibility, fixing typos in readme files, updating license to GPLv3.

= 1.2.9.1 =
Improved custom post types and taxonomies labels, reset default shortcodes options values, improved shortcodes classes and accessibility.

= 1.2.9 =
Visual Composer 4.9 compatible, improved WordPress 4.4 compatibility, improved icon font admin screen, prepared for WordPress language packs.

= 1.2.8.1 =
Fixing issue with custom post types not being displayed in WordPress admin (reverting back the custom post types capabilities update introduced in version 1.2.8).

= 1.2.8 =
Visual Composer compatibility fixed and improved, removing custom admin styles in favour of page builder's native UI styles. Improved custom posts capabilities names, improved Submenu widget.

= 1.2.7 =
Fixing issue of loading icon font files on each admin page. Now they load on post edit screen only and only for specific post types to prevent issues with other plugins.

= 1.2.6 =
Improved PHP versions (mainly 7, but applies for others too) compatibility.

= 1.2.5 =
Adding a "Specialty" taxonomy on Staff posts, improved accessibility, improved admin UI, improved Content Module shortcode, improved custom posts registration, removed obsolete `.eot` font files.

= 1.2.4 =
Fixing Visual Composer shortcodes layout issue (for Posts, Testimonials and Content Modules).

= 1.2.3 =
WordPress 4.3 support, redesigned metabox controls, accessibility improvements, improved shortcodes overriding, fixed issue with Visual Composer custom shortcode mapping via dashboard.

= 1.2.2 =
Visual Composer 4.6+ support, SASS used for stylesheets, redesigned metabox controls, icon selector with filter, scripts updated.

= 1.2.1 =
Fixed hashtag links in Twitter widget, updated Font Awesome to version 4.3.

= 1.2 =
Fixed compatibility with Visual Composer 4.5.2+, optimized code and fixed bugs.

= 1.1.7.6 =
Removing `uninstall.php` file to prevent possible issues when deleting the plugin via WordPress dashboard.

= 1.1.7.5 =
Contact widget anti-spam protection updated.

= 1.1.7 =
Added compatibility with Visual Composer 4.5.

= 1.1.6 =
Code, security and page builders support improvements.

= 1.1.5 =
Improved support with Beaver Builder (unfortunately, not backwards compatible as custom modules file names have been renamed).

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
