/**
 * WebMan Posts shortcode scripts
 *
 * Posts carousel using Owl Carousel.
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
		 * Setting proper Owl Carousel items spacing
		 */
		function wmOwlCarouselItemPadding( el ) {

			if ( el.hasClass( 'with-margin' ) ) {

				var scrollableColumnMargin = ( el.outerWidth() / 104 * 2 ) + 'px';

				el
					.find( '.owl-item' )
						.css( {
							paddingLeft  : scrollableColumnMargin,
							paddingRight : scrollableColumnMargin
						} );

			}

		} // /wmOwlCarouselItemPadding



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

					} );

		} // /wmOwlRTLSwapItems



		jQuery( '[class*="scrollable-"]' )
			.each( function( item ) {

				var $thisParent             = jQuery( this ),
				    $this                   = $thisParent.find( '.wm-items-container' ),
				    scrollableColumns       = ( $this.data( 'columns' ) ) ? ( $this.data( 'columns' ) ) : ( 3 ),
				    scrollableMobileColumns = Math.min( 2, scrollableColumns ),
				    scrollableTabletColumns = Math.min( 3, scrollableColumns ),
				    scrollableStack         = ( $this.hasClass( 'stack' ) ) ? ( true ) : ( false ),
				    scrollableAuto          = ( $thisParent.hasClass( 'scrollable-auto' ) && $this.data( 'time' ) && 999 < $this.data( 'time' ) ) ? ( $this.data( 'time' ) ) : ( false );

				$this
					.owlCarousel( {
						items             : scrollableColumns,
						autoPlay          : scrollableAuto,
						stopOnHover       : true,
						scrollPerPage     : scrollableStack,
						navigation        : true,
						navigationText    : [ '<', '>' ],
						pagination        : false,
						slideSpeed        : 800,
						autoHeight        : $thisParent.hasClass( 'auto-height' ),
						afterAction       : wmOwlCarouselItemPadding,
						itemsCustom       : [
								[0, 1],
								[420, scrollableMobileColumns],
								[768, scrollableTabletColumns],
								[1020, scrollableColumns]
							],
						/**
						 * RTL script version support
						 */
						itemsDesktopSmall : [1020, scrollableTabletColumns],
						itemsTablet       : [768, scrollableMobileColumns],
						itemsMobile       : [420, 1],
						autoPlayDirection : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( 'rtl' ),
						startPosition     : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( -1 ),
						beforeInit        : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( wmOwlRTLSwapItems )
					} );

			} );





	} // /owlCarousel

} );
