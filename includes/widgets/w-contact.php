<?php
/**
 * Widget: Contact
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.3.10
 *
 * Contents:
 *
 * 10) Registration
 * 20) Widget class
 */





// Exit if accessed directly

	if ( ! defined( 'ABSPATH' ) ) exit;





/**
 * 10) Registration
 */

	/**
	 * Widget registration
	 *
	 * @since    1.0.9.9
	 * @version  1.2.3
	 */
	function wm_contact_info_registration() {

		// Processing

			register_widget( 'WM_Contact_Info' );

	} // /wm_contact_info_registration

	add_action( 'widgets_init', 'wm_contact_info_registration' );





/**
 * 20) Widget class
 */

	class WM_Contact_Info extends WP_Widget {

		/**
		 * Constructor
		 *
		 * @since    1.0.9.9
		 * @version  1.3.10
		 */
		function __construct() {

			// Helper variables

				$theme = ( is_child_theme() ) ? ( wp_get_theme()->parent()->get_template() ) : ( null );

				$atts = array();

				$atts['id']          = 'wm-contact-info';
				$atts['name']        = wp_get_theme( $theme )->get( 'Name' ) . ' ' . esc_html_x( 'Contact', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
						'classname'                   => 'wm-contact-info',
						'description'                 => _x( 'Contact information', 'Widget description.', 'webman-amplifier' ),
						'customize_selective_refresh' => true,
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_' . 'wm_contact_info' . '_atts', $atts );


			// Processing

				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 *
		 * @since    1.0.9.9
		 * @version  1.2.3
		 */
		function form( $instance ) {

			// Helper variables

				$instance = wp_parse_args( $instance, array(
						'address' => '',
						'email'   => '',
						'hours'   => '',
						'name'    => '',
						'phone'   => '',
						'title'   => '',
					) );


			// Output

				?>

				<p class="wm-desc">
					<?php echo esc_html_x( 'Displays specially styled contact information. Anti-spam protection will be applied on the email address.', 'Widget description.', 'webman-amplifier' ) ?>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'webman-amplifier' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php echo esc_html_x( 'Name:', 'In address.', 'webman-amplifier' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php esc_html_e( 'Address:', 'webman-amplifier' ); ?></label><br />
					<textarea cols="50" rows="5" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>"><?php echo esc_textarea( $instance['address'] ); ?></textarea>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'hours' ); ?>"><?php esc_html_e( 'Business hours:', 'webman-amplifier' ); ?></label><br />
					<textarea cols="50" rows="3" id="<?php echo $this->get_field_id( 'hours' ); ?>" name="<?php echo $this->get_field_name( 'hours' ); ?>"><?php echo esc_textarea( $instance['hours'] ); ?></textarea>
					<small><?php _e( 'Use comma to separate days and times<br />(such as "Friday, 9:00 - 17:00")', 'webman-amplifier' ) ?></small>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php esc_html_e( 'Phone number:', 'webman-amplifier' ); ?></label>
					<textarea cols="50" rows="2" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>"><?php echo esc_textarea( $instance['phone'] ); ?></textarea>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php esc_html_e( 'Email address:', 'webman-amplifier' ); ?></label>
					<textarea cols="50" rows="2" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>"><?php echo esc_textarea( $instance['email'] ); ?></textarea>
					<small><?php esc_html_e( 'Anti-spam protection applied automatically', 'webman-amplifier' ); ?></small>
				</p>

				<?php

				do_action( 'wmhook_widgets_' . 'wm_contact_info' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 *
		 * @since    1.0.9.9
		 * @version  1.2.3
		 */
		function update( $new_instance, $old_instance ) {

			// Helper variables

				$instance = $old_instance;


			// Processing

				$instance['address'] = $new_instance['address'];
				$instance['email']   = $new_instance['email'];
				$instance['hours']   = $new_instance['hours'];
				$instance['name']    = $new_instance['name'];
				$instance['phone']   = $new_instance['phone'];
				$instance['title']   = $new_instance['title'];


			// Output

				return apply_filters( 'wmhook_widgets_' . 'wm_contact_info' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 *
		 * @since    1.0.9.9
		 * @version  1.2.3
		 */
		function widget( $args, $instance ) {

			// Helper variables

				$output       = '';
				$address      = array();
				$heading_tag  = intval( preg_replace( '/[^0-9]+/', '', $args['after_title'] ) ) + 1;
				$heading_atts = ' class="screen-reader-text"';

				if (
						2 > $heading_tag
						|| 6 < $heading_tag
					) {
					$heading_tag = 6;
				}

				$heading_tag = 'h' . $heading_tag;

				$instance = wp_parse_args( $instance, array(
						'address' => '',
						'email'   => '',
						'hours'   => '',
						'name'    => '',
						'phone'   => '',
						'title'   => '',
					) );


			// Processing

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base, $args ) . $args['after_title'];
				}

				// Address

					if ( trim( $instance['name'] ) || trim( $instance['address'] ) ) {

						$address[10] = '<div class="address contact-info"' . wma_schema_org( 'itemprop="address"' ) . '>'
						               . '<' . tag_escape( $heading_tag ) . $heading_atts . '>' . esc_html__( 'Address:', 'webman-amplifier' ) . '</' . tag_escape( $heading_tag ) . '>'
						               . '<strong' . wma_schema_org( 'itemprop="name"' ) . '>' . $instance['name'] . '</strong><br />'
						               . str_replace( "\r\n", '<br />', $instance['address'] )
						               . '</div>';

					}

				// Business hours

					if ( trim( $instance['hours'] ) ) {

						$instance['hours'] = trim( $instance['hours'] );

						if ( false === strpos( $instance['hours'], ',' ) ) {
							$instance['hours'] .= '&ndash;,0:00 &ndash; 0:00';
						}

						$instance['hours'] = str_replace( array( "\r\n", "\r", "\n" ), '</td></tr><tr><td>', $instance['hours'] );
						$instance['hours'] = str_replace( array( ',', ', ' ), '</td><td>', $instance['hours'] );
						$instance['hours'] = str_replace( '-', '&ndash;', $instance['hours'] );
						$instance['hours'] = '<table><tr><td>' . $instance['hours'] . '</td></tr></table>';

						$address[20] = '<div class="hours contact-info"' . wma_schema_org( 'itemprop="openingHours"' ) . '>'
						               . '<' . tag_escape( $heading_tag ) . $heading_atts . '>' . esc_html__( 'Business hours:', 'webman-amplifier' ) . '</' . tag_escape( $heading_tag ) . '>'
						               . $instance['hours']
						               . '</div>';

					}

				// Phone numbers

					if ( trim( $instance['phone'] ) ) {

						$address[30] = '<div class="phone contact-info"' . wma_schema_org( 'itemprop="telephone"' ) . '>'
						               . '<' . tag_escape( $heading_tag ) . $heading_atts . '>' . esc_html__( 'Phone number:', 'webman-amplifier' ) . '</' . tag_escape( $heading_tag ) . '>'
						               . $instance['phone']
						               . '</div>';

					}

				// Email addresses

					if ( trim( $instance['email'] ) ) {

						preg_match_all( '/(\S+@\S+\.\S+)/i', $instance['email'], $matches );

						if ( $matches && is_array( $matches ) ) {
							foreach ( $matches[0] as $email ) {
								$instance['email'] = str_replace( $email, '<a href="' . antispambot( 'mailto:' . $email ) . '" data-address="' . antispambot( $email ) . '" class="email-nospam">' . antispambot( $email ) . '</a>', $instance['email'] );
							}
						}

						$address[40] = '<div class="email contact-info"' . wma_schema_org( 'itemprop="email"' ) . '>'
						               . '<' . tag_escape( $heading_tag ) . $heading_atts . '>' . esc_html__( 'Email address:', 'webman-amplifier' ) . '</' . tag_escape( $heading_tag ) . '>'
						               . $instance['email']
						               . '</div>';

					}

				// Filter the $address and prepare it for output

					$address = implode( '', (array) apply_filters( 'wmhook_widgets_' . 'wm_contact_info' . '_address', $address, $args, $instance ) );

				// Output wrapper

					if ( $address ) {

						$output .= '<div class="address-container"' . wma_schema_org( 'itemprop="sourceOrganization" itemscope itemtype="http://schema.org/LocalBusiness"' ) . '>'
						           . apply_filters( 'wmhook_content_filters', $address )
						           . '</div>';

					}


			// Output

				if ( $output ) {
					echo apply_filters( 'wmhook_widgets_' . 'wm_contact_info' . '_output', $args['before_widget'] . $output . $args['after_widget'], $args, $instance );
				}

		} // /widget

	} // /WM_Contact_Info
