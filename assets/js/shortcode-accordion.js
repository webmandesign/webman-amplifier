/**
 * WebMan Accordion shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





jQuery( function() {





	/**
	 * Accordions
	 */

		var $WmampAccordions = jQuery( 'div[data-mode="accordion"]' );

		$WmampAccordions
			.find( '.wm-item-content' )
				.hide();

		$WmampAccordions
			.each( function() {

				var $this         = jQuery( this ),
				    countingItems = $this.find( '.wm-item' ).length;

				if ( 0 < $this.data( 'active' ) && countingItems >= $this.data( 'active' ) ) {

					$this
						.find( '.wm-item' )
						.eq( $this.data( 'active' ) - 1 )
							.toggleClass( 'active' );

					$this
						.find( '.wm-item-content' )
						.eq( $this.data( 'active' ) - 1 )
							.show();

				}

			} );

		$WmampAccordions
			.on( 'click', '.wm-item-title', function( e ) {

				var $this = jQuery( this );

				$this
					.parent( '.wm-item' )
						.toggleClass( 'active' )
						.siblings()
							.removeClass( 'active' )
							.find( '.wm-item-content' )
								.slideUp();

				$this
					.next( '.wm-item-content' )
						.slideToggle();

			} );



	/**
	 * Toggles
	 */

		var $WmampToggles = jQuery( 'div[data-mode="toggle"]' );

		$WmampToggles
			.find( '.wm-item-content' )
				.hide();

		$WmampToggles
			.each( function() {

				var $this         = jQuery( this ),
				    countingItems = $this.find( '.wm-item' ).length;

				if ( 0 < $this.data( 'active' ) && countingItems >= $this.data( 'active' ) ) {

					$this
						.find( '.wm-item' )
						.eq( $this.data( 'active' ) - 1 )
							.toggleClass( 'active' );

					$this
						.find( '.wm-item-content' )
						.eq( $this.data( 'active' ) - 1 )
							.show();

				}

			} );

		$WmampToggles
			.on( 'click', '.wm-item-title', function( e ) {

				var $this = jQuery( this );

				$this
					.parent( '.wm-item' )
						.toggleClass( 'active' );

				$this
					.next( '.wm-item-content' )
						.slideToggle();

			} );



	/**
	 * Simple filter
	 */

		var $WmampSimpleFilterWrap = jQuery( '.filterable-simple' ),
		    $WmampSimpleFilter     = jQuery( '.filterable-simple .wm-filter' );

		$WmampSimpleFilter
			.on( 'click', 'a', function( e ) {

				e.preventDefault();

				var $this         = jQuery( this ),
				    $imtesWrapper = $this.closest( '.wm-filter' ).next( '.wm-filter-this-simple' );

				if ( ! $this.parent().hasClass( 'active' ) ) {

					$this
						.parent()
							.addClass( 'active' )
							.siblings()
								.removeClass( 'active' );

					if ( '*' == $this.data( 'filter' ) ) {

						$imtesWrapper
							.children( '.wm-item' )
								.slideDown();

					} else {

						$imtesWrapper
							.children( '.wm-item' + $this.data( 'filter' ) )
								.slideDown();

						$imtesWrapper
							.children( '.wm-item' )
							.not( $this.data( 'filter' ) )
								.slideUp();

					}
				}

			} );





} );
