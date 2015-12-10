<?php
/**
 * Widget: Sub Navigation
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.2.8
 */



// Exit if accessed directly

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}





/**
 * 30) Widget class
 */
/**
 * Widget class
 *
 * @since    1.0.9.9
 * @version  1.2.8
 *
 * Contents:
 *
 *  0) Init
 * 10) Output
 * 20) Options
 */
class WM_Subnav extends WP_Widget {





	/**
	 * 0) Init
	 */

		/**
		 * Constructor
		 *
		 * @since    1.0.9.9
		 * @version  1.2.8
		 */
		function __construct() {

			// Helper variables

				$atts = array();

				$atts['id']          = 'wm-subnav';
				$atts['name']        = wp_get_theme()->get( 'Name' ) . ' ' . esc_html_x( 'Submenu', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-subnav',
						'description' => esc_html_x( 'List of subpages', 'Widget description.', 'webman-amplifier' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_atts', $atts );


			// Processing

				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct





	/**
	 * 10) Output
	 */

		/**
		 * Output HTML
		 *
		 * @since    1.0.9.9
		 * @version  1.2.8
		 */
		function widget( $args, $instance ) {

			// Requirements check

				$post_types = get_post_types( array( 'hierarchical' => true ) );

				if (
						! is_singular( $post_types )
						|| apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_disabled', false, $args, $instance )
					) {
					return;
				}


			// Helper variables

				global $post;

				$output = '';

				$instance = wp_parse_args( $instance, array(
						'order'  => 'menu_order',
						'parent' => '',
						'title'  => '',
					) );

				$post    = ( is_home() ) ? ( get_post( get_option( 'page_for_posts' ) ) ) : ( $post );
				$parents = get_ancestors( $post->ID, get_post_type( $post ) );

				// Get the direct parent or the highest level parent

					if ( $instance['parent'] && ! empty( $parents ) ) {
						$grandparent = $parents[0];
					} elseif ( ! $instance['parent'] && ! empty( $parents ) ) {
						$grandparent = end( $parents );
					} else {
						$grandparent = '';
					}

				// Set the parent page title as a widget title when it was left empty

					if ( ! trim( $instance['title'] ) ) {

						if ( $grandparent ) {
							$instance['title'] = '<a href="' . esc_url( get_permalink( $grandparent ) ) . '">&laquo; ' . get_the_title( $grandparent ) . '</a>';
						} else {
							$instance['title'] = '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . get_the_title( $post->ID ) . '</a>';
						}

						$instance['title'] = apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_title_auto', $instance['title'], $args, $instance );

					}


				// Subpages or siblings

					$args_children = array(
							'post_type'   => get_post_type( $post ),
							'title_li'    => '',
							'depth'       => 3,
							'sort_column' => $instance['order'],
							'echo'        => false,
							'child_of'    => $post->ID,
						);

					if ( $grandparent ) {
						$args_children['child_of'] = $grandparent;
					}

					$children = wp_list_pages( (array) apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_wp_list_pages_args', $args_children, $args, $instance ) );

				// If there are no pages, don't display the widget

					if ( empty( $children ) ) {
						return;
					}


			// Processing

				// Before widget

					$output .= $args['before_widget'];

				// Title

					if ( trim( $instance['title'] ) ) {
						$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
					}

					$output .= '<ul class="sub-nav">' . $children . '</ul>';


				// After widget

					$output .= $args['after_widget'];


			// Output

				echo apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_output', $output, $args, $instance );

		} // /widget





	/**
	 * 20) Options
	 */

		/**
		 * Options form
		 *
		 * @since    1.0.9.9
		 * @version  1.2.8
		 */
		function form( $instance ) {

			// Helper variables

				$instance = wp_parse_args( $instance, array(
						'order'  => 'menu_order',
						'parent' => '',
						'title'  => '',
					) );


			// Output

				?>

				<p class="wm-desc">
					<?php echo esc_html_x( 'Displays a hierarchical list of subpages and sibling pages for the current page (page submenu).', 'Widget description.', 'webman-amplifier' ) ?>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>">
						<?php esc_html_e( 'Title:', 'webman-amplifier' ) ?>
					</label>
					<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
					<small>
						<?php esc_html_e( 'If you leave blank, the main parent page title will be displayed.', 'webman-amplifier' ) ?>
					</small>
				</p>

				<p>
					<input type="checkbox" name="<?php echo $this->get_field_name( 'parent' ); ?>" id="<?php echo $this->get_field_id( 'parent' ); ?>" <?php checked( $instance['parent'], 'on' ); ?>/>
					<label for="<?php echo $this->get_field_id( 'parent' ); ?>">
						<?php esc_html_e( 'Direct parent and children only', 'webman-amplifier' ); ?>
					</label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>">
						<?php esc_html_e( 'List order:', 'webman-amplifier' ); ?>
					</label>
					<select name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat">

						<?php

						$options = apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_form' . '_order', array(
								'post_title' => esc_html_x( 'By name', 'List order method.', 'webman-amplifier' ),
								'post_date'  => esc_html_x( 'By date', 'List order method.', 'webman-amplifier' ),
								'menu_order' => esc_html_x( 'Menu order', 'List order method.', 'webman-amplifier' ),
							) );

						foreach ( $options as $value => $name ) {

							echo '<option value="' . esc_attr( $value ) . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . esc_html( $name ) . '</option>';

						} // /foreach

						?>

					</select>
				</p>

				<?php

				do_action( 'wmhook_widgets_' . 'wm_subnav' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 *
		 * @since    1.0.9.9
		 * @version  1.2.8
		 */
		function update( $new_instance, $old_instance ) {

			// Helper variables

				$instance = $old_instance;


			// Processing

				$instance['title']  = $new_instance['title'];
				$instance['order']  = $new_instance['order'];
				$instance['parent'] = $new_instance['parent'];


			// Output

				return apply_filters( 'wmhook_widgets_' . 'wm_subnav' . '_instance', $instance, $new_instance, $old_instance );

		} // /update





} // /WM_Subnav





/**
 * Widget registration
 *
 * @since    1.0.9.9
 * @version  1.2.8
 */
function wm_subnav_registration() {

	// Processing

		register_widget( 'WM_Subnav' );

} // /wm_subnav_registration

add_action( 'widgets_init', 'wm_subnav_registration' );
