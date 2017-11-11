<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array
 *
 * @todo  When themes are updated, rename 'bb_plugin' to 'compatibility/beaver-builder'
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





// Helper variables

	// Global code helpers and values

		$helpers = WM_Shortcodes::get_codes_globals();

	// Partial files to load

		$partial_files = array(
			'accordion',
			'button',
			'call-to-action',
			'content-module',
			'divider',
			'message',
			'posts',
			'table',
			'tabs',
			'testimonials',
		);


// Processing

	/**
	 * Partial files must contain specific Beaver Builder module definition array added to `(array) $definitions`.
	 * @example
	 * $definitions['shortcode_name']['bb_plugin'] = array(...);
	 */
	foreach ( $partial_files as $partial_file ) {
		$partial_file = WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/definitions/partial/' . $partial_file . '.php';
		if ( file_exists( $partial_file ) ) {
			include_once( $partial_file );
		}
	}
