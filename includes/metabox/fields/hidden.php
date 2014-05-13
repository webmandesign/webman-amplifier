<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Hidden elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * HIDDEN FIELDS
 */

	/**
	 * Hidden input
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_hidden' ) ) {
		function wma_field_hidden( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type'  => 'hidden',  //Field type name *
						'id'    => 'id',      //Field ID (form field name) *
						'value' => '',        //Default value
					) );

			//Value processing
				$value = esc_attr( $field['value'] );

			//Field ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			//Output
				$output  = "\r\n\t" . '<tr class="option hidden-wrap option-' . $field['id'] . '" data-option="' . $field['id'] . '"><td colspan="2">';
					//Input field
						$output .= "\r\n\t\t" . '<input type="' . $field['type'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" />';
				$output .= "\r\n\t" . '</td></tr>';

				echo $output;
		}
	} // /wma_field_hidden

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'hidden', 'wma_field_hidden', 10, 2 );



	/**
	 * Hidden input validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_hidden_validation' ) ) {
		function wma_field_hidden_validation( $new, $field, $post_id ) {
			$new = esc_attr( $new );

			return $new;
		}
	} // /wma_field_hidden_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'hidden', 'wma_field_hidden_validation', 10, 3 );

?>