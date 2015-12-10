<?php
/**
 * Widget: Posts
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.2
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

		add_action( 'widgets_init', 'wm_posts_widget_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_posts_widget_registration() {
		register_widget( 'WM_Posts_Widget' );
	} // /wm_posts_widget_registration





/**
 * 30) Widget class
 */

	class WM_Posts_Widget extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['id']          = 'wm-posts-widget';
				$atts['name']        = wp_get_theme()->get( 'Name' ) . ' ' . esc_html_x( 'Posts', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-posts-widget',
						'description' => _x( 'Lists posts or projects', 'Widget description.', 'webman-amplifier' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_atts', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'class'     => '',
						'count'     => 4,
						'order'     => 'new',
						'post_type' => 'post',
						'taxonomy'  => '',
						'title'     => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays list of Posts or Projects.', 'Widget description.', 'webman-amplifier' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'webman-amplifier' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', 'webman-amplifier' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'post_type' ); ?>" id="<?php echo $this->get_field_id( 'post_type' ); ?>">
						<?php
						$options = apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_form' . '_post_type', array( 'post' => __( 'Posts', 'webman-amplifier' ) ) );

						foreach ( $options as $value => $name ) {
							echo '<option value="' . $value . '" ' . selected( esc_attr( $instance['post_type'] ), $value, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Posts count:', 'webman-amplifier' ) ?></label><br />
					<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo absint( $instance['count'] ); ?>" size="5" maxlength="2" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Ordering:', 'webman-amplifier' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>">
						<?php
						$options = apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_form' . '_order', array(
								'new'    => _x( 'Newest first', 'List order method.', 'webman-amplifier' ),
								'old'    => _x( 'Oldest first', 'List order method.', 'webman-amplifier' ),
								'name'   => _x( 'Alphabetically', 'List order method.', 'webman-amplifier' ),
								'random' => _x( 'Randomly', 'List order method.', 'webman-amplifier' ),
							) );
						foreach ( $options as $value => $name ) {
							echo '<option value="' . $value . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Optional posts taxonomy:', 'webman-amplifier' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>">
						<?php
						if ( function_exists( 'wma_taxonomy_array' ) ) {

							$taxonomy_args = apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_form' . '_taxonomy', array(
									'post' => array(
											'optgroup'     => __( 'Posts tags', 'webman-amplifier' ),
											'all'          => false,
											'hierarchical' => '0',
											'tax_name'     => 'post_tag',
										),
								) );

							//All option
								echo '<option value="" ' . selected( esc_attr( $instance['taxonomy'] ), '', false ) . '>' . __( '- All posts/projects -', 'webman-amplifier' ) . '</option>';

							//Post tags
								foreach ( $taxonomy_args as $taxonomy => $tax_args ) {
									echo '<optgroup label="' . $tax_args['optgroup'] . '">';

										$options = wma_taxonomy_array( $tax_args );

										foreach ( $options as $value => $name ) {
											echo '<option value="' . $tax_args['tax_name'] . ':' . $value . '" ' . selected( esc_attr( $instance['taxonomy'] ), $tax_args['tax_name'] . ':' . $value, false ) . '>' . $name . '</option>';
										}

									echo '</optgroup>';
								}

						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'Optional CSS class:', 'webman-amplifier' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo esc_attr( $instance['class'] ); ?>" />
				</p>
				<?php

				do_action( 'wmhook_widgets_' . 'wm_posts_widget' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['class']     = $new_instance['class'];
				$instance['count']     = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 4 );
				$instance['order']     = $new_instance['order'];
				$instance['post_type'] = $new_instance['post_type'];
				$instance['taxonomy']  = $new_instance['taxonomy'];
				$instance['title']     = $new_instance['title'];

			//Output
				return apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output = '';

				$instance = wp_parse_args( $instance, apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_defaults', array(
						'class'     => '',
						'count'     => 4,
						'layout'    => array( 'post' => 'widget' ),
						'order'     => 'new',
						'post_type' => 'post',
						'taxonomy'  => '',
						'title'     => '',
					) ) );

			//Praparing output
				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}

				$output .= do_shortcode( apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_shortcode', '[wm_posts class="' . $instance['class'] . '" columns="1" count="' . $instance['count'] . '" image_size="admin-thumbnail" layout="' . $instance['layout'][ $instance['post_type'] ] . '" order="' . $instance['order'] . '" post_type="' . $instance['post_type'] . '" taxonomy="' . $instance['taxonomy'] . '" /]', $args, $instance ) );

				$output .= $args['after_widget'];

			//Output
				echo apply_filters( 'wmhook_widgets_' . 'wm_posts_widget' . '_output', $output, $args, $instance );

		} // /widget

	} // /WM_Posts_Widget

?>