/**
 * WebMan Posts shortcode scripts
 *
 * Posts carousel using Slick slider.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.3.11
 */





jQuery( function() {

	if ( jQuery().slick ) {





		jQuery( '[class*="scrollable-"]' )
			.find( '.wm-items-container .wm-column' )
				.wrap( '<div class"wm-scrollable-item"></div>' )
			.end()
			.each( function( item ) {

				var $thisParent             = jQuery( this ),
				    $this                   = $thisParent.find( '.wm-items-container' ),
				    scrollableColumns       = ( $this.data( 'columns' ) ) ? ( $this.data( 'columns' ) ) : ( 3 ),
				    scrollableMobileColumns = Math.min( 2, scrollableColumns ),
				    scrollableTabletColumns = Math.min( 3, scrollableColumns ),
				    scrollableStack         = ( $this.hasClass( 'stack' ) ) ? ( scrollableColumns ) : ( 1 ),
				    scrollableAuto          = ( $thisParent.hasClass( 'scrollable-auto' ) && $this.data( 'time' ) && 999 < $this.data( 'time' ) ) ? ( $this.data( 'time' ) ) : ( false );

				$this
					.slick( {
						adaptiveHeight : $thisParent.hasClass( 'auto-height' ),
						autoplay       : Boolean( scrollableAuto ),
						autoplaySpeed  : scrollableAuto,
						responsive     : [
								{
									breakpoint: 880, // Starting tablet landscape
									settings: {
										slidesToShow: scrollableTabletColumns,
										slidesToScroll: scrollableTabletColumns
									}
								},
								{
									breakpoint: 672, // Starting tablet portrait
									settings: {
										slidesToShow: scrollableMobileColumns,
										slidesToScroll: scrollableMobileColumns
									}
								},
								{
									breakpoint: 448, // Starting mobile landscape
									settings: {
										slidesToShow: 1,
										slidesToScroll: 1
									}
								}
								// You can unslick at a given breakpoint now by adding:
								// settings: "unslick"
								// instead of a settings object
							],
						slidesToShow   : scrollableColumns,
						slidesToScroll : scrollableStack,
						speed          : 800,
						rtl            : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( true )
					} );

			} );





	} // /slick

} );
