<?php
/**
 * Widget: Content Module
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

		add_action( 'widgets_init', 'wm_module_widget_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_module_widget_registration() {
		register_widget( 'WM_Module_Widget' );
	} // /wm_module_widget_registration





/**
 * 30) Widget class
 */

	class WM_Module_Widget extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['name'] = ( defined( 'WM_THEME_NAME' ) ) ? ( WM_THEME_NAME . ' ' ) : ( '' );

				$atts['id']          = 'wm-module-widget';
				$atts['name']       .= _x( 'Content Module', 'Widget name.', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-module-widget',
						'description' => _x( 'Displays specific Content Module post', 'Widget description.', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_atts', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'class'  => '',
						'module' => '',
						'title'  => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays content of the specific Content Module custom post. Please choose the Content Module below.', 'Widget description.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<?php
					$posts = get_posts( apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_form' . '_get_posts', array(
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
							'post_type'      => 'wm_modules',
						) ) );

					if ( ! empty( $posts ) ) {
						?>
						<label for="<?php echo $this->get_field_id( 'module' ); ?>"><?php _e( 'Content Module to display:', 'wm_domain' ) ?></label><br />
						<select class="widefat" id="<?php echo $this->get_field_id( 'module' ); ?>" name="<?php echo $this->get_field_name( 'module' ); ?>">
							<option value="" <?php selected( $instance['module'], '' ); ?>><?php _e( '- Select Content Module -', 'wm_domain' ); ?></option>
						<?php
						foreach ( $posts as $post ) {
							$terms = get_the_terms( $post->ID , apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_form' . '_taxonomy', 'module_tag' ) );
							$tags  = '';
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								$taxonomy = array();
								foreach ( $terms as $term ) {
									if ( isset( $term->name ) ) {
										$taxonomy[] = $term->name;
									}
								}
								$tags .= sprintf( __( ' (tags: %s)', 'wm_domain' ), implode( ', ', $taxonomy ) );
							}

							?>
							<option<?php echo ' value="'. $post->post_name . '" '; selected( $instance['module'], $post->post_name ); ?>><?php echo $post->post_title . $tags; ?></option>
							<?php
						}
						?>
						</select>
						<?php
					} else {
						_e( 'There are no Content Modules to choose from. Please add a new Content Module first.', 'wm_domain' );
					};
					?>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'Optional CSS class:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo esc_attr( $instance['class'] ); ?>" />
				</p>
				<?php

				do_action( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['class']  = $new_instance['class'];
				$instance['module'] = $new_instance['module'];
				$instance['title']  = $new_instance['title'];

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output = '';

				$instance = wp_parse_args( $instance, array(
						'class'  => '',
						'module' => '',
						'title'  => '',
					) );

			//Praparing output
				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}

				$output .= do_shortcode( apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_shortcode', '[wm_content_module class="' . $instance['class'] . '" module="' . $instance['module'] . '" /]', $args, $instance ) );

				$output .= $args['after_widget'];

			//Output
				echo apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_module_widget' . '_output', $output, $args, $instance );

		} // /widget

	} // /WM_Module_Widget

?>