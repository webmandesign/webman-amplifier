<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 3rd party plugins compatibility
 *
 * @package     WebMan Amplifier
 * @subpackage  Integration
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.3.22
 * @version  1.5.4
 */
function wma_load_plugins_compatibility() {

	// Processing

		// WooSidebars

			if ( class_exists( 'Woo_Sidebars' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/woosidebars/class-woosidebars.php';
			}

		// WPML

			if ( function_exists( 'wpml_core_loads_first' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/wpml/class-wpml.php';
			}

}

add_action( 'plugins_loaded', 'wma_load_plugins_compatibility', 99 );
