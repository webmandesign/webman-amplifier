<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Hidden elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Hidden input
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_hidden' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_hidden( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'  => 'hidden',  //Field type name *
			'id'    => 'id',      //Field ID (form field name) *
			'value' => '',        //Default value
		) );

		// Field ID setup
		$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

		// Output

			$output =
				PHP_EOL . "\t"
				. '<tr
					class="option hidden-wrap option-' . esc_attr( $field['id'] ) . '"
					data-option="' . esc_attr( $field['id'] ) . '"
					>'
				. '<td colspan="2">';

			// Input field
			$output .=
				PHP_EOL . "\t\t"
				. '<input
					type="' . esc_attr( $field['type'] ) . '"
					name="' . esc_attr( $field['id'] ) . '"
					id="' . esc_attr( $field['id'] ) . '"
					value="' . esc_attr( $value ) . '"
					>';

			$output .= PHP_EOL . "\t" . '</td></tr>';

			echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

	}
} // /wma_field_hidden

add_action( 'wmhook_metabox_render_hidden', 'wma_field_hidden', 10, 2 );



/**
 * Hidden input validation
 *
 * @since       1.0
 * @version     1.6.0
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 */
if ( ! function_exists( 'wma_field_hidden_validation' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_hidden_validation( $new, $field, $post_id ) {
		return sanitize_text_field( $new );
	}
} // /wma_field_hidden_validation

add_action( 'wmhook_metabox_saving_hidden', 'wma_field_hidden_validation', 10, 3 );
