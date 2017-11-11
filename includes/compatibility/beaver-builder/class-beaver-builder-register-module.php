<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper class to register Beaver Builder module
 *
 * All modules are registered the same way, so there is no need to copy
 * the same code over and over.
 *
 * INITIALIZE:
 * You need to initialize this class within a module registration file calling
 * `WM_Amplifier_Beaver_Builder_Register_Module::register( __FILE__ )`.
 *
 * IMPORTANT:
 * The module registration filename is used in Beaver Builder as module ID,
 * so it has to be unique! And that's why we need to prefix those files
 * with WM_Shortcodes::$prefix_shortcode.
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

	private static $class;





	/**
	 * Constructor
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 */
	public function __construct() {

		// Processing

			parent::__construct( self::$args['register'] );

	} // /__construct



	/**
	 * Run all required registrations
	 *
	 * Module registration file (path) is required for this to run properly.
	 * Module ID will be determined from the file name, so your module registration
	 * file names should actually match the shortcode/module ID (+ prefix).
	 *
	 * @since    1.6.0
	 * @version  1.6.0
	 *
	 * @param  string $module_file  Filename, usually just pass the __FILE__ as value.
	 */
	public static function register( $module_file = '' ) {

		// Requirements check

			if ( empty( $module_file ) ) {
				return;
			}


		// Helper variables

			$module_file = str_replace(
				WM_Shortcodes::$prefix_shortcode,
				'',
				basename( $module_file, '.php' )
			);

			self::$module = $module_file;
			self::$args   = (array) WM_Amplifier_Beaver_Builder::get_definitions_processed( $module_file );
			self::$class  = get_called_class();


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
					self::$class,
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
