<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Select (dropdown) element
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * SELECT (DROPDOWN)
 */

	/**
	 * Select
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 *
	 * @since    1.0
	 * @version  1.1
	 */
	if ( ! function_exists( 'wma_field_select' ) ) {
		function wma_field_select( $field, $page_template = null ) {
			//Field definition array
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

				if ( $value && is_array( $value ) ) {
					$value = (array) $value;
				} elseif ( $value ) {
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
				$output  = "\r\n\t" . '<tr class="option select-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Input field
						$suffix = '';
						if ( false !== strpos( $field['attributes'], 'multiple' ) ) {
							$suffix = '[]';
						}
						$output .= "\r\n\t\t" . '<select name="' . $field['id'] . $suffix . '" id="' . $field['id'] . '" class="fieldtype-select" ' . trim( $field['attributes'] ) . '>';
							if ( is_array( $field['options'] ) && ! empty( $field['options'] ) ) {
								foreach ( $field['options'] as $option_value => $option ) {
									if ( false === strpos( $option_value, 'OPTGROUP' ) ) {
									//classic options
										if ( ! is_array( $value ) ) {
											$selected = selected( $value, $option_value, false );
										} else {
											$selected = ( in_array( $option_value, $value ) ) ? ( ' selected="selected"' ) : ( '' );
										}
										$output .= "\r\n\t\t\t\t" . '<option value="'. $option_value . '"' . $selected . '>' . strip_tags( $option ) . '</option>';
									} elseif ( 'OPTGROUP' === substr( $option_value, 1 ) ) {
									//open option group
										$output .= "\r\n\t\t\t" . '<optgroup label="' . esc_attr( $option ) . '">';
									} elseif ( '/OPTGROUP' === substr( $option_value, 1 ) ) {
									//close option group
										$output .= "\r\n\t\t\t" . '</optgroup>';
									}
								}
							}
						$output .= "\r\n\t\t" . '</select>';
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
	} // /wma_field_select

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'select', 'wma_field_select', 10, 2 );



	/**
	 * Select validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_select_validation' ) ) {
		function wma_field_select_validation( $new, $field, $post_id ) {
			$new = esc_attr( $new );

			return $new;
		}
	} // /wma_field_select_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'select', 'wma_field_select_validation', 10, 3 );

?>