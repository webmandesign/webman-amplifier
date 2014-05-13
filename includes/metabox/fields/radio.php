<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Radio button elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * RADIO BUTTONS FIELDS
 */

	/**
	 * Radio buttons
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_radio' ) ) {
		function wma_field_radio( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type'        => 'radio',  //Field type name *
						'id'          => 'id',     //Field ID (form field name) *
						'label'       => '',       //Field label
						'description' => '',       //Field description
						'class'       => '',       //Additional CSS class
						'options'     => array(),  //Radio options (array( key => value ))
						'default'     => '',       //Default value
						'inline'      => false,    //By default the radio buttons are displayed as list. You can align them in a row here.
						'repeater'    => false,    //Special values when used in Repeater field
						'custom'      => '',       //Custom label HTML (use "{{value}}"" to substitute for current item value and "{{name}}"" to display the item name)
						'hide-radio'  => false,    //If set to true, the ".hide" CSS class will be applied on radio input field (useful with custom label HTML)
						'conditional' => '',       //Conditional display setup
					) );

			//Alter class when custom label HTML used
				if ( trim( $field['custom'] ) ) {
					$field['class'] = 'custom-label ' . $field['class'];
				}
				if ( $field['hide-radio'] ) {
					$field['hide-radio'] = ' hide';
				}

			//Value processing
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
				$output  = "\r\n\t" . '<tr class="option radio-wrap option-' . trim( $field['id'] . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Radio group label
						$output .= "\r\n\t\t" . '<strong class="label">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</strong>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
				$output .= "\r\n\t" . '</th><td>';
					//Input field
					if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
						$i = 0;
						foreach ( $field['options'] as $option_value => $option ) {
							$i++;
							$output .= "\r\n\t\t";
							$output .= ( ! $field['inline'] ) ? ( '<p>' ) : ( '<span class="inline-radio">' );
								$checked = trim( checked( $value, $option_value, false ) . ' /' );
								$option  = trim( strip_tags( $option, WM_METABOX_LABEL_HTML ) );
								if ( ! trim( $field['custom'] ) ) {
									$output .= '<input type="' . $field['type'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '-' . $i . '" value="' . $option_value . '" title="' . esc_attr( $option ) . '" class="fieldtype-radio" ' . $checked . '> ';
									$output .= '<label for="' . $field['id'] . '-' . $i . '">' . $option . '</label>';
								} else {
									$output .= '<label for="' . $field['id'] . '-' . $i . '">' . trim( str_replace( array( '{{value}}', '{{name}}' ), array( $option_value, $option ), $field['custom'] ) ) . '</label>';
									$output .= '<input type="' . $field['type'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '-' . $i . '" value="' . $option_value . '" title="' . esc_attr( $option ) . '" class="fieldtype-radio' . $field['hide-radio'] . '" ' . $checked . '>';
								}
							$output .= ( ! $field['inline'] ) ? ( '</p>' ) : ( '</span> ' );
						}
					}
					//Reset default value button
						if ( trim( $field['default'] ) ) {
							$output .= "\r\n\t\t" . '<a data-option="' . $field['id'] . '" class="button-default-value" title="' . __( 'Use default value', 'wm_domain' ) . '"><span>' . $field['default'] . '</span></a>';
						}

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_radio

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'radio', 'wma_field_radio', 10, 2 );



	/**
	 * Radio buttons validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_radio_validation' ) ) {
		function wma_field_radio_validation( $new, $field, $post_id ) {
			$new = esc_attr( $new );

			return $new;
		}
	} // /wma_field_radio_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'radio', 'wma_field_radio_validation', 10, 3 );

?>