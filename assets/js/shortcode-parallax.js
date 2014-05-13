/**
 * WebMan Parallax scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */

jQuery(function(){jQuery().parallax&&jQuery("[data-parallax-inertia]").each(function(){var a=jQuery(this),b=a.data("parallax-inertia")?a.data("parallax-inertia"):.2,c=a.data("parallax-xPosition")?a.data("parallax-xPosition"):"50%";a.parallax(c,b,!0)})});