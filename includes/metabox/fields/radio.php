<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Radio button elements
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
 * Radio buttons
 *
 * @since    1.0
 * @version  1.6.0
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
function wma_field_radio( $field, $page_template = null ) {

	// Helper variables

		// Definition

			$field = wp_parse_args( (array) $field, array(
				// DEFAULTS:
				// * = Required setting
				'type'        => 'radio',  // Field type name *
				'id'          => 'id',     // Field ID (form field name) *
				'label'       => '',       // Field label
				'description' => '',       // Field description
				'class'       => '',       // Additional CSS class
				'options'     => array(),  // Radio options (array( key => value ))
				'default'     => '',       // Default value
				'inline'      => false,    // By default the radio buttons are displayed as list. You can align them in a row here.
				'filter'      => false,    // Whether to display filter. Only for custom HTML radios.
				'repeater'    => false,    // Special values when used in Repeater field
				'custom'      => '',       // Custom label HTML (use "{{value}}"" to substitute for current item value and "{{name}}"" to display the item name)
				'hide-radio'  => false,    // If set to true, the ".hide" CSS class will be applied on radio input field (useful with custom label HTML)
				'conditional' => '',       // Conditional display setup
			) );

		// Alter class when custom label HTML used

			if ( trim( $field['custom'] ) ) {
				$field['class'] = 'custom-label ' . $field['class'];
			}

			if ( $field['hide-radio'] ) {
				$field['hide-radio'] = ' hide';
			}

			if ( $field['filter'] ) {
				$field['class'] .= ' filterable';
			}

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

			if ( $value ) {
				$value = esc_attr( $value );
			} else {
				$value = esc_attr( $field['default'] );
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
				class="option radio-wrap option-' . esc_attr( trim( $field['id'] . ' ' . $field['class'] ) ) . '"
				data-option="' . esc_attr( $field['id'] ) . '">'
			. '<th>';

		// Radio group label
		$output .=
			PHP_EOL . "\t\t"
			. '<strong class="label">'
			. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
			. '</strong>';

		// Description
		if ( trim( $field['description'] ) ) {
			$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
		}

		// Filter
		if ( $field['filter'] ) {
			$output .=
				PHP_EOL . "\t\t"
				. '<p class="filter">'
				. '<input
					type="text"
					value=""
					placeholder="' . esc_attr__( 'Filter: start typing...', 'webman-amplifier' ) . '"
					class="filter-text"
					/>'
				. '</p>';
		}

		$output .= PHP_EOL . "\t" . '</th><td>';

		// Input field
		if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {

			$i = 0;

			$output .= PHP_EOL . "\t" . '<div class="radio-items">';

			foreach ( $field['options'] as $option_value => $option ) {

				$i++;

				$output .= PHP_EOL . "\t\t";
				$output .= ( ! $field['inline'] ) ? ( '<p class="radio-item"' ) : ( '<span class="radio-item inline-radio"' );
				$output .= ' data-value="' . esc_attr( $option_value ) . '">';

					$checked = trim( checked( $value, $option_value, false ) . ' /' );
					$option  = trim( strip_tags( $option, WM_METABOX_LABEL_HTML ) );

					if ( ! trim( $field['custom'] ) ) {

						$output .=
							'<input
								type="' . esc_attr( $field['type'] ) . '"
								name="' . esc_attr( $field['id'] ) . '"
								id="' . esc_attr( $field['id'] . '-' . $i ) . '"
								value="' . esc_attr( $option_value ) . '"
								title="' . esc_attr( $option ) . '"
								class="fieldtype-radio" '
								. $checked
								. '> ';

						$output .= '<label for="' . esc_attr( $field['id'] . '-' . $i ) . '">' . $option . '</label>';

					} else {

						$output .= '<label for="' . esc_attr( $field['id'] . '-' . $i ) . '">' . trim( str_replace(
							array( '{{value}}', '{{name}}' ),
							array( $option_value, $option ),
							$field['custom']
						) ) . '</label>';

						$output .=
							'<input
								type="' . esc_attr( $field['type'] ) . '"
								name="' . esc_attr( $field['id'] ) . '"
								id="' . esc_attr( $field['id'] . '-' . $i ) . '"
								value="' . esc_attr( $option_value ) . '"
								title="' . esc_attr( $option ) . '"
								class="fieldtype-radio' . esc_attr( $field['hide-radio'] ) . '" '
								. $checked
								. '>';
					}

				$output .= ( ! $field['inline'] ) ? ( '</p>' ) : ( '</span> ' );
			}

			$output .= PHP_EOL . "\t" . '</div>';
		}

		// Reset default value button
		if ( trim( $field['default'] ) ) {
			$output .=
				PHP_EOL . "\t\t"
				. '<a
					data-option="' . esc_attr( $field['id'] ) . '"
					class="button-default-value"
					title="' . esc_attr__( 'Use a default value', 'webman-amplifier' ) . '"
					>'
				. '<span>'
				. $field['default']
				. '</span>'
				. '</a>';
		}

		// Conditional display
		ob_start();
		do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
		$output .= ob_get_clean() . PHP_EOL . "\t" . '</td></tr>';

		echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

} // /wma_field_radio

add_action( 'wmhook_metabox_render_radio', 'wma_field_radio', 10, 2 );



/**
 * Radio buttons validation
 *
 * @since    1.0
 * @version  1.2.2
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
function wma_field_radio_validation( $new, $field, $post_id ) {

	// Output

		return esc_attr( $new );

} // /wma_field_radio_validation

add_action( 'wmhook_metabox_saving_radio', 'wma_field_radio_validation', 10, 3 );
