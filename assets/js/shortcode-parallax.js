/**
 * WebMan Parallax scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





jQuery( function() {





	/**
	 * Apply parallax effect
	 */

		if ( jQuery().parallax ) {

			jQuery( '[data-parallax-inertia]' )
				.each( function() {

					var $this               = jQuery( this ),
					    wmParallaxInertia   = ( $this.data( 'parallax-inertia' ) ) ? ( $this.data( 'parallax-inertia' ) ) : ( 0.2 ),
					    wmParallaxXPosition = ( $this.data( 'parallax-xPosition' ) ) ? ( $this.data( 'parallax-xPosition' ) ) : ( '50%' );

					$this
						.parallax( wmParallaxXPosition, wmParallaxInertia, true );

				} );

		} // /parallax





} );
