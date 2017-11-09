<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder plugin compatibility class
 *
 * Making shortcodes work as Beaver Builder elements/modules.
 *
 * @package     WebMan Amplifier
 * @subpackage  Integration
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Integration
 */
class WM_Amplifier_Beaver_Builder {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Filters

						add_filter( 'TODO', __CLASS__ . '::TODO' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Integration
	 */

		/**
		 * TODO
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function TODO() {

			// Output

				return TODO;

		} // /TODO





} // /WM_Amplifier_Beaver_Builder

add_action( 'init', 'WM_Amplifier_Beaver_Builder::init' );
