/**
 * WebMan Posts shortcode scripts
 *
 * Posts carousel using Slick slider.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.3.11
 * @version  1.4.8
 */





/**
 * Functionality wrapper
 *
 * @since    1.3.15
 * @version  1.4.8
 *
 * @param  string $selector
 */
function WmampSlick( $selector ) {

	// Requirements check

		if ( ! jQuery().slick ) {
			return;
		}


	// Helper variables

		var $selector = ( 'undefined' !== typeof $selector ) ? ( $selector ) : ( '[class*="scrollable-"]' );


	// Processing

		jQuery( $selector )
			.find( '.wm-items-container .wm-column' )
				.wrap( '<div class="wm-scrollable-item"></div>' )
			.end()
			.each( function( item ) {

				var $parent                  = jQuery( this ),
				    $this                    = $parent.find( '.wm-items-container' ),
				    $scrollableColumns       = ( $this.data( 'columns' ) ) ? ( $this.data( 'columns' ) ) : ( 3 ),
				    $scrollableMobileColumns = Math.min( 2, $scrollableColumns ),
				    $scrollableTabletColumns = Math.min( 3, $scrollableColumns ),
				    $scrollableStack         = ( $this.hasClass( 'stack' ) ) ? ( $scrollableColumns ) : ( 1 ),
				    $scrollableAuto          = ( $parent.hasClass( 'scrollable-auto' ) && $this.data( 'time' ) && 999 < $this.data( 'time' ) ) ? ( $this.data( 'time' ) ) : ( false );

				$this
					.slick( {
						adaptiveHeight : $parent.hasClass( 'auto-height' ),
						autoplay       : Boolean( $scrollableAuto ),
						autoplaySpeed  : $scrollableAuto,
						responsive     : [
								{
									breakpoint: 1280,
									settings: {
										slidesToShow: $scrollableTabletColumns,
										slidesToScroll: $scrollableTabletColumns
									}
								},
								{
									breakpoint: 880,
									settings: {
										slidesToShow: $scrollableMobileColumns,
										slidesToScroll: $scrollableMobileColumns
									}
								},
								{
									breakpoint: 672,
									settings: {
										slidesToShow: 1,
										slidesToScroll: 1
									}
								}
								// You can unslick at a given breakpoint now by adding:
								// settings: "unslick"
								// instead of a settings object
							],
						slidesToShow   : $scrollableColumns,
						slidesToScroll : $scrollableStack,
						speed          : 800,
						rtl            : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( false ) : ( true )
					} );

			} );

} // /WmampSlick



jQuery( function() {

	/**
	 * Only init on front-end if the Beaver Builder isn't active.
	 * If the Beaver Builder is active, it will load the scripts itself.
	 */
	if ( 0 === jQuery( '.fl-builder-edit' ).length ) {
		WmampSlick();
	}

} );
