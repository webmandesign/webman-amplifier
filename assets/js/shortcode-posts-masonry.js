/**
 * WebMan Posts shortcode scripts
 *
 * Masonry layout.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.11
 */





jQuery( function() {

	if ( jQuery().masonry ) {





		var $WmampMasonryThis = jQuery( '.masonry-this' );

		$WmampMasonryThis
			.imagesLoaded( function() {

				// Processing

					$WmampMasonryThis
						.masonry( {
							percentPosition : true,
							isRTL           : ( 'rtl' == jQuery( 'html' ).attr( 'dir' ) ), // Masonry 2 compatibility (pre WP v3.9)
							isOriginLeft    : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) // Masonry 3+
						} );

			} );





	} // /masonry

} );
