/**
 * WebMan Posts shortcode scripts
 *
 * Posts carousel using bxSlider.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.11
 */





jQuery( function() {

	if ( jQuery().bxSlider ) {





		// Set browser window width on resize

			var WMbrowserWidth = document.body.clientWidth;

			jQuery( window )
				.on( 'resize orientationchange', function() {
					WMbrowserWidth = document.body.clientWidth;
				} );



		/**
		 * Run the carousel
		 */
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
