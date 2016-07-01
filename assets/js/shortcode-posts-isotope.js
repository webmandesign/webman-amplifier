/**
 * WebMan Posts shortcode scripts
 *
 * Filterable posts using Isotope.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.11
 */





jQuery( function() {

	if ( jQuery().isotope ) {





		var $WmampFilteredContent = jQuery( '.filter-this' );

		/**
		 * Function to run Isotope on each filerable items list
		 */
		function runIsotope() {

			$WmampFilteredContent
				.each( function( e ) {

					var $this = jQuery( this );

					$this
						.isotope( {
							layoutMode        : $this.data( 'layout-mode' ),
							isOriginLeft      : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ),
							transformsEnabled : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
						} );

				} );

		} // /runIsotope

		/**
		 * Filter items when filter link is clicked
		 */
		$WmampFilteredContent
			.prev( '.wm-filter' )
				.on( 'click', 'a', function( e ) {

					e.preventDefault();

					var $this    = jQuery( this ),
					    selector = $this.data( 'filter' );

					$this
						.closest( '.wm-posts-wrap' )
							.find( '.filter-this' )
								.isotope( {
									filter            : selector,
									isOriginLeft      : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ),
									transformsEnabled : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
								} );

					$this
						.parent( 'li' )
							.addClass( 'active' )
							.siblings( 'li' )
								.removeClass( 'active' );

				} );


		// Apply Isotope after the images have been loaded

			$WmampFilteredContent
				.imagesLoaded( function() {

					runIsotope();

				} );





	} // /isotope

} );
