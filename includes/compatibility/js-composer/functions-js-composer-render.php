<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder: Custom shortcode renderer functions
 *
 * These are functions the plugin uses for custom shortcodes output.
 * The shortcode renderer is actually taken by the predefined function name
 * (with `vc_theme_` prefix). There is already a filter hook applied in the
 * Visual Composer plugin, but to keep things backwards compatible, we are
 * using the old method of function names. (Also because the filter runs
 * after some additional processing of the shortcode output and we do not
 * want to mess things up more.)
 *
 * @see  WPBakeryShortCode::output()
 * @see  WM_Amplifier_JS_Composer::setup()
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





/**
 * Shortcode output: [vc_row]
 *
 * Making it the same as [wm_row] shortcode.
 *
 * @see  WM_Shortcodes::shortcode_render()
 *
 * @param  array  $atts
 * @param  string $content
 */
function vc_theme_vc_row( $atts = array(), $content = '' ) {

	// Output

		// What WebMan Amplifier shortcode should we render?
		return WM_Amplifier_JS_Composer::shortcode_render( $atts, $content, 'row' );

} // /vc_theme_vc_row



/**
 * Shortcode output: [vc_row_inner]
 *
 * Making it the same as [wm_row] shortcode.
 *
 * @param  array  $atts
 * @param  string $content
 */
function vc_theme_vc_row_inner( $atts = array(), $content = '' ) {

	// Output

		// What WebMan Amplifier shortcode should we render?
		return WM_Amplifier_JS_Composer::shortcode_render( $atts, $content, 'row' );

} // /vc_theme_vc_row_inner



/**
 * Shortcode output: [vc_column]
 *
 * Making it the same as [wm_column] shortcode.
 *
 * @param  array  $atts
 * @param  string $content
 */
function vc_theme_vc_column( $atts = array(), $content = '' ) {

	// Output

		// What WebMan Amplifier shortcode should we render?
		return WM_Amplifier_JS_Composer::shortcode_render( $atts, $content, 'column' );

} // /vc_theme_vc_column



/**
 * Shortcode output: [vc_column_inner]
 *
 * Making it the same as [wm_column] shortcode.
 *
 * @param  array  $atts
 * @param  string $content
 */
function vc_theme_vc_column_inner( $atts = array(), $content = '' ) {

	// Output

		// What WebMan Amplifier shortcode should we render?
		return WM_Amplifier_JS_Composer::shortcode_render( $atts, $content, 'column' );

} // /vc_theme_vc_column_inner
