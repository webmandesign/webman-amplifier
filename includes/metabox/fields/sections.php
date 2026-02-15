<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Section elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * SECTIONS
 */

	/**
	 * Section open
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 *
	 * @since       1.0
	 * @version     1.6.0
	 */
	if ( ! function_exists( 'wma_field_section_open' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_section_open( $field, $page_template = null ) {

			// Set default value for page template.
			if ( empty( $page_template ) ) {
				$page_template = 'default';
			}

			// Field definition array.
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type'     => 'section-open',  //Field type name *
				'id'       => 'id',            //Field ID (form field name) *
				'no-table' => false,           //Whether to output a table wrapper
				'title'    => 'Title',         //Field title *
				'page'     => array(
					'templates' => array(),  //Array of page templates
					'operand'   => 'IS'      //Whether to display IS or IS_NOT page templates set above
				),
			) );

			// Section ID setup.
			$field['id'] = WM_METABOX_FIELD_PREFIX . 'section-' . $field['id'];

			// Check whether to display for particular page template.
			$classes = $output_script = '';

			if ( ! empty( $field['page']['templates'] ) ) {

				// Set default operand.
				if ( empty( $field['page']['operand'] ) ) {
					$field['page']['operand'] = 'IS';
				}

				// Check if page template is in the array.
				$template_check = in_array( $page_template, (array) $field['page']['templates'] );

				// Depending on operand, set the classes.
				if ( 'IS' === $field['page']['operand'] ) {
					// Only if page template is in the array.
					$classes .= ( $template_check ) ? ( '' ) : ( ' hide' );
				} else {
					// Only if the page template is NOT in the array.
					$classes .= ( $template_check ) ? ( ' hide' ) : ( '' );
				}

				// Set the script to be outputted.
				$output_script = true;
			}


			// Output

				$no_table = ( $field['no-table'] ) ? ( ' no-table' ) : ( '' );
				$classes .= $no_table;

				echo
					PHP_EOL . '<!-- SECTION -->'
					. PHP_EOL
					. '<div id="' . esc_attr( $field['id'] ) . '" class="tab-content' . esc_attr( $classes ) . '">'
					. PHP_EOL;

					// Output table wrapper start.
					if ( ! $no_table ) {
						echo
							"\t"
							. '<table class="form-table">'
							. '<tbody>'
							. PHP_EOL;
					}

				// Page templates conditional display.
				if ( $output_script ) {

					wp_add_inline_script(
						'wm-metabox-scripts',
						'( function( jQuery, wp ) { wp.domReady( wmaMetaboxTemplates( '
						. json_encode( array(
							'id'       => esc_attr( $field['id'] ),
							'values'   => (array) $field['page']['templates'],
							'operand'  => $field['page']['operand'],
							'template' => $page_template,
						) )
						. ' ) ); } )( jQuery, wp );'
					);
				}

		}
	} // /wma_field_section_open

	add_action( 'wmhook_metabox_render_section-open', 'wma_field_section_open', 10, 2 );



	/**
	 * Section close
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_section_close' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_section_close( $field, $page_template = null ) {

			// Field definition array
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type'     => 'section-close', //Field type name *
				'no-table' => false            //Whether to output a table wrapper
			) );

			// Output

				if ( ! $field['no-table'] ) {
					echo PHP_EOL . PHP_EOL . "\t</tbody></table>";
				}

				echo PHP_EOL . '</div> <!-- /tab-content /SECTION -->' . PHP_EOL;

		}
	} // /wma_field_section_close

	add_action( 'wmhook_metabox_render_section-close', 'wma_field_section_close', 10, 2 );



/**
 * SUBSECTIONS
 */

	/**
	 * Sub-section open
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 *
	 * @since       1.0
	 * @version     1.6.0
	 */
	if ( ! function_exists( 'wma_field_sub_section_open' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_sub_section_open( $field, $page_template = null ) {

			// Field definition array
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type' => 'sub-section-open',  //Field type name *
				'id'   => 'id',                //Field ID (form field name) *
			) );

			// Sub-section ID setup
			$field['id'] = WM_METABOX_FIELD_PREFIX . 'sub-section-' . $field['id'];

			// Output

				echo
					PHP_EOL . "\t"
					. '</tbody>'
					. PHP_EOL . "\t" . '<!-- SUB-SECTION -->'
					. PHP_EOL . "\t"
					. '<tbody id="' . esc_attr( $field['id'] ) . '" data-option="' . esc_attr( $field['id'] ) . '">';

		}
	} // /wma_field_sub_section_open

	add_action( 'wmhook_metabox_render_sub-section-open', 'wma_field_sub_section_open', 10, 2 );



	/**
	 * Sub-section close
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 *
	 * @since    1.0
	 * @version  1.1.6
	 */
	if ( ! function_exists( 'wma_field_sub_section_close' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_sub_section_close( $field, $page_template = null ) {

			// Field definition array
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type'        => 'sub-section-close', //Field type name *
				'id'          => '',                  //Field ID (form field name) *
				'conditional' => '',                  //Conditional display setup
			) );

			// Sub-section ID setup
			$field['id'] = WM_METABOX_FIELD_PREFIX . 'sub-section-' . $field['id'];

			// Output

				// Conditional display
				do_action( 'wmhook_metabox_conditional', $field, $field['id'] );

				echo PHP_EOL . "\t" . '</tbody> <!-- /SUB-SECTION -->' . PHP_EOL . "\t" . '<tbody>';

		}
	} // /wma_field_sub_section_close

	add_action( 'wmhook_metabox_render_sub-section-close', 'wma_field_sub_section_close', 10, 2 );
