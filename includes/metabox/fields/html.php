<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Custom HTML element
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * CSS classes
 *
 * With custom HTML element you can use several CSS classes on elements.
 * Here is the list of pre-styled classes you can use:
 *
 * tr.option
 * 		Applies the styles of meta option wrapper (paddings, borders, hover hightlight,...).
 *
 * tr.padding-20
 * 		Applies 20px padding on direct TD children of the TR.
 *
 * tr.option-heading
 * 		Special heading wrapper. Use H3 or H2 inside the child TH.
 *
 * tr.option-heading.toggle
 * 		Toggles subsequent sub-section (hidden by default) upon clicking the heading.
 *
 * tr.option-heading.toggle.open
 * 		The same as above, but makes the sub-section visible by default.
 *
 * div.box
 * 		Specially styled info box.
 *
 * div.box.blue, div.box.green, div.box.red, div.box.yellow
 * 		Additional color subclasses to style the box.
 */



/**
 * HTML
 */

	/**
	 * Custom HTML
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_html' ) ) {
		function wma_field_html( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'id'        => '',      //Optional, used only for conditional display (inserts table row wrapper automatically)
						'type'      => 'html',  //Field type name *
						'content'   => '',      //Custom HTML content
						'condition' => true,    //Displays only when condition is true
					) );

			//Output
				if ( $field['condition'] ) {
					if ( $field['id'] ) {
						echo "\r\n\t" . '<tr class="option padding-20 option-' . sanitize_html_class( $field['id'] ) . '" data-option="' . $field['id'] . '"><td colspan="2">';
					}

					echo "\r\n" . $field['content'] . "\r\n";

					if ( $field['id'] ) {
						//Conditional display
							do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
							do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
							do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

						echo "\r\n\t" . '</td></tr>';
					}
				}
		}
	} // /wma_field_html

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'html', 'wma_field_html', 10, 2 );

?>