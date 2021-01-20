/**
 * WebMan Parallax scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.5.9
 */





jQuery( function() {





	/**
	 * Apply parallax effect
	 */

		if ( jQuery().parallax ) {

			jQuery( '[data-parallax-inertia]' )
				.each( function() {

					var $this               = jQuery( this ),
					    wmParallaxInertia   = ( $this.data( 'parallaxInertia' ) ) ? ( $this.data( 'parallaxInertia' ) ) : ( 0.2 ),
					    wmParallaxXPosition = ( $this.data( 'parallaxXPosition' ) ) ? ( $this.data( 'parallaxXPosition' ) ) : ( '50%' );

					$this
						.parallax( wmParallaxXPosition, wmParallaxInertia, true );

				} );

		} // /parallax





} );
