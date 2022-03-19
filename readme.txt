=== WebMan Amplifier ===
Contributors:      webmandesign
Donate link:       https://www.webmandesign.eu/contact/
Author URI:        https://www.webmandesign.eu
Plugin URI:        https://github.com/webmandesign/webman-amplifier
Requires at least: 4.3
Tested up to:      5.9
Stable tag:        1.5.10
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

= 1.5.10 =
Updating JavaScript.
