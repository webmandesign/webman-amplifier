<?php
/**
 * Widget: Sub Navigation
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

		add_action( 'widgets_init', 'wm_subnav_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_subnav_registration() {
		register_widget( 'WM_Subnav' );
	} // /wm_subnav_registration





/**
 * 30) Widget class
 */

	class WM_Subnav extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['name'] = ( defined( 'WM_THEME_NAME' ) ) ? ( WM_THEME_NAME . ' ' ) : ( '' );

				$atts['id']          = 'wm-subnav';
				$atts['name']       .= _x( 'Submenu', 'Widget name.', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-subnav',
						'description' => _x( 'List of subpages', 'Widget description.', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_subnav' . '_atts', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'order'  => 'menu_order',
						'parent' => '',
						'title'  => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays a hierarchical list of subpages and sibling pages for the current page (page submenu).', 'Widget description.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
					<small><?php _e( 'If you leave blank, the main parent page title will be displayed.', 'wm_domain' ) ?></small>
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'parent' ); ?>" name="<?php echo $this->get_field_name( 'parent' ); ?>" type="checkbox" <?php checked( $instance['parent'], 'on' ); ?>/>
					<label for="<?php echo $this->get_field_id( 'parent' ); ?>"><?php _e( 'Direct parent and children only', 'wm_domain' ); ?></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'List order:', 'wm_domain' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>">
						<?php
						$options = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_subnav' . '_form' . '_order', array(
								'post_title' => _x( 'By name', 'List order method.', 'wm_domain' ),
								'post_date'  => _x( 'By date', 'List order method.', 'wm_domain' ),
								'menu_order' => _x( 'Menu order', 'List order method.', 'wm_domain' ),
							) );
						foreach ( $options as $value => $name ) {
							echo '<option value="' . $value . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</p>
				<?php

				do_action( WM_WIDGETS_HOOK_PREFIX . 'wm_subnav' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['order']  = $new_instance['order'];
				$instance['parent'] = $new_instance['parent'];
				$instance['title']  = $new_instance['title'];

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_subnav' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				global $post, $page_exclusions;

				$output = '';

				$instance = wp_parse_args( $instance, array(
						'order'  => 'menu_order',
						'parent' => '',
						'title'  => '',
					) );

				$post    = ( is_home() ) ? ( get_post( get_option( 'page_for_posts' ) ) ) : ( $post );
				$parents = ( isset( $post->ancestors ) ) ? ( $post->ancestors ) : ( '' );

				if ( $instance['parent'] && ! empty( $parents ) ) {
					//Get direct parent
						$grandparent = $parents[0];
				} elseif ( ! $instance['parent'] && ! empty( $parents ) ) {
					//Get the first parent page (at the end of the array)
						$grandparent = end( $parents );
				} else {
					$grandparent = '';
				}

				if ( ! trim( $instance['title'] ) ) {
					$instance['title'] = ( $grandparent ) ? ( '<a href="' . get_permalink( $grandparent ) . '">' . get_the_title( $grandparent ) . '</a>' ) : ( '<a href="' . get_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a>' );
				}

				//Subpages or siblings
					if ( $grandparent ) {
						$children = wp_list_pages( 'sort_column=' . $instance['order'] . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $grandparent . '&echo=0&depth=3' );
					} else {
						$children = wp_list_pages( 'sort_column=' . $instance['order'] . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $post->ID . '&echo=0&depth=3' );
					}

			//Praparing output
				//No need to display on archive pages, single post page and when there area no subpages
					if (
							is_search()
							|| is_404()
							|| is_archive()
							|| is_single()
							|| empty( $children )
						) {
						return;
					}

				//Actual output
					$output .= $args['before_widget'];

					if ( trim( $instance['title'] ) ) {
						$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
					}

					$output .= '<ul class="sub-nav">' . $children . '</ul> <!-- /sub-nav -->';

					$output .= $args['after_widget'];

			//Output
				echo apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_subnav' . '_output', $output, $args, $instance );

		} // /widget

	} // /WM_Subnav

?>