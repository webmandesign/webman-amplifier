<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Select (dropdown) element
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
 * Select
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_select' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_select( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'        => 'select',  //Field type name *
			'id'          => 'id',      //Field ID (form field name) *
			'label'       => '',        //Field label
			'description' => '',        //Field description
			'class'       => '',        //Additional CSS class
			'attributes'  => '',        //Additional HTML attributes applied on input field
			'options'     => array(),   //Dropdown options (array( key => value ), or array( '1OPTGROUP' => 'Title', key => value, ..., '1/OPTGROUP' => '' ).)
			'default'     => '',        //Default value
			'repeater'    => false,     //Special values when used in Repeater field
			'conditional' => '',        //Conditional display setup
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

		if ( $value && is_array( $value ) ) {
			$value = (array) $value;
		} elseif ( $value ) {
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
					class="option select-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
					data-option="' . esc_attr( $field['id'] ) . '">'
				. '<th>';

			// Label
			$output .=
				PHP_EOL . "\t\t"
				. '<label for="' . esc_attr( $field['id'] ) . '">'
				. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
				. '</label>';

			$output .= PHP_EOL . "\t" . '</th><td>';

			// Input field

				$suffix = '';

				if ( false !== strpos( $field['attributes'], 'multiple' ) ) {
					$suffix = '[]';
				}

				$output .=
					PHP_EOL . "\t\t"
					. '<select
						name="' . esc_attr( $field['id'] . $suffix ) . '"
						id="' . esc_attr( $field['id'] ) . '"
						class="fieldtype-select"'
						. ' ' . $field['attributes']
						. '>';

				if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
					foreach ( $field['options'] as $option_value => $option ) {

						if ( false === strpos( $option_value, 'OPTGROUP' ) ) {

							// classic options
							if ( ! is_array( $value ) ) {
								$selected = selected( $value, $option_value, false );
							} else {
								$selected = ( in_array( $option_value, $value ) ) ? ( ' selected="selected"' ) : ( '' );
							}

							$output .=
								PHP_EOL . "\t\t\t\t"
								. '<option
									value="'. esc_attr( $option_value ) . '"'
									. $selected
									. '>'
									. wp_strip_all_tags( $option )
									. '</option>';

						} elseif ( 'OPTGROUP' === substr( $option_value, 1 ) ) {

							// open option group
							$output .= PHP_EOL . "\t\t\t" . '<optgroup label="' . esc_attr( $option ) . '">';

						} elseif ( '/OPTGROUP' === substr( $option_value, 1 ) ) {

							// close option group
							$output .= PHP_EOL . "\t\t\t" . '</optgroup>';
						}
					}
				}

				$output .= PHP_EOL . "\t\t" . '</select>';

			// Description
			if ( trim( $field['description'] ) ) {
				$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
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

	}
} // /wma_field_select

add_action( 'wmhook_metabox_render_select', 'wma_field_select', 10, 2 );



/**
 * Select validation
 *
 * @since       1.0
 * @version     1.6.0
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 */
if ( ! function_exists( 'wma_field_select_validation' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_select_validation( $new, $field, $post_id ) {
		return esc_attr( $new );
	}
} // /wma_field_select_validation

add_action( 'wmhook_metabox_saving_select', 'wma_field_select_validation', 10, 3 );
