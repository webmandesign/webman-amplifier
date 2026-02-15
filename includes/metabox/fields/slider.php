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
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Numeric slider / Range
 *
 * @since    1.0
 * @version  1.6.0
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
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

		$value = wma_meta_option( $field['id'] );

		// Value processing
		if (
			$value
			|| ( $field['zero'] && 0 === intval( $value ) )
		) {
			$value = intval( $value );
		} else {
			$value = intval( $field['default'] );
		}

		// Field ID setup
		$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];


	// Output

		$output =
			PHP_EOL . "\t"
			. '<tr
				class="option range-wrap option-' . esc_attr( trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) ) . '"
				data-option="' . esc_attr( $field['id'] ) . '"
				>'
			. '<th>';

		// Label
		$output .=
			PHP_EOL . "\t\t"
			. '<label for="' . esc_attr( $field['id'] ) . '">'
			. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
			. '</label>';

		$output .= PHP_EOL . "\t" . '</th><td>';

		// Input field
		$output .=
			PHP_EOL . "\t\t"
			. '<input
				type="number"
				name="' . esc_attr( $field['id'] ) . '"
				id="' . esc_attr( $field['id'] ) . '"
				value="' . esc_attr( $value ) . '"
				size="5"
				maxlength="5"
				/>';

		$output .=
			PHP_EOL . "\t\t"
			. '<span class="fieldtype-range">'
			. '<span
				id="' . esc_attr( $field['id'] ) . '-slider"
				data-min="' . esc_attr( intval( $field['min'] ) ) . '"
				data-max="' . esc_attr( intval( $field['max'] ) ) . '"
				data-step="' . esc_attr( intval( $field['step'] ) ) . '"
				data-value="' . esc_attr( $value ) . '"
				></span>'
			. '</span>';

		// Description
		if ( trim( $field['description'] ) ) {
			$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
		}

		// Reset default value button
		if ( trim( $field['default'] ) && empty( $field['editor'] ) ) {
			$output .=
				PHP_EOL . "\t\t"
				. '<a
					data-option="' . esc_attr( $field['id'] ) . '"
					class="button-default-value default-slider"
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

} // /wma_field_slider

add_action( 'wmhook_metabox_render_slider', 'wma_field_slider', 10, 2 );



/**
 * Numeric slider / Range validation
 *
 * @since    1.0
 * @version  1.2.2
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
function wma_field_slider_validation( $new, $field, $post_id ) {

	// Output

		return intval( $new );

} // /wma_field_slider_validation

add_action( 'wmhook_metabox_saving_slider', 'wma_field_slider_validation', 10, 3 );
