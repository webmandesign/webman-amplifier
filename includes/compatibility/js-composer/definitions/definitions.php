<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array
 *
 * @todo  When themes are updated, rename 'vc_plugin' to 'compatibility/js-composer'
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
			'vc',
			'video',
			'widget-area',
		);


// Processing

	/**
	 * Partial files must contain specific WPBakery Page Builder element definition array added to `(array) $definitions`.
	 * @example
	 * $definitions['shortcode_name']['vc_plugin'] = array(...);
	 */
	foreach ( $partial_files as $partial_file ) {
		$partial_file = WMAMP_INCLUDES_DIR . 'compatibility/js-composer/definitions/partial/' . $partial_file . '.php';
		if ( file_exists( $partial_file ) ) {
			include_once( $partial_file );
		}
	}
