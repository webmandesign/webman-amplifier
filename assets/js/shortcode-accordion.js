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
function WmampAccordion( $selector ) {

	// Helper variables

		var $selector   = ( 'undefined' !== typeof $selector ) ? ( $selector ) : ( '.wm-accordion' ),
		    $accordions = jQuery( $selector + '[data-mode="accordion"]' ),
		    $toggles    = jQuery( $selector + '[data-mode="toggle"]' ),
		    $filtered   = jQuery( $selector + '.filterable-simple .wm-filter' );


	// Processing

		/**
		 * Accordions
		 */

			$accordions
				.find( '.wm-item-content' )
					.hide();

			$accordions
				.each( function() {

					var $this  = jQuery( this ),
					    $count = $this.find( '.wm-item' ).length;

					if ( 0 < $this.data( 'active' ) && $count >= $this.data( 'active' ) ) {

						$this
							.find( '.wm-item' )
							.eq( $this.data( 'active' ) - 1 )
								.toggleClass( 'active is-active' );

						$this
							.find( '.wm-item-content' )
							.eq( $this.data( 'active' ) - 1 )
								.show();

					}

				} );

			$accordions
				.on( 'click', '.wm-item-title', function( e ) {

					var $this = jQuery( this );

					$this
						.parent( '.wm-item' )
							.toggleClass( 'active is-active' )
							.siblings()
								.removeClass( 'active is-active' )
								.find( '.wm-item-content' )
									.slideUp();

					$this
						.next( '.wm-item-content' )
							.slideToggle();

				} );



		/**
		 * Toggles
		 */

			$toggles
				.find( '.wm-item-content' )
					.hide();

			$toggles
				.each( function() {

					var $this  = jQuery( this ),
					    $count = $this.find( '.wm-item' ).length;

					if ( 0 < $this.data( 'active' ) && $count >= $this.data( 'active' ) ) {

						$this
							.find( '.wm-item' )
							.eq( $this.data( 'active' ) - 1 )
								.toggleClass( 'active is-active' );

						$this
							.find( '.wm-item-content' )
							.eq( $this.data( 'active' ) - 1 )
								.show();

					}

				} );

			$toggles
				.on( 'click', '.wm-item-title', function( e ) {

					var $this = jQuery( this );

					$this
						.parent( '.wm-item' )
							.toggleClass( 'active is-active' );

					$this
						.next( '.wm-item-content' )
							.slideToggle();

				} );



		/**
		 * Simple filter
		 */

			$filtered
				.on( 'click', 'a', function( e ) {

					e.preventDefault();

					var $this    = jQuery( this ),
					    $wrapper = $this.closest( '.wm-filter' ).next( '.wm-filter-this-simple' );

					if ( ! $this.parent().hasClass( 'is-active' ) ) {

						$this
							.parent()
								.addClass( 'active is-active' )
								.siblings()
									.removeClass( 'active is-active' );

						if ( '*' == $this.data( 'filter' ) ) {

							$wrapper
								.children( '.wm-item' )
									.slideDown();

						} else {

							$wrapper
								.children( '.wm-item' + $this.data( 'filter' ) )
									.slideDown();

							$wrapper
								.children( '.wm-item' )
								.not( $this.data( 'filter' ) )
									.slideUp();

						}
					}

				} );

} // /WmampAccordion



jQuery( function() {

	/**
	 * Only init on front-end if the Beaver Builder isn't active.
	 * If the Beaver Builder is active, it will load the scripts itself.
	 */
	if ( 0 === jQuery( '.fl-builder-edit' ).length ) {
		WmampAccordion();
	}

} );
