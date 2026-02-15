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

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
 * Custom HTML
 *
 * @package	    WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */
if ( ! function_exists( 'wma_field_html' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_field_html( $field, $page_template = null ) {

		// Field definition array
		$field = wp_parse_args( (array) $field, array(
			//DEFAULTS:
			//* = Required setting
			'id'        => '',      //Optional, used only for conditional display (inserts table row wrapper automatically)
			'type'      => 'html',  //Field type name *
			'content'   => '',      //Custom HTML content
			'condition' => true,    //Displays only when condition is true
		) );

		// Output
		if ( $field['condition'] ) {

			if ( $field['id'] ) {
				echo
					PHP_EOL . "\t"
					. '<tr
						class="option padding-20 option-' . esc_attr( sanitize_html_class( $field['id'] ) ) . '"
						data-option="' . esc_attr( $field['id'] ) . '"
						>'
					. '<td colspan="2">';
			}

			echo PHP_EOL . wp_kses_post( $field['content'] ) . PHP_EOL;

			if ( $field['id'] ) {

				// Conditional display
				do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
				do_action( 'wmhook_metabox_conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
				do_action( 'wmhook_metabox_conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo PHP_EOL . "\t" . '</td></tr>';
			}
		}

	}
} // /wma_field_html

add_action( 'wmhook_metabox_render_html', 'wma_field_html', 10, 2 );
