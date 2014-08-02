## WebMan Amplifier

**WebMan Amplifier WordPress plugin built for extending the functionality of [WebMan Themes](http://www.webmandesign.eu).**

Amplifies functionality of WP themes. Provides custom post types, shortcodes, metaboxes, icons. Theme developer's best friend!


## Description

**[WebMan Amplifier](http://www.webmandesign.eu/ "WebMan Design") is WordPress plugin that provides mega pack of features! This is a premium plugin that you can get absolutely for free! The plugin was build to help with and simplify the WordPress theme development process, thus is suited for theme developers mostly.**

This plugin was created primarily for [WebMan Themes](http://www.webmandesign.eu/ "WebMan Themes"), but it works with any other theme as well. The plugin adds several useful custom post types to your WordPress installation. It contains an advanced metabox generator that you can use to create a custom form fields for any of your custom post types or for WordPress native Posts and Pages. Besides, the WebMan Amplifier features a bunch of useful shortcodes and is completely compatible with popular premium (3rd party) Visual Composer plugin. Using both these plugins you get complete visual control over the content of your website. And finally, the plugin allows you to use a custom icons (icon font from Fontello.com) that are high DPI screen (Retina) ready! WebMan Amplifier is also RTL languages ready and very customizable and extendable via actions and filters!

Don't ever get tied to a theme! **Take all the premium functionality with you** no matter what theme you use!

### Features

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
* RTL language support

### Plugin Localization

Have a translation? Please post it on the [support forum](http://support.webmandesign.eu/ "WebMan Support Forum").


## Installation

1. Unzip the plugin download file and upload `webman-amplifier` folder into the `/wp-content/plugins/` directory.
2. Activate the plugin through the *"Plugins"* menu in WordPress.
3. Check out the `webman-amplifier/webman-amplifier-setup.php` file for how to use the plugin with your theme ([New WebMan Themes](http://www.webmandesign.eu/ "Best WordPress themes!") supports the plugin already).


## Frequently Asked Questions

*In case of more questions or issues, please [visit the support forum](http://support.webmandesign.eu/ "WebMan Support Forum")*

### How to enable plugin features?

You have to define the plugin support in your theme. Please see the `webman-amplifier/webman-amplifier-setup.php` file for instructions.

### How to upload custom icon font?

The plugin supports icon font files from Fontello.com. Visit the website, select your icons and download the font. Please note that you should **not use the custom font file name** as the plutin only supports the default "fontello" font name (no need to type it in on Fontello.com website as this is predefined). After the font is downloaded, navigate to *"Appearance > Icon Font"* and upload your Fontello ZIP package file. Save the settings and new icons will be loaded.

### How to translate (localize) the plugin?

First, plese note that custom translation files inside the plugin's `languages` folder will be removed / overwritten on plugin updates. If you're creating a custom translation files, please use the global WordPress language folder (usually `wp-content/languages/`). First create a `webman-amplifier` subfolder in the global WordPress language folder (you will end up with `wp-content/languages/webman-amplifier/` structure). Than FTP your translated plugin's file into this folder. Name the file as `wm_domain-LOCALE.mo` (for example: `wm_domain-en_US.mo`, so you'll end up with `wp-content/languages/webman-amplifier/wm_domain-en_US.mo`). Once you place the properly named localization file into the folder, the plugin should pick up your translation without any issues. Note: the source file for translation can be found in `webman-amplifier/languages/wm_domain.pot`, please use a tool such as [Poedit](http://poedit.net/ "Poedit translator") to translate the file and create an `.MO` file.


## Other Notes

### Isotope

Please note that the plugin integrates an Isotope JavaScript filter. This script is released under GPL v3 licence for non-commercial use. If you inted to use the plugin for commercial purpose, please purchase the [Isotope licence](http://isotope.metafizzy.co/license.html).


## Changelog

### 1.0.9.5
* Added compatibility with Visual Composer 4.3+

Files changed: `webman-amplifier-setup.php, assets/css/shortcodes-vc-addons.css, assets/css/rtl-shortcodes-vc-addons.css, assets/css/dev/rtl-shortcodes-vc-addons.dev.css, assets/css/shortcodes-vc-addons-old.css, assets/css/dev/shortcodes-vc-addons.dev.css, assets/css/dev/shortcodes-vc-addons-old.dev.css, assets/js/shortcodes-vc-addons.js, assets/js/dev/shortcodes-vc-addons.dev.js, includes/shortcodes/class-shortcodes.php, includes/shortcodes/vc_addons/shortcodes-admin.php`

### 1.0.9.4
* Added `style` attribute to Icon shortcode
* Fixed applying `active` class on active tab content
* Visual Composer element screen tabs redesigned
* Setup actions updated

Files changed: `class-wm-amplifier.php, assets/css/shortcodes-vc-addons.css, assets/css/dev/shortcodes-vc-addons.dev.css, assets/js/shortcode-tabs.js, assets/js/dev/shortcode-tabs.dev.js, includes/shortcodes/definitions/definitions.php, includes/shortcodes/renderes/icon.php`

### 1.0.9.3
* Fixed the non-admin user lockout

Files changed: `includes/class-icon-font.php`

### 1.0.9.2
* Fix the Shortcode Generator issue in Firefox browser

Files changed: `assets/js/dev/shortcodes-button.dev.js, assets/js/shortcodes-button.js`

### 1.0.9.1
* Fix the issue with admin notice

Files changed: `class-wm-amplifier.php`

### 1.0.9
* Added Master Slider shortcode support for Visual Composer
* Added a shortcode to display a custom post meta field value `[wm_meta field="wmamp-meta-field" custom"1/0" /]`
* Added option to define the supported version of plugin for themes
* Column shortcode styling improvements
* Divider shortcode styling option added for Visual Composer
* Taxonomies list sorted by name in shortcodes descriptions in Visual Composer
* Visual Composer inner column support improved
* Visual Composer Image shortcode styling options added
* Localization texts changed

Files changed: `webman-amplifier.php, webman-amplifier-setup.php, assets/js/shortcode-accordion.js, assets/js/dev/shortcode-accordion.dev.js, includes/functions.php, includes/shortcodes/class-shortcodes.php, includes/shortcodes/definitions/definitions.php, includes/shortcodes/renderers/accordion.php, includes/shortcodes/renderers/column.php, includes/shortcodes/renderers/image.php, includes/shortcodes/renderers/meta.php, includes/shortcodes/renderers/row.php, languages/wm_domain.php`

### 1.0.8
* Added support for Visual Composer v4.2
* Updated sample setup file

Files changed: `webman-amplifier-setup.php, includes/functions.php, includes/metabox/class-metabox.php, includes/shortcodes/class-shortcodes.php, includes/shortcodes/definitions/definitions.php, includes/shortcodes/vc_addons/shortcodes-admin.php`

### 1.0.7
* Metabox class improved (not to throw out PHP warning)
* Metabox function name fixed in `webman-amplifier-setup.php`

Files changed: `includes/metabox/class-metabox.php, webman-amplifier-setup.php`

### 1.0.6
* Isotope filter fixed for RTL languages
* Sorting font icons preview alphabetically

Files changed: `includes/class-icon-font.php, assets/js/dev/shortcode-posts.dev.js, assets/js/shortcode-posts.js`

### 1.0.5
* Added plugin deactivation hook
* Better hooking into `wma_meta_option()` function
* Sorting outputs of `wma_pages_array()` and `wma_taxonomy_array()` functions
* Filter names fixed in `wma_posts_array()`, `wma_pages_array()` and `wma_widget_areas_array()` functions

Files changed: `webman-amplifier.php, includes/functions.php`

### 1.0
* Initial release.