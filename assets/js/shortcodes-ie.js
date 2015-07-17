/**
 * WebMan Column shortcodes Internet Explorer 8 fix
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





jQuery( function() {





	// Internet Explorer 8 fix for Column shortcode

		jQuery( '.lie8 div > .wm-column:last-child' )
			.addClass( 'last' );





} );
