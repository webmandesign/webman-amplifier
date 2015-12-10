<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Numeric slider / Range element
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.2.2
 */



/**
 * RANGE (NUMERIC SLIDER)
 */

	/**
	 * Numeric slider / Range
	 *
	 * @since    1.0
	 * @version  1.2.2
	 */
	function wma_field_slider( $field, $page_template = null ) {

		// Helper variables

			// Definition

				$field = wp_parse_args( (array) $field, array(
						// DEFAULTS:
						// * = Required setting
						'type'        => 'slider',  // Field type name *
						'id'          => 'id',      // Field ID (form field name) *
						'label'       => '',        // Field label
						'description' => '',        // Field description
						'class'       => '',        // Additional CSS class
						'default'     => '',        // Default value
						'min'         => 0,         // Minimal value
						'max'         => 10,        // Maximal value
						'step'        => 1,         // Steps
						'zero'        => true,      // Zero value allowed?
						'conditional' => '',        // Conditional display setup
					) );

			// Value processing

				$value = wma_meta_option( $field['id'] );

				if (
						$value
						|| ( $field['zero'] && 0 === intval( $value ) )
					) {
					$value = esc_attr( intval( $value ) );
				} else {
					$value = esc_attr( intval( $field['default'] ) );
				}

			// Field ID setup

				$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];


		// Output

			$output  = "\r\n\t" . '<tr class="option range-wrap option-' . esc_attr( trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) ) . '" data-option="' . esc_attr( $field['id'] ) . '"><th>';

				// Label

					$output .= "\r\n\t\t" . '<label for="' . esc_attr( $field['id'] ) . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';

			$output .= "\r\n\t" . '</th><td>';

				// Input field

					$output .= "\r\n\t\t" . '<input type="number" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $value ) . '" size="5" maxlength="5" />';
					$output .= "\r\n\t\t" . '<span class="fieldtype-range"><span id="' . esc_attr( $field['id'] ) . '-slider" data-min="' . esc_attr( intval( $field['min'] ) ) . '" data-max="' . esc_attr( intval( $field['max'] ) ) . '" data-step="' . esc_attr( intval( $field['step'] ) ) . '" data-value="' . esc_attr( $value ) . '"></span></span>';

				// Description

					if ( trim( $field['description'] ) ) {
						$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
					}

				// Reset default value button

					if ( trim( $field['default'] ) ) {
						$output .= "\r\n\t\t" . '<a data-option="' . esc_attr( $field['id'] ) . '" class="button-default-value default-slider" title="' . esc_attr__( 'Use a default value', 'webman-amplifier' ) . '"><span>' . esc_attr( $field['default'] ) . '</span></a>';
					}

				echo $output;

			// Conditional display

				do_action( 'wmhook_metabox_' . 'conditional', $field, $field['id'] );

			echo "\r\n\t" . '</td></tr>';

	} // /wma_field_slider

	add_action( 'wmhook_metabox_' . 'render_' . 'slider', 'wma_field_slider', 10, 2 );



	/**
	 * Numeric slider / Range validation
	 *
	 * @since    1.0
	 * @version  1.2.2
	 */
	function wma_field_slider_validation( $new, $field, $post_id ) {

		// Output

			return intval( $new );

	} // /wma_field_slider_validation

	add_action( 'wmhook_metabox_' . 'saving_' . 'slider', 'wma_field_slider_validation', 10, 3 );
