<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder plugin compatibility class
 *
 * Making shortcodes work as WPBakery Page Builder elements/modules.
 * Note that this page builder was previously called Visual Composer.
 * And its plugin folder name is `js_composer` to make things more complicated.
 * Simply put, what a tragedy plugin Visual Composer is... but I need to keep
 * the backwards compatibility, unfortunately.
 *
 * Why there is a compatibility for this plugin anyway?
 * ====================================================
 * At the time I was releasing Mustang WordPress theme, customers asked me to provide
 * compatibility for this page builder. It was the most used one then. Demand for this
 * integration was quite tough, so I had to overcome my dislike and introduced the
 * plugin compatibility. I knew it would be mistake, and it really was... So many
 * incompatible changes from version to version, pour code and extensibility,
 * a real nightmare to develop anything. At that time it even didn't have many useful
 * features so I had to implement them into my plugin extensions which, of course,
 * proved to be incompatible with future Visual Composer version when similar features
 * were actually introduced to the plugin. Anyway, here is a what you need to do:
 *
 * @todo  Remove this plugin compatibility!
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
