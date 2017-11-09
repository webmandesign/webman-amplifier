<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPML Beaver Builder children translation class
 *
 * This class takes care of these shortcodes:
 * - [accordion]
 * - [tabs]
 *
 * @see  WM_Amplifier_WPML::beaver_builder_modules_to_translate()
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
class WM_Amplifier_WPML_Beaver_Builder_Children extends WPML_Beaver_Builder_Module_With_Items {

	private static $module_id = '';

	private static $supported_fields = array();





	/**
	 * Get Beaver Builder children elements in array
	 *
	 * @since    1.5.0
	 * @version  1.5.0
	 */
	public function &get_items( $settings ) {

		// Processing

			// Get module ID

				if ( isset( $settings->type ) ) {
					self::$module_id = str_replace(
						WM_Shortcodes::$prefix_shortcode,
						'',
						$settings->type
					);
				}

			// Output only the children in array

				if ( isset( $settings->children ) ) {
					$output = (array) $settings->children;
				} else {
					$output = array();
				}

			// Get option fields of a child to prevent PHP warnings of non existent field (see below)

				if ( isset( $output[0] ) ) {
					self::$supported_fields = array_keys( (array) $output[0] );
				}


		// Output

			return $output;

	} // /get_items



	/**
	 * Child element option field IDs to translate
	 *
	 * @since    1.5.0
	 * @version  1.5.0
	 */
	public function get_fields() {

		// Output

			return array_intersect( array(
				'title',
				'content',
				'tags',
			), self::$supported_fields );

	} // /get_fields




	/**
	 * Child element option field labels
	 *
	 * @todo  Prefix field names with shortcode name.
	 *
	 * @since    1.5.0
	 * @version  1.5.0
	 */
	protected function get_title( $field ) {

		// Helper variables

			$custom_modules       = (array) WM_Shortcodes::get_definitions_processed( 'bb_plugin' );
			$module_name_prefixed = WM_Shortcodes::$prefix_shortcode_name . $custom_modules[ self::$module_id ]['name'];


		// Processing

			switch( $field ) {

				case 'title':
					return $module_name_prefixed . ': "' . esc_html__( 'Title', 'webman-amplifier' ) . '"';

				case 'content':
					return $module_name_prefixed . ': "' . esc_html__( 'Content', 'webman-amplifier' ) . '"';

				case 'tags':
					return $module_name_prefixed . ': "' . esc_html__( 'Tags', 'webman-amplifier' ) . '"';

				default:
					return '';

			}

	} // /get_title




	/**
	 * Child element option field types
	 *
	 * @since    1.5.0
	 * @version  1.5.0
	 */
	protected function get_editor_type( $field ) {

		// Processing

			switch( $field ) {

				case 'title':
					return 'LINE';

				case 'content':
					return 'VISUAL';

				case 'tags':
					return 'LINE';

				default:
					return '';

			}

	} // /get_editor_type





} // /WM_Amplifier_WPML_Beaver_Builder_Children
