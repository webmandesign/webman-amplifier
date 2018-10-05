<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 3rd party plugins compatibility
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.3.22
 * @version  1.6.0
 */
function wma_load_plugins_compatibility() {

	// Helper variables

		$has_page_builder = false;


	// Processing

		// Beaver Builder

			if ( class_exists( 'FLBuilder' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/class-beaver-builder.php';
				$has_page_builder = true;
			}

		// WooSidebars

			if ( class_exists( 'Woo_Sidebars' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/woosidebars/class-woosidebars.php';
			}

		// WPBakery Page Builder (Visual Composer)

			if ( class_exists( 'Vc_Manager' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/js-composer/class-js-composer.php';
				$has_page_builder = true;
			}

		// WPML

			if ( function_exists( 'wpml_core_loads_first' ) ) {
				require_once WMAMP_INCLUDES_DIR . 'compatibility/wpml/class-wpml.php';
			}

		/**
		 * Finally, we also check if we should load the page builder helper class
		 */
		if ( $has_page_builder ) {
			require_once WMAMP_INCLUDES_DIR . 'compatibility/page-builder/class-page-builder.php';
		}

}

add_action( 'plugins_loaded', 'wma_load_plugins_compatibility', 99 );
