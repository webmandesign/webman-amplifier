<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Conditional display JavaScript
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Conditional display JavaScript
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_conditional_show' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_conditional_show( $field, $option_id = null ) {

		if (
			! trim( $option_id )
			|| ! is_array( $field )
			|| ! isset( $field['conditional'] )
			|| empty( $field['conditional'] )
		) {
			return;
		}

		// Helper variables

			$conditional = wp_parse_args( (array) $field['conditional'], array(
				// DEFAULTS:
				'option' => array( // Option field setup
					'tag'  => '',    // Option field tag (such as "input" or "select")
					'name' => '',    // Option field name attribute
					'type' => '',    // Option field type attribute (such as "checkbox")
				),
				'option_value' => array(), // Value(s) to check against (array)
				'operand'      => 'IS',    // Checks the option for the value (IS or IS_NOT)
			) );

			if (
				empty( $conditional['option_value'] )
				|| empty( $conditional['operand'] )
				|| empty( $conditional['option']['tag'] )
				|| empty( $conditional['option']['name'] )
			) {
				return;
			}

			if ( empty( $conditional['option']['type'] ) ) {
				$conditional['option']['type'] = $conditional['option']['tag'];
			}

			// Make sure also values of type `string` are included (for non-string values).
			$values        = (array) $conditional['option_value'];
			$values_string = array_filter( array_map( function( $value ) {

				if ( ! is_string( $value ) ) {
					return (string) $value;
				}

				return false;

			}, $values ) );


		// Processing

			wp_add_inline_script(
				'wm-metabox-scripts',
				'( function( jQuery ) { wmaMetaboxConditional( '
				. json_encode( array(
					'id'      => esc_attr( $option_id ),
					'values'  => (array) array_merge( $values, $values_string ),
					'operand' => $conditional['operand'],
					'field'   => $conditional['option']['tag'] . "[name='" . $conditional['option']['name'] . "']",
					'type'    => $conditional['option']['type'],
				) )
				. ' ); } )( jQuery );'
			);

	}
} // /wma_conditional_show

add_action( 'wmhook_metabox_conditional', 'wma_conditional_show', 10, 2 );
