/**
 * WebMan Accordion shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
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
function WmampTabs( $selector ) {

	// Helper variables

		var $selector = ( 'undefined' !== typeof $selector ) ? ( $selector ) : ( '.wm-tabs' ),
		    $tabs     = jQuery( $selector ),
		    $tour     = jQuery( $selector + '.tour-tabs' );


	// Processing

		/**
		 * Tabs
		 */

			$tabs
				.find( '.wm-item' )
					.hide();

			$tabs
				.each( function() {

					var $this   = jQuery( this ),
					    $active = ( 0 < $this.data( 'active' ) ) ? ( $this.data( 'active' ) ) : ( 1 );

					$this
						.find( '.wm-item' )
						.eq( $active - 1 )
							.toggleClass( 'active' )
							.show();

					$this
						.find( '.wm-tab-links li' )
						.eq( $active - 1 )
							.addClass( 'active' );

				} );

			$tabs
				.on( 'click', '.wm-tab-links a', function( e ) {

					e.preventDefault();

					var $this = jQuery( this );

					$this
						.parent()
							.addClass( 'active' )
							.siblings()
								.removeClass( 'active' );

					jQuery( $this.data( 'tab' ) )
						.show()
						.addClass( 'active' )
						.siblings( '.wm-item' )
							.removeClass( 'active' )
							.hide();

				} );



		/**
		 * Vertical tabs
		 */

			// Fixing min height for vertical tab items

				jQuery( '.wm-tabs.layout-left, .wm-tabs.layout-right' )
					.each( function( index, val ) {

						var $this      = jQuery( this ),
						    $minHeight = $this.find( '.wm-tab-links' ).outerHeight();

						$this
							.find( '.wm-tabs-items .wm-item' )
								.css( 'min-height', $minHeight + 'px' );

					} );



		/**
		 * Tour tabs
		 */

			// Add tour navigation

				jQuery( '<div class="wm-tour-nav top"><span class="prev"></span><span class="next"></span></div>' )
					.prependTo( '.wm-tabs.tour-tabs .wm-tabs-items' );

				jQuery( '<div class="wm-tour-nav bottom"><span class="prev"></span><span class="next"></span></div>' )
					.appendTo( '.wm-tabs.tour-tabs .wm-tabs-items' );

				$tour
					.each( function() {

						var $this     = jQuery( this ),
						    $previous = $this.find( '.wm-tab-links li.active' ).prev( 'li' ).html(),
						    $next     = $this.find( '.wm-tab-links li.active' ).next( 'li' ).html();

						if ( 'undefined' != typeof $previous && $previous.length ) {
							$this
								.find( '.wm-tour-nav .prev' )
									.html( $previous );
						}

						if ( 'undefined' != typeof $next && $next.length ) {
							$this
								.find( '.wm-tour-nav .next' )
									.html( $next );
						}

					} );

			// Change when tab clicked

				$tour
					.on( 'click', '.wm-tab-links a', function() {

						var $this     = jQuery( this ),
						    $wrapper  = $this.closest( '.wm-tabs' ),
						    $previous = $this.parent().prev( 'li' ),
						    $next     = $this.parent().next( 'li' );

						if ( $previous.length ) {
							$wrapper
								.find( '.wm-tour-nav .prev' )
									.html( $previous.html() );
						} else {
							$wrapper
								.find( '.wm-tour-nav .prev' )
									.html( '' );
						}

						if ( $next.length ) {
							$wrapper
								.find( '.wm-tour-nav .next' )
									.html( $next.html() );
						} else {
							$wrapper
								.find( '.wm-tour-nav .next' )
									.html( '' );
						}

					} );

			// Change when tour nav clicked

				jQuery( '.wm-tour-nav' )
					.on( 'click', 'a', function( e ) {

						e.preventDefault();

						var $this     = jQuery( this ),
						    $wrapper  = $this.closest( '.wm-tabs' ),
						    targetID  = $this.data( 'tab' ),
						    $previous = $wrapper.find( '.wm-tab-items-' + targetID.substring( 1 ) ).prev( 'li' ),
						    $next     = $wrapper.find( '.wm-tab-items-' + targetID.substring( 1 ) ).next( 'li' );

						jQuery( '.wm-tab-items-' + targetID.substring( 1 ) )
							.addClass( 'active' )
							.siblings( 'li' )
								.removeClass( 'active' );

						jQuery( targetID )
							.show()
							.addClass( 'active' )
							.siblings( '.wm-item' )
								.removeClass( 'active' )
								.hide();

						if ( $previous.length ) {
							$wrapper
								.find( '.wm-tour-nav .prev' )
									.html( $previous.html() );
						} else {
							$wrapper
								.find( '.wm-tour-nav .prev' )
									.html( '' );
						}

						if ( $next.length ) {
							$wrapper
								.find( '.wm-tour-nav .next' )
									.html( $next.html() );
						} else {
							$wrapper
								.find( '.wm-tour-nav .next' )
									.html( '' );
						}

					} );

} // /WmampTabs



jQuery( function() {

	/**
	 * Only init on front-end if the Beaver Builder isn't active.
	 * If the Beaver Builder is active, it will load the scripts itself.
	 */
	if ( 0 === jQuery( '.fl-builder-edit' ).length ) {
		WmampTabs();
	}

} );
