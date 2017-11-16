<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes definitions array
 *
 * Example structure of a shortcode definition array:
 * @example
 * 	'shortcode-name' => array(
 *
 * 		// Plugin version when the shortcode was added
 * 		// @required
 * 		'since' => '1.0.0',
 *
 * 		// Shortcode generator setup
 * 		// @optional  Do not set if empty!
 * 		'generator' => array(
 * 			'name'  => (string),
 * 			'code'  => (string),
 * 			'short' => (boolean), // Available in simplified, short Shortcode Generator?
 * 		),
 *
 * 		// Preprocessing needed?
 * 		// @optional  Do not set if empty!
 * 		'preprocess' => (boolean),
 *
 * 		// Overrides the default shortcode prefix when registering shortcode with WordPress.
 * 		// @optional  Do not set if empty!
 * 		'custom_prefix' => (mixed: boolean/string),
 *
 * 		// Alias: overrides shortcode default rendering functionality
 * 		// @optional  Do not set if empty!
 *   	'renderer' => array(
 * 			'alias' => (string),
 * 			'path'  => (string), // Custom render functionality file path
 * 		),
 *
 *   ),
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */





// Helper variables

	// Global code helpers and values

		$helpers = WM_Shortcodes::get_codes_globals();

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
			'dropcap',
			'icon',
			'item',
			'last-update',
			'list',
			'marker',
			'message',
			'meta',
			'posts',
			'pre',
			'price',
			'pricing-table',
			'progress',
			'row',
			'search-form',
			'separator-heading',
			'slideshow',
			'table',
			'tabs',
			'testimonials',
			'video',
			'widget-area',
		);


// Processing

	/**
	 * Partial files must contain specific shortcode definition array added to `(array) $definitions`.
	 * @example
	 * $definitions['shortcode_name'] = array(...);
	 */
	foreach ( $partial_files as $partial_file ) {
		$partial_file = WMAMP_INCLUDES_DIR . 'shortcodes/definitions/partial/' . $partial_file . '.php';
		if ( file_exists( $partial_file ) ) {
			include_once $partial_file;
		}
	}
