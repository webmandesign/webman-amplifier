<?php
/**
 * Widget: Contact
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.1
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Helpers
 * - 30) Widget class
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		add_action( 'widgets_init', 'wm_contact_info_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_contact_info_registration() {
		register_widget( 'WM_Contact_Info' );
	} // /wm_contact_info_registration





/**
 * 30) Widget class
 */

	class WM_Contact_Info extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['name'] = ( defined( 'WM_THEME_NAME' ) ) ? ( WM_THEME_NAME . ' ' ) : ( '' );

				$atts['id']          = 'wm-contact-info';
				$atts['name']       .= _x( 'Contact', 'Widget name.', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-contact-info',
						'description' => _x( 'Contact information', 'Widget description.', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_contact_info' . '_atts', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'address' => '',
						'email'   => '',
						'hours'   => '',
						'name'    => '',
						'phone'   => '',
						'title'   => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays specially styled contact information. JavaScript anti-spam protection will be applied on the email address (also, email will not be displayed when JavaScript is turned off).', 'Widget description.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _ex( 'Name:', 'In address.', 'wm_domain' ) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'wm_domain' ) ?></label><br />
					<textarea cols="50" rows="5" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>"><?php echo esc_textarea( $instance['address'] ); ?></textarea>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'hours' ); ?>"><?php _e( 'Business hours:', 'wm_domain' ) ?></label><br />
					<textarea cols="50" rows="3" id="<?php echo $this->get_field_id( 'hours' ); ?>" name="<?php echo $this->get_field_name( 'hours' ); ?>"><?php echo esc_textarea( $instance['hours'] ); ?></textarea>
					<small><?php _e( 'Use comma to separate days and times<br />(such as "Friday, 9:00 - 17:00")', 'wm_domain' ) ?></small>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone number:', 'wm_domain' ) ?></label>
					<textarea cols="50" rows="2" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>"><?php echo esc_textarea( $instance['phone'] ); ?></textarea>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email address:', 'wm_domain' ) ?></label>
					<textarea cols="50" rows="2" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>"><?php echo esc_textarea( $instance['email'] ); ?></textarea>
					<small><?php _e( 'JavaScript anti-spam protection applied', 'wm_domain' ); ?></small>
				</p>
				<?php

				do_action( WM_WIDGETS_HOOK_PREFIX . 'wm_contact_info' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['address'] = $new_instance['address'];
				$instance['email']   = $new_instance['email'];
				$instance['hours']   = $new_instance['hours'];
				$instance['name']    = $new_instance['name'];
				$instance['phone']   = $new_instance['phone'];
				$instance['title']   = $new_instance['title'];

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_contact_info' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output  = '';
				$address = array();

				$instance = wp_parse_args( $instance, array(
						'address' => '',
						'email'   => '',
						'hours'   => '',
						'name'    => '',
						'phone'   => '',
						'title'   => '',
					) );

			//Preparing output
				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}

				//Address
					if ( trim( $instance['name'] ) || trim( $instance['address'] ) ) {
						$address[10] = '<div class="address contact-info"' . wma_schema_org( 'itemprop="address"' ) . '><strong' . wma_schema_org( 'itemprop="name"' ) . '>' . $instance['name'] . '</strong><br />' . str_replace( "\r\n", '<br />', $instance['address'] ) . '</div>';
					}

				//Business hours
					if ( trim( $instance['hours'] ) ) {
						$instance['hours'] = trim( $instance['hours'] );

						if ( false === strpos( $instance['hours'], ',' ) ) {
							$instance['hours'] .= '&ndash;,0:00 &ndash; 0:00';
						}

						$instance['hours'] = str_replace( array( "\r\n", "\r", "\n" ), '</td></tr><tr><td>', $instance['hours'] );
						$instance['hours'] = str_replace( array( ',', ', ' ), '</td><td>', $instance['hours'] );
						$instance['hours'] = str_replace( '-', '&ndash;', $instance['hours'] );
						$instance['hours'] = '<table><tr><td>' . $instance['hours'] . '</td></tr></table>';

						$address[20] = '<div class="hours contact-info"' . wma_schema_org( 'itemprop="openingHours"' ) . '>' . $instance['hours'] . '</div>';
					}

				//Phone numbers
					if ( trim( $instance['phone'] ) ) {
						$address[30] = '<div class="phone contact-info"' . wma_schema_org( 'itemprop="telephone"' ) . '>' . $instance['phone'] . '</div>';
					}

				//Email addresses
					if ( trim( $instance['email'] ) ) {
						preg_match_all( '/(\S+@\S+\.\S+)/i', $instance['email'], $matches );

						if ( $matches && is_array( $matches ) ) {
							foreach ( $matches[0] as $email ) {
								$email_nospam = ( function_exists( 'wm_nospam' ) ) ? ( wm_nospam( $email ) ) : ( $email );
								$instance['email'] = str_replace( $email, '<a href="#" data-address="' . $email_nospam . '" class="email-nospam">' . $email_nospam . '</a>', $instance['email'] );
							}
						}

						$address[40] = '<div class="email contact-info"' . wma_schema_org( 'itemprop="email"' ) . '>' . $instance['email'] . '</div>';
					}

				//Filter the $address and prepare it for output
					$address = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_contact_info' . '_address', $address, $args, $instance );
					$address = implode( '', $address );

				//Output wrapper
					if ( $address ) {
						$output .= '<div class="address-container"' . wma_schema_org( 'itemprop="sourceOrganization" itemscope itemtype="http://schema.org/LocalBusiness"' ) . '>' . apply_filters( 'wmhook_content_filters', $address ) . '</div>';
					}

			//Output
				if ( $output ) {
					echo apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_contact_info' . '_output', $args['before_widget'] . $output . $args['after_widget'], $args, $instance );
				}

		} // /widget

	} // /WM_Contact_Info

?>