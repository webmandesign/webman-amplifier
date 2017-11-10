<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper class to register Beaver Builder module
 *
 * All the modules are registered the same way, so there is no need
 * to copy the same code over and over.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */
class WM_Amplifier_Beaver_Builder_Register_Module extends FLBuilderModule {





	private static $module;

	private static $args;





	/**
	 * Constructor
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 *
	 * @param  string $module  Module ID.
	 */
	public function __construct( $module = '' ) {

		// Helper variables

			if ( empty( $module ) ) {
				$module = str_replace(
					WM_Shortcodes::$prefix_shortcode,
					'',
					basename( __FILE__, '.php' )
				);
			}

			self::$module = $module;
			self::$args   = (array) WM_Amplifier_Beaver_Builder::get_definitions( $module );


		// Processing

			parent::__construct( self::$args['register'] );

	} // /__construct



	/**
	 * Run all required registrations
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 */
	public static function register()) {

		// Processing

			self::register_module();
			self::register_settings_form();

	} // /register



	/**
	 * Register module with Beaver Builder
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 */
	public static function register_module() {

		// Processing

			if (
				isset( self::$args['form'] )
				&& ! empty( self::$args['form'] )
			) {

				/**
				 * @param  string $class  The module's PHP class name.
				 * @param  array  $form   The module's settings form data.
				 */
				FLBuilder::register_module(
					__CLASS__,
					self::$args['form']
				);

			}

	} // /register_module



	/**
	 * Register
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 */
	public static function register_settings_form() {

		// Processing

			if (
				isset( self::$args['form_children'] )
				&& ! empty( self::$args['form_children'] )
			) {

				/**
				 * @param  string $id    The form id.
				 * @param  array  $form  The form data.
				 */
				FLBuilder::register_settings_form(
					'wm_children_form_' . self::$module,
					self::$args['form_children']
				);

			}

	} // /register_settings_form





} // /WM_BB_Module_Accordion
