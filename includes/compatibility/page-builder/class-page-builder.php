<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Page builder plugins helper class
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Integration
 */
class WM_Amplifier_Page_Builder {





	/**
	 * 0) Init
	 */

		/**
		 * Constructor
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		private function __construct() {}





	/**
	 * 10) Integration
	 */

		/**
		 * Custom page builder input field: `wm_radio`
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  string $name
		 * @param  string $value
		 * @param  array  $field
		 * @param  string $context
		 */
		public static function form_field_radio_custom_render( $name = '', $value = '', $field = array(), $context = '' ) {

			// Pre

				$pre = apply_filters( 'wmhook_amplifier_page_builder_form_field_radio_custom_render_pre', false, $name, $value, $field, $context );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				$field = (array) $field;

				if ( empty( $field ) ) {
					return;
				}


			// Helper variables

				$output = $block_class = '';

				$i = 0;

				if ( ! isset( $field['custom'] ) || ! $field['custom'] ) {
					$field['custom'] = '';
				} else {
					$block_class .= ' custom-label';
				}

				$class = '';
				if (
					isset( $field['hide_radio'] ) && $field['hide_radio']
					&& isset( $field['custom'] ) && $field['custom']
				) {
					$class = ' hide';
				}
				if ( is_callable( 'WM_Amplifier_JS_Composer::is_active' ) && WM_Amplifier_JS_Composer::is_active() ) {
					// Adding field class required in Visual Composer
					$class .= ' wpb_vc_param_value';
				}

				$field['inline'] = ( isset( $field['inline'] ) && $field['inline'] ) ? ( true ) : ( false );

				if ( isset( $field['filter'] ) && $field['filter'] ) {
					$field['filter'] = true;
					$block_class .= ' filterable';
				} else {
					$field['filter'] = false;
				}


			// Processing

				$output = '<div class="fl-wm-radio wm-radio-block' . esc_attr( $block_class ) . '">';

					// Filter

						if ( $field['filter'] ) {
							$output .= '<div class="filter"><input type="text" value="" placeholder="' . esc_attr__( 'Filter: start typing...', 'webman-amplifier' ) . '" class="filter-text" /></div>';
						}

					// Radio buttons

						$output .= '<div class="radio-items">';
							foreach ( $field['options'] as $option_value => $option ) {

								$i++;

								$output .= ( ! $field['inline'] ) ? ( '<p class="input-item radio-item"' ) : ( '<span class="inline-radio input-item radio-item"' );
								$output .= ' data-value="' . esc_attr( $option_value ) . '">';

								$checked = trim( checked( $value, $option_value, false ) . ' /' );

								if (
									! isset( $field['custom'] )
									|| ! $field['custom']
								) {

									$output .= '<input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name . '-' . $i ) . '" value="' . esc_attr( $option_value ) . '" title="' . esc_attr( $option ) . '" class="wm-radio' . esc_attr( $class ) . '" ' . $checked . '> ';

									$output .= '<label for="' . esc_attr( $name . '-' . $i ) . '">' . $option . '</label>';

								} else {

									$output .= '<label for="' . esc_attr( $name . '-' . $i ) . '">' . trim( str_replace(
										array( '{{value}}', '{{name}}' ),
										array( $option_value, $option ),
										$field['custom']
									) ) . '</label>';

									$output .= '<input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name . '-' . $i ) . '" value="' . esc_attr( $option_value ) . '" title="' . esc_attr( $option ) . '" class="wm-radio' . esc_attr( $class ) . '" ' . $checked . '>';

								}

								$output .= ( ! $field['inline'] ) ? ( '</p>' ) : ( '</span> ' );

							} // /foreach
						$output .= '</div>';

					// JavaScript

						$output .= '<script>jQuery( function() {';

							// Add "active" class to radio button items if custom label is used

								$output .= "
									jQuery( '.wm-radio-block.custom-label .radio-item' )
										.find( 'input' )
											.on( 'change', function() {

												// Processing

													jQuery( this )
														.parent( '.inline-radio' )
															.addClass( 'active' )
															.siblings( '.inline-radio' )
																.removeClass( 'active' );

											} )
										.end()
										.find( 'input:checked' )
											.parent( '.inline-radio' )
												.addClass( 'active' );
								";

							// Radio buttons filtering

								if ( $field['filter'] ) {
									$output .= "
										jQuery( '.wm-radio-block.filterable .filter-text' )
											.on( 'keyup', function() {

												// Helper variables

													var
														search = jQuery( this ),
														text   = search.val();


												// Processing

													search
														.closest( '.filterable' )
														.find( '.radio-item' )
															.each( function() {

																// Helper variables

																	var
																		item  = jQuery( this ),
																		value = item.data( 'value' ).replace( 'icon', '' );


																// Processing

																	if ( -1 == value.indexOf( text ) ) {
																		item.hide();
																	} else {
																		item.show();
																	}

															} );

											} );
									";
								}

						$output .= '} );</script>';

				$output .= '</div>';


			// Output

				return (string) apply_filters( 'wmhook_page_builder_form_field_radio_custom_render_output', $output, $context, $name, $value, $field );

		} // /form_field_radio_custom_render





} // /WM_Amplifier_Page_Builder
