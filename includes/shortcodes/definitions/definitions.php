<?php
/**
 * Shortcodes definitions array.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Example structure of a shortcode definition array:
 *
 * @example
 * 	'shortcode-name' => array(
 *
 * 		// Plugin version when the shortcode was added
 * 		'since' => '1.0.0',
 *
 * 		// Shortcode generator setup
 * 		'generator' => array(
 * 			'name'  => (string),
 * 			'code'  => (string),
 * 			'short' => (boolean), // Available in simplified, short Shortcode Generator?
 * 		),
 *
 * 		// Preprocessing needed?
 * 		'preprocess' => (boolean),
 *
 * 		// Post type required for the shortcode
 * 		'post_type_required' => (string),
 *
 * 		// Overrides the default shortcode prefix when registering shortcode with WordPress.
 * 		// IMPORTANT: Set this only when really required!
 * 		'custom_prefix' => (mixed: boolean/string),
 *
 * 		// Alias: overrides shortcode default rendering functionality
 *   	'renderer' => array(
 * 			'alias' => (string),
 * 			'path'  => (string), // Custom render functionality file path
 * 		),
 *
 * 		// Plugin compatibility: Beaver Builder
 * 		'bb_plugin' => array(), // @todo  Documentation needed.
 *
 *   ),
 */

// Variables

	// Global code helpers and values
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	$helpers = WM_Shortcodes::get_codes_globals();

	// Prefixes
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	$prefix = array(
		'code' => WM_Shortcodes::$prefix_shortcode,
		'name' => WM_Shortcodes::$prefix_shortcode_name,
	);

	// Partial files to load
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	foreach ( $partial_files as $partial_file ) {

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
		$partial_file = WMAMP_INCLUDES_DIR . 'shortcodes/definitions/partial/' . $partial_file . '.php';

		if ( file_exists( $partial_file ) ) {
			include_once $partial_file;
		}
	}
