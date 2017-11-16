<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */





// Helper variables

	$key = WM_Amplifier_JS_Composer::$definition_array_key;

	// Global code helpers and values

		$helpers = WM_Shortcodes::get_codes_globals();

	// Prefixes

		$prefix = array(
			'code' => WM_Shortcodes::$prefix_shortcode,
			'name' => WM_Shortcodes::$prefix_shortcode_name,
		);

	// Partial files to load

		$partial_files = array(
			'accordion',
			'audio',
			'button',
			'call-to-action',
			'column',
			'content-module',
			'countdown-timer',
			'divider',
			'icon',
			'image',
			'item',
			'list',
			'message',
			'posts',
			'price',
			'pricing-table',
			'progress',
			'row',
			'separator-heading',
			'slideshow',
			'table',
			'tabs',
			'testimonials',
			'text_block',
			'vc_alias',
			'vc_column',
			'vc_column_inner',
			'vc_row',
			'vc_row_inner',
			'video',
			'widget-area',
		);


// Processing

	/**
	 * Partial files must contain specific WPBakery Page Builder element definition array added to `(array) $definitions`.
	 * @example
	 * $definitions['shortcode_name'][ $key ] = array(...);
	 */
	foreach ( $partial_files as $partial_file ) {
		$partial_file = WMAMP_INCLUDES_DIR . 'compatibility/js-composer/definitions/partial/' . $partial_file . '.php';
		if ( file_exists( $partial_file ) ) {
			include_once $partial_file;
		}
	}
