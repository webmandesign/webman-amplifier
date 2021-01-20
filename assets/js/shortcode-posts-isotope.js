/**
 * WebMan Posts shortcode scripts
 *
 * Filterable posts using Isotope.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.5.9
 */





/**
 * Functionality wrapper
 *
 * @since    1.3.15
 * @version  1.5.9
 *
 * @param  string $selector
 */
function WmampIsotope( $selector ) {

	// Requirements check

		if ( ! jQuery().isotope ) {
			return;
		}


	// Helper variables

		var $selector = ( 'undefined' !== typeof $selector ) ? ( $selector ) : ( '.filter-this' ),
		    $isotoped = jQuery( $selector );


	// Processing

		// Run Isotope

			$isotoped
				.each( function( e ) {

					var $this = jQuery( this );

					$this
						.isotope( {
							layoutMode        : $this.data( 'layoutMode' ),
							isOriginLeft      : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ),
							transformsEnabled : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
						} );

				} );

		// Filter items when filter link is clicked

			$isotoped
				.prev( '.wm-filter' )
					.on( 'click', 'a', function( e ) {

						e.preventDefault();

						var $this   = jQuery( this ),
						    $filter = $this.data( 'filter' );

						$this
							.closest( '.wm-posts-wrap' )
								.find( '.filter-this' )
									.isotope( {
										filter            : $filter,
										isOriginLeft      : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ),
										transformsEnabled : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
									} );

						$this
							.parent( 'li' )
								.addClass( 'active' )
								.siblings( 'li' )
									.removeClass( 'active' );

					} );


		// Re-layout after images have been loaded

			$isotoped
				.imagesLoaded()
				.progress( function() {

					// Processing

						$isotoped
							.isotope( 'layout' );

				} );

} // /WmampIsotope



jQuery( function() {

	/**
	 * Only init on front-end if the Beaver Builder isn't active.
	 * If the Beaver Builder is active, it will load the scripts itself.
	 */
	if ( 0 === jQuery( '.fl-builder-edit' ).length ) {
		WmampIsotope();
	}

} );
