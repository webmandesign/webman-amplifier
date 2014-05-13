<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Checkbox elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * CHECKBOX FIELDS
 */

	/**
	 * Checkbox
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_checkbox' ) ) {
		function wma_field_checkbox( $field, $page_template = null ) {
			//Field definition array
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

			//Value processing
				$field['value'] = esc_attr( $field['value'] );

				if (
						$field['repeater']
						&& is_array( $field['repeater'] )
						&& isset( $field['repeater']['value'] )
					) {
					$value = $field['repeater']['value'];
				} else {
					$value = wma_meta_option( $field['id'] );
				}

				$value = esc_attr( $value );

			//Field ID setup
				if (
						$field['repeater']
						&& is_array( $field['repeater'] )
						&& isset( $field['repeater']['id'] )
					) {
					$field['id'] = $field['repeater']['id'];
				} else {
					$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];
				}

			//Output
				$output  = "\r\n\t" . '<tr class="option checkbox-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th colspan="2">';
					//Input field
						$output .= "\r\n\t\t" . '<input type="' . $field['type'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $field['value'] . '" class="fieldtype-checkbox" ' . trim( checked( $value, $field['value'], false ) . ' ' . $field['attributes'] . ' /' ) . '>';
					//Label
						$output .= ' <label for="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</th></tr>';
		}
	} // /wma_field_checkbox

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'checkbox', 'wma_field_checkbox', 10, 2 );



	/**
	 * Checkbox validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_checkbox_validation' ) ) {
		function wma_field_checkbox_validation( $new, $field, $post_id ) {
			$new = esc_attr( $new );

			return $new;
		}
	} // /wma_field_checkbox_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'checkbox', 'wma_field_checkbox_validation', 10, 3 );

?>