/**
 * WebMan Slideshow shortcode scripts
 *
 * Using Owl Carousel.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.11
 */





jQuery( function() {

	if ( jQuery().owlCarousel ) {





		/**
		 * RTL swap items
		 * @link  http://owlgraphic.com/rtldemo/demos/rtl.html
		 */
		function wmOwlRTLSwapItems( el ) {

			el
				.children()
					.each( function( i, e ) {

						jQuery( e )
							.parent()
								.prepend( jQuery( e ) );

					} )

		} // /wmOwlRTLSwapItems



		jQuery( '.wm-slideshow' )
			.each( function( item ) {

				var $thisParent          = jQuery( this ),
				    $this                = $thisParent.find( '.wm-slideshow-container' ),
				    slideshowSpeed       = ( $thisParent.data( 'speed' ) ) ? ( $thisParent.data( 'speed' ) + 500 ) : ( 3500 ),
				    pagerNavCustom       = ( $this.data( 'pager' ) ) ? ( $this.data( 'pager' ) ) : ( false ),
				    pagerNav             = ( $thisParent.data( 'nav' ) && ! pagerNavCustom ) ? ( true ) : ( false ),
				    transitionSpeed      = 800,
				    wmOwlTransitionStyle = ( typeof wmOwlTransitionStyle !== 'undefined' ) ? ( wmOwlTransitionStyle ) : ( false );

				$this
					.owlCarousel( {
						autoPlay        : slideshowSpeed,
						stopOnHover     : true,
						navigation      : true,
						navigationText  : [ '<', '>' ],
						pagination      : pagerNav,
						slideSpeed      : transitionSpeed,
						paginationSpeed : transitionSpeed,
						rewindSpeed     : transitionSpeed,
						autoHeight      : $thisParent.hasClass( 'auto-height' ),
						singleItem      : true,
						transitionStyle : wmOwlTransitionStyle, // Works only with one item on screen
						afterInit       : function() {

							if ( pagerNavCustom ) {

								/**
								 * From @link  http://jsfiddle.net/BBoyJuss/EGrGN/
								 * @todo Make it work (active states,...)!
								 */
								var customOwlPagination = jQuery( pagerNavCustom + ' > a' ).on( 'click', function( e ) { e.preventDefault(); } );

								jQuery
									.each( this.owl.userItems, function( item ) {

										jQuery( customOwlPagination[item] )
											.on( 'click', function() {

												$this
													.trigger( 'owl.goTo', item );

											} );

									} );

							}

						},
						/**
						 * RTL script version support
						 */
						autoPlayDirection : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( 'rtl' ),
						startPosition     : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( -1 ),
						beforeInit        : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( wmOwlRTLSwapItems )
					} );

			} );






	}	// /owlCarousel

} );
