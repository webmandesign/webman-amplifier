/**
 * WebMan Visual Composer plugin additional shortcode attributes helper scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */



( function( $ ) {



	/**
	 * Radio buttons
	 */

		//Add "active" class for radio button items if custom label is used
			$( '.wpb_edit_form_elements .wm-radio-block.custom-label input:checked' ).parent( '.input-item' ).addClass( 'active' );
			$( '.wpb_edit_form_elements .wm-radio-block.custom-label input' ).on( 'change', function() {
				$( this ).parent( '.input-item' ).addClass( 'active' ).siblings( '.input-item' ).removeClass( 'active' );
			} );



} )( window.jQuery );



/* END OF FILE */