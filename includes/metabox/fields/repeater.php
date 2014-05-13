<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Dynamically added elements (repeater)
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * DYNAMICALLY ADDED ELEMENTS (REPEATER)
 */

	/**
	 * Dynamically added elements (repeater)
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_repeater' ) ) {
		function wma_field_repeater( $field, $page_template = null ) {
			//Field definition array
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

			//Value processing
				$values = (array) wma_meta_option( $field['id'] );
				$values = array_filter( $values );

				if ( ! is_array( $values ) || empty( $values ) ) {
					$values = $field['default'];
				}

			//Field ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			//Output
				$output  = "\r\n\t" . '<tr class="option repeater-wrap option-' . trim( $field['id'] . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
						$output .= "\r\n\t\t" . '<div class="repeater-cells">';
						echo $output;

					//Repeater cells
						if ( is_array( $values ) && ! empty( $values ) ) {
							$i = 0;
							foreach ( $values as $value ) {
								if ( is_array( $field['fields'] ) && ! empty( $field['fields'] ) ) {
									$output = "\r\n\t\t" . '<table class="repeater-cell">';

										//Controls row
											$output .= "\r\n\t\t\t" . '<thead class="repeater-cell-controls"><tr><th colspan="2">';
											$output .= "\r\n\t\t\t\t" . '<a class="button button-move-cell" data-id="' . $field['id'] . '" title="' . __( 'Move the item', 'wm_domain' ) . '">&equiv;</a>';
											$output .= "\r\n\t\t\t\t" . '<a class="button button-remove-cell" data-id="' . $field['id'] . '" title="' . __( 'Remove this item', 'wm_domain' ) . '">-</a>';
											$output .= "\r\n\t\t\t" . '</th></tr></thead>';

											$output .= "\r\n\t\t\t" . '<tbody>';
											echo $output;

										//Fields row
											foreach ( $field['fields'] as $cell_field ) {
												if (
														isset( $cell_field['type'] )
														&& in_array( $cell_field['type'], array( 'checkbox', 'color', 'radio', 'text', 'textarea', 'select' ) ) //allow only certain field types in repeater
													) {
													//Passing special repeater values into field generator/renderer
														$cell_value = ( isset( $value[ $cell_field['id'] ] ) ) ? ( $value[ $cell_field['id'] ] ) : ( null );
														$cell_field['repeater'] = array(
																'id'    => $field['id'] . '[' . $i . ']' . '[' . $cell_field['id'] . ']',
																'value' => $cell_value,
															);
													//Display form fields using action hook (echo the function return)
														do_action( WM_METABOX_HOOK_PREFIX . 'render_' . $cell_field['type'], $cell_field, '' );
												}
											}

									echo "\r\n\t\t" . '<!-- /repeater-cell --></tbody></table>';
								}
								$i++;
							}
						}

					//Add repeater cell button
						echo "\r\n\t\t" . '</div> <!-- /repeater-cells -->';
						echo "\r\n\t\t" . '<a href="#" class="button button-add-cell" data-id="' . $field['id'] . '">' . $field['button-text'] . '</a>';

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_repeater

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'repeater', 'wma_field_repeater', 10, 2 );

?>