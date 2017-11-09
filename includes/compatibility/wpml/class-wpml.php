<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPML plugin compatibility class
 *
 * Making custom Beaver Builder elements/modules/shortcodes translatable with WPML.
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
class WM_Amplifier_WPML {





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

						add_filter( 'wpml_beaver_builder_modules_to_translate', __CLASS__ . '::beaver_builder_modules_to_translate' );

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
		 * Register custom Beaver Builder modules to translate with WPML
		 *
		 * The `wpml_fields` array should consist of fields destined for translation setup only.
		 * Format of the array within shortcode `bb_plugin` definition array is as follows:
		 * @example
		 * 	@see  WPML_Beaver_Builder_Translatable_Nodes::initialize_nodes_to_translate()
		 * 	'wpml_fields' => array(
		 * 		array(
		 * 			'field'       => 'option_field_id',
		 * 			'type'        => 'Localized option field label text',
		 * 			'editor_type' => 'LINK/VISUAL/AREA', // @see  WPML_TM_Page_Builders()
		 * 		),
		 * 	),
		 *
		 * Other setup parameters will be automatically generated. The translatable field label
		 * will get prefixed by Beaver Builder module (shortcode) name for better reference.
		 *
		 * For parent shortcodes (the ones containing some children items, such as [accordion])
		 * we need to create a PHP class file (in the same directory as this file, basically) of
		 * `WMAMP_INCLUDES_DIR . 'compatibility/wpml/class-wpml-bb-NO-PREFIX-MODULE.php`
		 * where we declare a `WM_Amplifier_WPML_Beaver_Builder_No_Prefix_Module` PHP class.
		 * @example
		 * 	@see  WPML_Beaver_Builder_Accordion()
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 *
		 * @param  array $nodes
		 */
		public static function beaver_builder_modules_to_translate( $nodes = array() ) {

			// Requirements check

				if (
					! class_exists( 'WPML_Beaver_Builder_Translatable_Nodes' )
					|| ! is_callable( 'WM_Shortcodes::get_definitions_processed' )
				) {
					return $nodes;
				}


			// Helper variables

				$custom_translatable_modules = array();

				$custom_modules = (array) WM_Shortcodes::get_definitions_processed( 'bb_plugin' );

				$path = WMAMP_INCLUDES_DIR . 'compatibility/wpml/';


			// Processing

				foreach ( $custom_modules as $module => $args ) {
					if (
						isset( $args['wpml_fields'] )
						&& is_array( $args['wpml_fields'] )
					) {

						$module_prefixed = WM_Shortcodes::$prefix_shortcode . $module;

						// Set module type

							$custom_translatable_modules[ $module_prefixed ]['conditions'] = array( 'type' => $module_prefixed );

						// Set parent modules PHP classes

							$class_file = $path . 'class-wpml-bb-' . $module . '.php';

							if ( file_exists( $class_file ) ) {
								$integration_class = str_replace( '-', ' ', $module );
								$integration_class = ucwords( $integration_class );
								$integration_class = str_replace( ' ', '_', $integration_class );
								$integration_class = 'WM_Amplifier_WPML_Beaver_Builder_' . $integration_class;

								// $custom_translatable_modules[ $module ]['integration-class'] = $integration_class;

								/**
								 * Not ideal solution loading files here, but not harmful either.
								 * If there was any action to hook onto, it would be great though...
								 */
								require_once $class_file;
							}

						// Set module fields

							foreach ( $args['wpml_fields'] as $key => $field ) {
								// Prefix translation field name (no idea why it is called `type` in WPML...)
								$module_name = WM_Shortcodes::$prefix_shortcode_name . $args['name'];
								$args['wpml_fields'][ $key ]['type'] = $module_name . ': "' . $field['type'] . '"';
							}

							$custom_translatable_modules[ $module_prefixed ]['fields'] = $args['wpml_fields'];

					}
				}


			// Output

				return array_merge( $nodes, $custom_translatable_modules );

		} // /beaver_builder_modules_to_translate





} // /WM_Amplifier_WPML

add_action( 'init', 'WM_Amplifier_WPML::init' );
