<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Text and color elements
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
 * Text input (used also as color and password input)
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_text' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_text( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'        => 'text',  //Field type name *
			'id'          => 'id',    //Field ID (form field name) *
			'label'       => '',      //Field label
			'description' => '',      //Field description
			'default'     => '',      //Default value
			'class'       => '',      //Additional CSS class
			'attributes'  => '',      //Additional HTML attributes applied on input field
			'validate'    => '',      //Field output validation
			'empty'       => false,   //Can be empty or should there always be default value applied?
			'repeater'    => false,   //Special values when used in Repeater field
			'conditional' => '',      //Conditional display setup
		) );

		if ( 'color' == $field['type'] ) {
			$field['type']     = 'text';
			$field['validate'] = 'color';
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

		if ( $field['validate'] ) {
			switch ( $field['validate'] ) {

				case 'url':
					$value = esc_url( $value );
					break;

				case 'absint':
					$value = absint( $value );
					$field['type'] = 'number';
					break;

				case 'int':
					$value = intval( $value );
					$field['type'] = 'number';
					break;

				case 'email':
					$field['type'] = 'email';
					break;

				case 'color':
					$value = preg_replace( '/[^a-fA-F0-9\#]/', '', $value );
					$field['class'] = 'color-wrap ' . $field['class'];
					break;

				default:
					break;
			}
		}

		$value = (string) apply_filters( 'wmhook_metabox_wma_field_text_sanitize', sanitize_text_field( $value ), $field, $page_template );

		if ( $value || $field['empty'] ) {
			$value = esc_html( $value );
		} else {
			$value = esc_html( $field['default'] );
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
					class="option text-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
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
			$output .=
				PHP_EOL . "\t\t"
				. '<input
					type="' . esc_attr( $field['type'] ) . '"
					name="' . esc_attr( $field['id'] ) . '"
					id="' . esc_attr( $field['id'] ) . '"
					value="' . esc_attr( $value ) . '"
					class="fieldtype-text"'
					. ' ' . $field['attributes']
					. '>';

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
} // /wma_field_text

add_action( 'wmhook_metabox_render_color',    'wma_field_text', 10, 2 );
add_action( 'wmhook_metabox_render_password', 'wma_field_text', 10, 2 );
add_action( 'wmhook_metabox_render_text',     'wma_field_text', 10, 2 );



/**
 * Text input validation
 *
 * @since       1.0
 * @version     1.6.0
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 */
if ( ! function_exists( 'wma_field_text_validation' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_text_validation( $new, $field, $post_id ) {

		$new = sanitize_text_field( $new );

		if ( isset( $field['validate'] ) && $field['validate'] ) {
			switch ( $field['validate'] ) {

				case 'url':
					$new = esc_url( $new );
					break;

				case 'absint':
					$new = absint( $new );
					break;

				case 'int':
					$new = intval( $new );
					break;

				case 'email':
					$new = ( is_email( $new ) ) ? ( $new ) : ( '' );
					break;

				case 'color':
					$new = preg_replace( '/[^a-fA-F0-9\#]/', '', $new );
					break;

				default:
					break;
			}
		}

		return $new;

	}
} // /wma_field_text_validation

add_action( 'wmhook_metabox_saving_color',    'wma_field_text_validation', 10, 3 );
add_action( 'wmhook_metabox_saving_password', 'wma_field_text_validation', 10, 3 );
add_action( 'wmhook_metabox_saving_text',     'wma_field_text_validation', 10, 3 );



/**
 * Textarea (used also as visual editor)
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_textarea' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_textarea( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'type'        => 'textarea',  //Field type name *
			'id'          => 'id',        //Field ID (form field name) *
			'label'       => '',          //Field label
			'description' => '',          //Field description
			'default'     => '',          //Default value
			'class'       => '',          //Additional CSS class
			'attributes'  => 'rows="3"',  //Additional HTML attributes applied on input field
			'empty'       => false,       //Can be empty or should there always be default value applied?
			'editor'      => false,       //Display visual editor?
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

		if ( $value || $field['empty'] ) {
			$value = ( ! $field['editor'] ) ? ( esc_textarea( $value ) ) : ( $value );
		} else {
			$value = ( ! $field['editor'] ) ? ( esc_textarea( $field['default'] ) ) : ( $field['default'] );
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
					class="option textarea-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
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
			if ( ! $field['editor'] ) {

				$output .=
					PHP_EOL . "\t\t"
					. '<textarea
						name="' . esc_attr( $field['id'] ) . '"
						id="' . esc_attr( $field['id'] ) . '"
						class="fieldtype-textarea"'
						. ' ' . $field['attributes']
						. '>'
					. $value
					. '</textarea>';

			} else {

				ob_start();
				wp_editor( $value, $field['id'] );
				$output .= ob_get_clean();
			}

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
} // /wma_field_textarea

add_action( 'wmhook_metabox_render_textarea', 'wma_field_textarea', 10, 2 );



/**
 * Textarea validation
 *
 * @since       1.0
 * @version     1.6.0
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 * @author      WebMan
 */
if ( ! function_exists( 'wma_field_textarea_validation' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_textarea_validation( $new, $field, $post_id ) {
		return sanitize_textarea_field( $new );
	}
} // /wma_field_textarea_validation

add_action( 'wmhook_metabox_saving_textarea', 'wma_field_textarea_validation', 10, 3 );
