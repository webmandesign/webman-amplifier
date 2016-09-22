/**
 * WebMan Posts shortcode scripts
 *
 * Masonry layout.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.19
 */





/**
 * Functionality wrapper
 *
 * @since    1.3.15
 * @version  1.3.19
 *
 * @param  string $selector
 */
function WmampMasonry( $selector ) {

	// Requirements check

		if ( ! jQuery().masonry ) {
			return;
		}


	// Helper variables

		var $selector  = ( 'undefined' !== typeof $selector ) ? ( $selector ) : ( '.masonry-this' ),
		    $masonried = jQuery( $selector );


	// Processing

		// Run Masonry

			$masonried
				.imagesLoaded( function() {

					// Processing

						$masonried
							.masonry( {
								percentPosition : true,
								isOriginLeft    : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
							} );

				} );

} // /WmampMasonry



jQuery( function() {

	/**
	 * Only init on front-end if the Beaver Builder isn't active.
	 * If the Beaver Builder is active, it will load the scripts itself.
	 */
	if ( 0 === jQuery( '.fl-builder-edit' ).length ) {
		WmampMasonry();
	}

} );
