<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Section elements
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * SECTIONS
 */

	/**
	 * Section open
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_section_open' ) ) {
		function wma_field_section_open( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type'     => 'section-open',  //Field type name *
						'id'       => 'id',            //Field ID (form field name) *
						'no-table' => false,           //Whether to output a table wrapper
						'title'    => 'Title',         //Field title *
						'page'     => array(
								'templates' => array(),    //Array of page templates
								'operand'   => 'IS'        //Whether to display IS or IS_NOT page templates set above
							)
					) );

			//Section ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . 'section-' . $field['id'];

			//Check whether to display for particular page template
				$classes = $output_script = '';
				if (
						isset( $field['page']['templates'] )
						&& is_array( $field['page']['templates'] )
						&& ! empty( $field['page']['templates'] )
					) {
					//Set default operand
						if ( ! isset( $field['page']['operand'] ) ) {
							$field['page']['operand'] = 'IS';
						}
					//Check if page template is in the array
						$template_check = in_array( $page_template, $field['page']['templates'] );
					//Depending on operand, set the classes
						if ( 'IS_NOT' !== $field['page']['operand'] ) {
							//Only if page template is in the array
								$classes .= ( $template_check ) ? ( '' ) : ( ' hide' );
						} else {
							//Only if the page template is NOT in the array
								$classes .= ( $template_check ) ? ( ' hide' ) : ( '' );
						}
					//Set the script to be outputted
						$output_script = true;
				}

			//Output
				$no_table = ( $field['no-table'] ) ? ( ' no-table' ) : ( '' );
				$classes .= $no_table;
				echo "\r\n" . '<!-- SECTION -->' . "\r\n" . '<div id="' . $field['id'] . '" class="tab-content' . $classes . '">' . "\r\n";

				//Page templates conditional display
					if ( $output_script ) {
						//Helper variables
							$js_array  = '["' . implode( '", "', $field['page']['templates'] ) . '"]';
							$suffix    = ucfirst( str_replace( '-', '', sanitize_html_class( $field['id'] ) ) );
							$condition = 'jQuery.inArray( conditionalValue' . $suffix . ', conditionArray' . $suffix . ' )';

						//Setting condition upon operand
							if ( 'IS_NOT' !== $field['page']['operand'] ) {
								//Only if page template is in the array
									$condition = '-1 !== ' . $condition;
							} else {
								//Only if the page template is NOT in the array
									$condition = '-1 === ' . $condition;
							}
						?>
						<script><!--
							jQuery( function() {
								jQuery( 'select[name="page_template"]' ).on( 'change', function() {
									var conditionalValue<?php echo $suffix; ?> = jQuery( this ).val(),
									    conditionArray<?php echo $suffix; ?>   = <?php echo $js_array; ?>;

									if ( <?php echo $condition; ?> ) {
										jQuery( '#<?php echo $field['id']; ?>, .wm-meta-wrap .tabs .<?php echo $field['id']; ?>' ).removeClass( 'hide' );
									} else {
										jQuery( '#<?php echo $field['id']; ?>, .wm-meta-wrap .tabs .<?php echo $field['id']; ?>' ).addClass( 'hide' );
									}

									var firstTabActive = jQuery( '.wm-meta-wrap .tabs li:not(.hide)' ).first().index();

									if ( jQuery().tabs ) {
										jQuery( '.wm-meta-wrap.jquery-ui-tabs' ).tabs( { active: firstTabActive } );
									}
								} );
							} );
						//--></script>
						<?php
					}

				//Output table wrapper start
					if ( ! $no_table ) {
						echo "\t" . '<table class="form-table"><tbody>' . "\r\n";
					}
		}
	} // /wma_field_section_open

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'section-open', 'wma_field_section_open', 10, 2 );



	/**
	 * Section close
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_section_close' ) ) {
		function wma_field_section_close( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type'     => 'section-close', //Field type name *
						'no-table' => false            //Whether to output a table wrapper
					) );

			//Output
				if ( ! $field['no-table'] ) {
					echo "\r\n\r\n\t</tbody></table>";
				}
				echo "\r\n" . '</div> <!-- /tab-content /SECTION -->' . "\r\n";
		}
	} // /wma_field_section_close

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'section-close', 'wma_field_section_close', 10, 2 );



/**
 * SUBSECTIONS
 */

	/**
	 * Sub-section open
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_sub_section_open' ) ) {
		function wma_field_sub_section_open( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type' => 'sub-section-open',  //Field type name *
						'id'   => 'id',                //Field ID (form field name) *
					) );

			//Sub-section ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . 'sub-section-' . $field['id'];

			//Output
				echo "\r\n\t" . '</tbody>' . "\r\n\t" . '<!-- SUB-SECTION -->' . "\r\n\t" . '<tbody id="' . $field['id'] . '" data-option="' . $field['id'] . '">';
		}
	} // /wma_field_sub_section_open

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'sub-section-open', 'wma_field_sub_section_open', 10, 2 );



	/**
	 * Sub-section close
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_sub_section_close' ) ) {
		function wma_field_sub_section_close( $field, $page_template = null ) {
			//Field definition array
				$field = wp_parse_args( (array) $field, array(
						//DEFAULTS:
						//* = Required setting
						'type'        => 'sub-section-close', //Field type name *
						'id'          => '',                  //Field ID (form field name) *
						'conditional' => '',                  //Conditional display setup
					) );

			//Sub-section ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . 'sub-section-' . $field['id'];

			//Output
				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</tbody> <!-- /SUB-SECTION -->' . "\r\n\t" . '<tbody>';
		}
	} // /wma_field_sub_section_close

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'sub-section-close', 'wma_field_sub_section_close', 10, 2 );

?>