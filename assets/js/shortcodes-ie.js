/**
 * WebMan Column shortcodes Internet Explorer 8 fix
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */

jQuery(function(){/msie [1-8]{1}[^0-9]/.test(navigator.userAgent.toLowerCase())&&jQuery("div > .wm-column:last-child").addClass("last")});