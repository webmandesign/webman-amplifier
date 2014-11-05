## Changelog

### 1.0.9.12
* Updated: Updated Twitter OAuth library

Files changed: `includes/twitter-api/OAuth.php, includes/twitter-api/twitteroauth.php`

### 1.0.9.11
* Updated: Optimized code
* Updated: Including Twitter OAuth library conditionally to prevent issues with other plugins

Files changed: `class-wm-amplifier.php, includes/functions.php, includes/shortcodes/class-shortcodes.php, includes/widgets/w-twitter.php`

### 1.0.9.10
* Updated: Widgets class names
* Updated: Admin styles
* Fixed: Post thumbnails size in WordPress admin
* Fixed: Visual Composer Accordions and Tabs shortcode issue

Files changed: `assets/css/admin-addons.css, assets/css/rtl-shortcodes-vc-addons.css, assets/css/shortcodes-vc-addons.css, assets/css/shortcodes-vc-addons-old.css, assets/css/dev/admin-addons.css, assets/css/dev/rtl-shortcodes-vc-addons.css, assets/css/dev/shortcodes-vc-addons.css, assets/css/dev/shortcodes-vc-addons-old.css, assets/js/shortcodes-vc-addons.js, assets/js/dev/shortcodes-vc-addons.js, includes/shortcodes/definitions/definitions.php, includes/widgets/w-contact.php, includes/widgets/w-module.php, includes/widgets/w-posts.php, includes/widgets/w-subnav.php, includes/widgets/w-tabbed-widgets.php, includes/widgets/w-twitter.php`

### 1.0.9.9
* Added: Widgets
* Added: Option to deactivate the plugin after theme change
* Updated: Code effectivity
* Updated: Scripts: imagesLoaded 3.1.8, Isotope 2.0.1, jQuery OwlCarousel 1.3.3
* Updated: Admin notice function
* Updated: Localization file

Files added: `includes/widgets/w-contact.php, includes/widgets/w-module.php, includes/widgets/w-posts.php, includes/widgets/w-subnav.php, includes/widgets/w-tabbed-widgets.php, includes/widgets/w-twitter.php`

Files changed: `class-wm-amplifier.php, webman-amplifier.php, assets/js/plugins/imagesloaded.min.js, assets/js/plugins/isotope.pkgd.min.js, assets/js/plugins/owl.carousel.min.js, includes/functions.php, includes/functions.php, languages/wm_domain.pot`

### 1.0.9.8
* Improved Tabs shortcode
* Fixed Shortcode Generator shortcode attributes
* Fixed and improved shortcodes scripts enqueuing

Files changed: `assets/css/shortcodes-vc-addons.css, assets/css/dev/shortcodes-vc-addons.dev.css, includes/shortcodes/class-shortcodes.php, includes/shortcodes/definitions/definitions.php, includes/shortcodes/renderers/accordion.php, includes/shortcodes/renderers/content_module.php, includes/shortcodes/renderers/countdown_timer.php, includes/shortcodes/renderers/posts.php, includes/shortcodes/renderers/row.php, includes/shortcodes/renderers/slideshow.php, includes/shortcodes/renderers/tabs.php, includes/shortcodes/renderers/testimonials.php`

### 1.0.9.7
* WordPress 4.0 support
* Improved shortcodes scripts enqueuing

Files changed: `assets/metabox.css, assets/dev/metabox.dev.css, includes/shortcodes/renderers/accordion.php, includes/shortcodes/renderers/content_module.php, includes/shortcodes/renderers/countdown_timer.php, includes/shortcodes/renderers/posts.php, includes/shortcodes/renderers/row.php, includes/shortcodes/renderers/slideshow.php, includes/shortcodes/renderers/tabs.php, includes/shortcodes/renderers/testimonials.php`

### 1.0.9.6
* Added additional arguments for `do_action()` for better flexibility.

Files changed: `includes/shortcodes/class-shortcodes.php, includes/shortcodes/renderers/accordion.php, includes/shortcodes/renderers/content_module.php, includes/shortcodes/renderers/countdown_timer.php, includes/shortcodes/renderers/posts.php, includes/shortcodes/renderers/row.php, includes/shortcodes/renderers/slideshow.php, includes/shortcodes/renderers/tabs.php, includes/shortcodes/renderers/testimonials.php`

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