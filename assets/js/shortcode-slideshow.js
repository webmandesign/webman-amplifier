/**
 * WebMan Slideshow shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





jQuery( function() {





	/**
	 * Slideshow
	 */

		// OwlCarousel

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



		// bxSlider

			if ( jQuery().bxSlider ) {

				jQuery( '.wm-slideshow' )
					.each( function( item ) {

						var $thisParent    = jQuery( this ),
						    $this          = $thisParent.find( '.wm-slideshow-container' ),
						    slideshowSpeed = ( $thisParent.data( 'speed' ) ) ? ( $thisParent.data( 'speed' ) + 500 ) : ( 3500 ),
						    pagerNav       = ( $thisParent.data( 'nav' ) ) ? ( true ) : ( false ),
						    pagerNavCustom = ( $this.data( 'pager' ) ) ? ( $this.data( 'pager' ) ) : ( null );

						$this
							.bxSlider( {
								mode           : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( 'horizontal' ) : ( 'fade' ),
								pause          : slideshowSpeed,
								auto           : true,
								autoHover      : true,
								controls       : true,
								pager          : pagerNav,
								pagerCustom    : pagerNavCustom,
								adaptiveHeight : $thisParent.hasClass( 'auto-height' ),
								useCSS         : false // This prevents CSS3 animation glitches in Chrome, but unfortunatelly adding a bit of overhead
							} );

					} );

			} // /bxSlider





} );
