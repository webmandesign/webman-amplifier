<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Dynamically added elements (repeater)
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
 * Dynamically added elements (repeater)
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_repeater' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_repeater( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'        => 'repeater',   //Field type name *
			'id'          => 'id',         //Field ID (form field name) *
			'label'       => '',           //Field label
			'description' => '',           //Field description
			'fields'      => '',           //Array of repeater cell fields
			'default'     => array( '' ),  //Default value
			'class'       => '',           //Additional CSS class
			'button-text' => '+',          //Preview image size
			'conditional' => '',           //Conditional display setup
		) );

		// Value processing

			$values = (array) wma_meta_option( $field['id'] );
			$values = array_filter( $values );

			if ( ! is_array( $values ) || empty( $values ) ) {
				$values = $field['default'];
			}

		// Field ID setup
		$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

		// Output

			$output =
				PHP_EOL . "\t"
				. '<tr
					class="option repeater-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
					data-option="' . esc_attr( $field['id'] ) . '">'
				. '<th>';

			// Label
			$output .=
				PHP_EOL . "\t\t"
				. '<label for="' . esc_attr( $field['id'] ) . '">'
				. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
				. '</label>';

			$output .= PHP_EOL . "\t" . '</th><td>';

			// Description
			if ( trim( $field['description'] ) ) {
				$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
			}

			$output .= PHP_EOL . "\t\t" . '<div class="repeater-cells">';

			// Repeater cells
			ob_start();
			if ( is_array( $values ) && ! empty( $values ) ) {
				$i = 0;

				foreach ( $values as $value ) {
					if ( is_array( $field['fields'] ) && ! empty( $field['fields'] ) ) {

						$field_output = PHP_EOL . "\t\t" . '<table class="repeater-cell">';

						// Controls row
						$field_output .=
							PHP_EOL . "\t\t\t"
							. '<thead class="repeater-cell-controls">'
							. '<tr>'
							. '<th colspan="2">'
							. PHP_EOL . "\t\t\t\t"
							. '<a
								class="button button-move-cell"
								data-id="' . esc_attr( $field['id'] ) . '"
								title="' . esc_attr__( 'Move the item', 'webman-amplifier' ) . '"
								>&equiv;</a>'
							. PHP_EOL . "\t\t\t\t"
							. '<a
								class="button button-remove-cell"
								data-id="' . esc_attr( $field['id'] ) . '"
								title="' . esc_attr__( 'Remove this item', 'webman-amplifier' ) . '"
								>-</a>'
							. PHP_EOL . "\t\t\t"
							. '</th>'
							. '</tr>'
							. '</thead>';

						$field_output .= PHP_EOL . "\t\t\t" . '<tbody>';

						echo $field_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see below

						// Fields row
						foreach ( $field['fields'] as $cell_field ) {

							if (
								isset( $cell_field['type'] )
								&& in_array(
									$cell_field['type'],
									// allow only certain field types in repeater
									array( 'checkbox', 'color', 'radio', 'text', 'textarea', 'select' )
								)
							) {

								// Passing special repeater values into field generator/renderer
								$cell_value = ( isset( $value[ $cell_field['id'] ] ) ) ? ( $value[ $cell_field['id'] ] ) : ( null );
								$cell_field['repeater'] = array(
									'id'    => $field['id'] . '[' . $i . '][' . $cell_field['id'] . ']',
									'value' => $cell_value,
								);

								// Display form fields using action hook (echo the function return)
								do_action( 'wmhook_metabox_render_' . $cell_field['type'], $cell_field, '' );
							}
						}

						echo PHP_EOL . "\t\t" . '<!-- /repeater-cell --></tbody></table>';
					}

					$i++;
				}
			}

			// Add repeater cell button
			echo
				PHP_EOL . "\t\t"
				. '</div> <!-- /repeater-cells -->'
				. PHP_EOL . "\t\t"
				. '<a
					href="#"
					class="button button-add-cell"
					data-id="' . esc_attr( $field['id'] ) . '"
					>'
				. esc_html( $field['button-text'] )
				. '</a>';

			// Conditional display
			do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
			$output .= ob_get_clean() . PHP_EOL . "\t" . '</td></tr>';

			echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

	}
} // /wma_field_repeater

add_action( 'wmhook_metabox_render_repeater', 'wma_field_repeater', 10, 2 );
