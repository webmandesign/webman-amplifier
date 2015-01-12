<?php
/**
 * Beaver Builder plugin support
 *
 * @link  https://www.wpbeaverbuilder.com/
 *
 * @since    1.1
 * @version  1.1
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * CONTENT:
 * -  10) Actions and filters
 * -  20) Helpers
 * -  30) Assets
 * -  40) Modules
 * - 100) Other functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		add_action( 'init', 'wma_bb_custom_modules', 16 );
		add_action( 'init', 'wma_bb_shortcode_def',  19 );
		add_action( 'wp_enqueue_scripts', 'wma_bb_assets' );
		add_action( 'fl_builder_control_' . 'wm_radio', 'wma_bb_custom_field_wm_radio', 10, 3 );
		add_action( WM_SHORTCODES_HOOK_PREFIX . 'bb_module_output', 'wma_bb_custom_module_output', 10, 2 );





/**
 * 20) Helpers
 */

	/**
	 * Get Beaver Builder shortcode definitions
	 *
	 * @param  string $shortcode
	 * @param  string $property
	 */
	if ( ! function_exists( 'wma_bb_shortcode_def' ) ) {
		function wma_bb_shortcode_def( $shortcode, $property = '' ) {
			//Helper variables
				$output = '';

				$def = wma_shortcodes()->get_definitions()['bb_plugin'];

			//Preparing output
				if ( isset( $def[ $shortcode ] ) ) {
					$output = wp_parse_args( wma_shortcodes()->get_definitions()['bb_plugin'][ $shortcode ], array(
							'params'          => array(),
							'name'            => '-',
							'description'     => '',
							'category'        => __( 'WM Modules', 'wm_domain' ),
							'enabled'         => true,
							'editor_export'   => true, //Export content to WP editor?
							'dir'             => trailingslashit( WMAMP_INCLUDES_DIR ) . 'shortcodes/bb_addons/modules/' . $shortcode . '/',
							'url'             => trailingslashit( WMAMP_INCLUDES_URL ) . 'shortcodes/bb_addons/modules/' . $shortcode . '/',
							'output'          => '',
							'output_children' => '',
							'params'          => array(),
							'params_children' => array(),
							'form'            => array(),
							'form_children'   => array(),
						) );

					if ( $property && isset( $output[ $property ] ) ) {
						$output = $output[ $property ];
					} elseif ( $property && ! isset( $output[ $property ] ) ) {
						$output = '';
					}
				}

			//Output
				return $output;
		}
	} // /wma_bb_shortcode_def





/**
 * 30) Assets
 */

	/**
	 * Styles and scripts
	 */
	if ( ! function_exists( 'wma_bb_assets' ) ) {
		function wma_bb_assets() {
			//Styles
				wp_enqueue_style( 'wm-radio' );
		}
	} // /wma_bb_assets





/**
 * 40) Modules
 */

	/**
	 * Add custom modules
	 */
	if ( ! function_exists( 'wma_bb_custom_modules' ) ) {
		function wma_bb_custom_modules() {
			$defs = wma_shortcodes()->get_definitions()['bb_plugin'];

			if ( ! empty( $defs ) ) {
				foreach ( $defs as $module => $def ) {
					$module_file_path = trailingslashit( WMAMP_INCLUDES_DIR ) .'shortcodes/bb_addons/modules/' . $module . '/' . $module . '.php';

					if ( file_exists( $module_file_path ) ) {
						require_once( $module_file_path );
					}
				}
			}
		}
	} // /wma_bb_custom_modules



	/**
	 * Module output
	 *
	 * @param  string $module   Module name
	 * @param  array  $settings Settings passed from page builder form
	 */
	if ( ! function_exists( 'wma_bb_custom_module_output' ) ) {
		function wma_bb_custom_module_output( $module = '', $settings = array() ) {
			//Helper variables
				$shortcode_output = $replace_children = '';

				$output   = array(
						'parent' => (string) wma_bb_shortcode_def( $module, 'output' ),
						'child'  => (string) wma_bb_shortcode_def( $module, 'output_children' )
					);
				$params   = array(
						'parent' => (array) wma_bb_shortcode_def( $module, 'params' ),
						'child'  => (array) wma_bb_shortcode_def( $module, 'params_children' )
					);
				$children = ( isset( $settings->children ) ) ? ( array_filter( $settings->children ) ) : ( false );

			//Preparing output

				/**
				 * Basic form output (parent)
				 */

					foreach ( $params['parent'] as $param ) {

						$replace = '';
						$param   = trim( $param );

						if ( $param ) {
							if (
									isset( $settings->$param )
									&& is_string( $settings->$param )
									&& $settings->$param
								) {
								$replace = ( 'content' === $param ) ? ( $settings->$param ) : ( ' ' . $param . '="' . $settings->$param . '"' );
								$replace = apply_filters( 'wma_bb_custom_module_output_parent_replace', $replace, $module, $param, $settings );
							}

							$output['parent'] = str_replace( '{{' . $param . '}}', $replace, $output['parent'] );
						}

					} // /foreach

				/**
				 * Items form output (children)
				 */

					if (
							is_array( $children )
							&& ! empty( $children )
							&& ! empty( $params['child'] )
						) {

						foreach ( $children as $child ) {

							//Requirements check
								if ( ! is_object( $child ) || empty( $child ) ) {
									continue;
								}

							$replace_child = $output['child'];

							foreach ( $params['child'] as $param ) {

								$replace = '';
								$param   = trim( $param );

								if ( $param ) {
									if (
											isset( $child->$param )
											&& is_string( $child->$param )
											&& $child->$param
										) {
										$replace = ( 'content' === $param ) ? ( $child->$param ) : ( ' ' . $param . '="' . $child->$param . '"' );
										$replace = apply_filters( 'wma_bb_custom_module_output_child_replace', $replace, $module, $param, $settings );
									}

									$replace_child = str_replace( '{{' . $param . '}}', $replace, $replace_child );
								}

							} // /foreach

							$replace_children .= $replace_child;

						} // /foreach

					}

				/**
				 * Actual outputed shortcode
				 */

					$shortcode_output = str_replace( array( '{{children}}', '{{items}}' ), $replace_children, $output['parent'] );

			//Output
				echo $shortcode_output;
		}
	} // /wma_bb_custom_module_output





/**
 * 100) Other functions
 */

	/**
	 * Custom page builder input field: wm_radio
	 *
	 * @param  string $name
	 * @param  string $value
	 * @param  array  $field
	 */
	if ( ! function_exists( 'wma_bb_custom_field_wm_radio' ) ) {
		function wma_bb_custom_field_wm_radio( $name, $value, $field ) {
			//Output
				echo apply_filters( WM_SHORTCODES_HOOK_PREFIX . 'wma_bb_custom_field_' . 'wm_radio' . '_output', wma_custom_field_wm_radio( $name, $value, $field ), $name, $value, $field );
		}
	} // /wma_bb_custom_field_wm_radio

?>