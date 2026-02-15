<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Checkbox elements
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
 * Checkbox
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_checkbox' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_checkbox( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'        => 'checkbox',  //Field type name *
			'id'          => 'id',        //Field ID (form field name) *
			'label'       => '',          //Field label
			'description' => '',          //Field description
			'value'       => true,        //The actual field value
			'class'       => '',          //Additional CSS class
			'attributes'  => '',          //Additional HTML attributes applied on input field
			'repeater'    => false,       //Special values when used in Repeater field
			'conditional' => '',          //Conditional display setup
		) );

		// Value processing
		if (
			$field['repeater']
			&& is_array( $field['repeater'] )
			&& isset( $field['repeater']['value'] )
		) {
			$value = $field['repeater']['value'];
		} else {
			$value = wma_meta_option( $field['id'] );
		}

		// Field ID setup
		if (
			$field['repeater']
			&& is_array( $field['repeater'] )
			&& isset( $field['repeater']['id'] )
		) {
			$field['id'] = $field['repeater']['id'];
		} else {
			$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];
		}

		// Output

			$output =
				PHP_EOL . "\t"
				. '<tr
					class="option checkbox-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
					data-option="' . esc_attr( $field['id'] ) . '"
					>'
				. '<th colspan="2">';

			// Input field
			$output .=
				PHP_EOL . "\t\t"
				. '<input
					type="' . esc_attr( $field['type'] ) . '"
					name="' . esc_attr( $field['id'] ) . '"
					id="' . esc_attr( $field['id'] ) . '"
					value="' . esc_attr( $field['value'] ) . '"
					class="fieldtype-checkbox" '
					. checked( $value, $field['value'], false )
					. ' ' . $field['attributes']
					. '>';

			// Label
			$output .=
				' <label for="' . esc_attr( $field['id'] ) . '">'
				. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
				. '</label>';

			// Description
			if ( trim( $field['description'] ) ) {
				$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
			}

			// Conditional display
			ob_start();
			do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
			$output .= ob_get_clean() . PHP_EOL . "\t" . '</th></tr>';

			echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

	}
} // /wma_field_checkbox

add_action( 'wmhook_metabox_render_checkbox', 'wma_field_checkbox', 10, 2 );



/**
 * Checkbox validation
 *
 * @since       1.0
 * @version     1.6.0
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 */
if ( ! function_exists( 'wma_field_checkbox_validation' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_checkbox_validation( $new, $field, $post_id ) {
		return (bool) $new;
	}
} // /wma_field_checkbox_validation

add_action( 'wmhook_metabox_saving_checkbox', 'wma_field_checkbox_validation', 10, 3 );
