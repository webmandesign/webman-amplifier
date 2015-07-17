/**
 * WebMan Posts shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





jQuery( function() {





	// Set browser window width on resize

		var WMbrowserWidth = document.body.clientWidth;

		jQuery( window )
			.on( 'resize orientationchange', function() {
				WMbrowserWidth = document.body.clientWidth;
			} );



	/**
	 * Filterable posts
	 */

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



	/**
	 * Masonry posts
	 */

		if ( jQuery().masonry ) {

			var $WmampMasonryThis = jQuery( '.masonry-this' );

			$WmampMasonryThis
				.imagesLoaded( function() {

					$WmampMasonryThis
						.masonry( {
							isRTL        : ( 'rtl' == jQuery( 'html' ).attr( 'dir' ) ), // Masonry 2 compatibility (pre WP v3.9)
							isOriginLeft : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) // Masonry 3+
						} );

				} );

		} // /masonry



	/**
	 * Sliding posts
	 */

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

		if ( jQuery().bxSlider ) {

			function wmPostsCarousel() {

				jQuery( '[class*="scrollable-"]' )
					.each( function( item ) {

						var $thisParent          = jQuery( this ),
						    $this                = $thisParent.find( '.wm-items-container' ),
						    itemScrollableWidth  = $this.children().eq( 0 ).outerWidth( true ),
						    itemScrollableMargin = itemScrollableWidth - $this.children().eq( 0 ).outerWidth(),
						    scrollableColumns    = ( $this.data( 'columns' ) ) ? ( $this.data( 'columns' ) ) : ( 3 ),
						    scrollableMove       = ( $this.hasClass( 'stack' ) ) ? ( scrollableColumns ) : ( 1 ),
						    scrollablePause      = ( $this.data( 'time' ) && 999 < $this.data( 'time' ) ) ? ( $this.data( 'time' ) ) : ( 4000 );

						if ( 680 > WMbrowserWidth ) {

							itemScrollableWidth  = $thisParent.outerWidth();
							itemScrollableMargin = 0;
							scrollableColumns    = scrollableMove = 1;

							if ( $this.closest( '.wm-posts-wrap' ).hasClass( 'wm-posts-wm_logos' ) ) {
								itemScrollableWidth = itemScrollableWidth / 3;
								scrollableColumns   = scrollableMove = 3;
							}

						} else {

							itemScrollableWidth = itemScrollableWidth - itemScrollableMargin;

						}

						$this
							.bxSlider( {
								auto           : $this.closest( '.wm-posts-wrap' ).hasClass( 'scrollable-auto' ),
								pause          : scrollablePause,
								minSlides      : 1,
								maxSlides      : scrollableColumns,
								slideWidth     : parseInt( itemScrollableWidth ),
								slideMargin    : parseInt( itemScrollableMargin ),
								moveSlides     : scrollableMove,
								pager          : false,
								autoHover      : true,
								adaptiveHeight : $thisParent.hasClass( 'auto-height' ),
								useCSS         : false // This prevents CSS3 animation glitches in Chrome, but unfortunatelly adding a bit of overhead
							} );

					} );

			} // /wmPostsCarousel

			wmPostsCarousel();

			jQuery( window )
				.on( 'resize orientationchange', function() {

					wmPostsCarousel();

				} );

		} // /bxSlider





} );
