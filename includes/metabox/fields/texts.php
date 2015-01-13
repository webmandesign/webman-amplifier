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
 * @version  1.1
 */



/**
 * TEXT (AND COLOR) FIELDS
 */

	/**
	 * Text input (used also as color and password input)
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 *
	 * @since    1.0
	 * @version  1.1
	 */
	if ( ! function_exists( 'wma_field_text' ) ) {
		function wma_field_text( $field, $page_template = null ) {
			//Field definition array
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

				$value = apply_filters( WM_METABOX_HOOK_PREFIX . 'wma_field_text' . '_sanitize', sanitize_text_field( $value ), $field, $page_template );

				if ( $value || $field['empty'] ) {
					$value = esc_html( $value );
				} else {
					$value = esc_html( $field['default'] );
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
				$output  = "\r\n\t" . '<tr class="option text-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Input field
						$output .= "\r\n\t\t" . '<input type="' . $field['type'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" class="fieldtype-text" ' . trim( $field['attributes'] . ' /' ) . '>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
					//Reset default value button
						if ( trim( $field['default'] ) ) {
							$output .= "\r\n\t\t" . '<a data-option="' . $field['id'] . '" class="button-default-value" title="' . __( 'Use a default value', 'wm_domain' ) . '"><span>' . $field['default'] . '</span></a>';
						}

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_text

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'color',    'wma_field_text', 10, 2 );
	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'password', 'wma_field_text', 10, 2 );
	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'text',     'wma_field_text', 10, 2 );



	/**
	 * Text input validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_text_validation' ) ) {
		function wma_field_text_validation( $new, $field, $post_id ) {
			$new = wp_kses_post( $new );

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

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'color',    'wma_field_text_validation', 10, 3 );
	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'password', 'wma_field_text_validation', 10, 3 );
	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'text',     'wma_field_text_validation', 10, 3 );



	/**
	 * Textarea (used also as visual editor)
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 *
	 * @since    1.0
	 * @version  1.1
	 */
	if ( ! function_exists( 'wma_field_textarea' ) ) {
		function wma_field_textarea( $field, $page_template = null ) {
			//Field definition array
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

				if ( $value || $field['empty'] ) {
					$value = ( ! $field['editor'] ) ? ( esc_textarea( $value ) ) : ( $value );
				} else {
					$value = ( ! $field['editor'] ) ? ( esc_textarea( $field['default'] ) ) : ( $field['default'] );
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
				$output  = "\r\n\t" . '<tr class="option textarea-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Input field
						if ( ! $field['editor'] ) {
							$output .= "\r\n\t\t" . '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" class="fieldtype-textarea" ' . trim( $field['attributes'] ) . '>' . $value . '</textarea>';
						} else {
							echo $output;
							wp_editor( $value, $field['id'] );
							$output = '';
						}
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
					//Reset default value button
						if ( trim( $field['default'] ) && ! $field['editor'] ) {
							$output .= "\r\n\t\t" . '<a data-option="' . $field['id'] . '" class="button-default-value" title="' . __( 'Use a default value', 'wm_domain' ) . '"><span>' . $field['default'] . '</span></a>';
						}

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_textarea

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'textarea', 'wma_field_textarea', 10, 2 );



	/**
	 * Textarea validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_textarea_validation' ) ) {
		function wma_field_textarea_validation( $new, $field, $post_id ) {
			$new = wp_kses_post( $new );

			return $new;
		}
	} // /wma_field_textarea_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'textarea', 'wma_field_textarea_validation', 10, 3 );

?>