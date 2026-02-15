/**
 * WebMan Shortcode custom form field: wm_radio
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since  1.6.0
 */

( function( jQuery ) {
	'use strict';

	function wmaCustomFieldRadio() {

		jQuery( '.wm-radio-block.custom-label .radio-item' )
			.find( 'input' )
				.on( 'change', function() {

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

		jQuery( '.wm-radio-block.filterable .filter-text' )
			.on( 'keyup', function() {

				var
					search = jQuery( this ),
					text   = search.val();

				search
					.closest( '.filterable' )
					.find( '.radio-item' )
						.each( function() {

							var
								item  = jQuery( this ),
								value = item.data( 'value' ).replace( 'icon', '' );

							if ( -1 == value.indexOf( text ) ) {
								item.hide();
							} else {
								item.show();
							}

						} );

			} );
	}

	wmaCustomFieldRadio();

	if ( 'undefined' !== typeof FLBuilder ) {
		FLBuilder.addHook( 'didCompleteAJAX', wmaCustomFieldRadio );
	}

} )( jQuery );
