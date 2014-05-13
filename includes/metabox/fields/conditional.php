<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Conditional display JavaScript
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * CONDITIONAL DISPLAY JAVASCRIPT
 */

	/**
	 * Conditional display JavaScript
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_conditional_show' ) ) {
		function wma_conditional_show( $field, $option_id = null ) {
			if (
					! trim( $option_id )
					|| ! is_array( $field )
					|| ! isset( $field['conditional'] )
					|| empty( $field['conditional'] )
				) {
				return;
			}

			//Helper variables
				$effect_speed = 250;
				$suffix       = ucfirst( str_replace( '-', '', sanitize_html_class( $option_id ) ) );
				$conditional  = $field['conditional'];
				$conditional  = wp_parse_args( (array) $conditional, array(
						//DEFAULTS:
						'option'       => array(    //Option field setup
								'tag'  => '',           //Option field tag (such as "input" or "select")
								'name' => '',           //Option field name attribute
								'type' => '',           //Option field type attribute (such as "checkbox")
							),
						'option_value' => array(),  //Value(s) to check against (array)
						'operand'      => 'IS',     //Checks the option for the value (IS or IS_NOT)
					) );

				if (
						! is_array( $conditional['option'] )
						|| empty( $conditional['option'] )
						|| ! is_array( $conditional['option_value'] )
						|| empty( $conditional['option_value'] )
					) {
					return;
				}

			//Preparing output
				$conditional['option_value'] = '["' . implode( '", "', $conditional['option_value'] ) . '"]';
				$conditional['operand']      = ( 'IS_NOT' !== $conditional['operand'] ) ? ( '-1 < ' ) : ( '' );
				if ( isset( $conditional['option']['tag'] ) && isset( $conditional['option']['name'] ) ) {
					$conditional_field         = $conditional['option']['tag'] . '[name="' . $conditional['option']['name'] . '"]';
				}

			//Output
				?>
				<script><!--
				jQuery( function() {
					var valuesArray<?php echo $suffix; ?>       = <?php echo $conditional['option_value']; ?>,
					    conditionalOption<?php echo $suffix; ?> = jQuery( '[data-option="<?php echo $option_id; ?>"]' ).hide();
				<?php
				if (
						isset( $conditional['option']['type'] )
						&& in_array( $conditional['option']['type'], array( 'radio', 'checkbox' ) )
					) {

					/*
						Using jQuery .hide() instead of .fadeOut() to hide meta fields to keep the animation
						transition as "smooth" as possible for cases like selecting project types
						and revealing/hiding the additional meta fields.

						The best would be to use .slideToggle() but that doesn't work for HTML table rows.
					*/
					?>

					//Default action
						if ( <?php echo $conditional['operand']; ?>jQuery.inArray( jQuery( '<?php echo $conditional_field; ?>:checked' ).val(), valuesArray<?php echo $suffix; ?> ) ) {
							conditionalOption<?php echo $suffix; ?>.fadeIn( <?php echo $effect_speed; ?> );
						} else {
							conditionalOption<?php echo $suffix; ?>.hide();
						}
					<?php
				}
				?>

					jQuery( '<?php echo $conditional_field; ?>' ).on( 'change', function() {
						var $this            = jQuery( this ),
						    conditionalValue = $this.val();
						<?php
						if (
								isset( $conditional['option']['type'] )
								&& 'checkbox' == $conditional['option']['type']
							) {
							$compare = '$this.is(":checked")';
						} else {
							$compare = $conditional['operand'] . "jQuery.inArray( conditionalValue, valuesArray" . $suffix . " )";
						}
						?>

						if ( <?php echo $compare; ?> ) {
							conditionalOption<?php echo $suffix; ?>.fadeIn( <?php echo $effect_speed; ?> );
						} else {
							conditionalOption<?php echo $suffix; ?>.hide();
						}
					} )<?php
						if (
								isset( $conditional['option']['type'] )
								&& 'radio' !== $conditional['option']['type']
							) {
							echo '.change()';
						}
					?>;
				} );
				//--></script>
				<?php
		}
	} // /wma_conditional_show

	add_action( WM_METABOX_HOOK_PREFIX . 'conditional', 'wma_conditional_show', 10, 2 );

?>