<?php
/**
 * Widget: Posts
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wm"
	function wm_posts_widget_registration() {

		// Processing

			register_widget( 'WM_Posts_Widget' );

	} // /wm_posts_widget_registration





/**
 * 30) Widget class
 */

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with "wm"
	class WM_Posts_Widget extends WP_Widget {

		/**
		 * Constructor
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function __construct() {

			// Helper variables

				$theme = ( is_child_theme() ) ? ( wp_get_theme()->parent()->get_template() ) : ( null );

				$atts = array();

				$atts['id']          = 'wm-posts-widget';
				$atts['name']        = wp_get_theme( $theme )->get( 'Name' ) . ' ' . esc_html_x( 'Posts', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
					'classname'                   => 'wm-posts-widget',
					'description'                 => _x( 'Lists posts or projects', 'Widget description.', 'webman-amplifier' ),
					'customize_selective_refresh' => true,
				);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_wm_posts_widget_atts', $atts );


			// Processing

				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			// Helper variables

				$instance = wp_parse_args( $instance, array(
					'class'     => '',
					'count'     => 4,
					'order'     => 'new',
					'post_type' => 'post',
					'taxonomy'  => '',
					'title'     => '',
				) );


			// Output

				?>

				<p class="wm-desc"><?php
					echo esc_html_x( 'Displays list of Posts or Projects.', 'Widget description.', 'webman-amplifier' );
				?></p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php
						esc_html_e( 'Title:', 'webman-amplifier' );
					?></label>
					<input
						type="text"
						id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
						value="<?php echo esc_attr( $instance['title'] ); ?>"
						class="widefat"
						/>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php
						esc_html_e( 'Post type:', 'webman-amplifier' );
					?></label>
					<select
						class="widefat"
						name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"
						>
						<?php

						$options = apply_filters( 'wmhook_widgets_wm_posts_widget_form_post_type', array( 'post' => esc_html__( 'Posts', 'webman-amplifier' ) ) );

						foreach ( $options as $value => $name ) {
							echo '<option value="' . esc_attr( $value ) . '" ' . selected( esc_attr( $instance['post_type'] ), $value, false ) . '>' . esc_html( $name ) . '</option>';
						}

						?>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php
						esc_html_e( 'Posts count:', 'webman-amplifier' );
					?></label>
					<input
						class="text-center"
						type="number"
						id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
						value="<?php echo absint( $instance['count'] ); ?>"
						min="1"
						max="20"
						style="vertical-align: middle;"
						/>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php
						esc_html_e( 'Ordering:', 'webman-amplifier' );
					?></label>
					<select
						class="widefat"
						name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
						>
						<?php

						$options = apply_filters( 'wmhook_widgets_wm_posts_widget_form_order', array(
							'new'    => _x( 'Newest first', 'List order method.', 'webman-amplifier' ),
							'old'    => _x( 'Oldest first', 'List order method.', 'webman-amplifier' ),
							'name'   => _x( 'Alphabetically', 'List order method.', 'webman-amplifier' ),
							'random' => _x( 'Randomly', 'List order method.', 'webman-amplifier' ),
						) );

						foreach ( $options as $value => $name ) {
							echo '<option value="' . esc_attr( $value ) . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . esc_html( $name ) . '</option>';
						}

						?>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php
						esc_html_e( 'Optional posts taxonomy:', 'webman-amplifier' );
					?></label>
					<select
						class="widefat"
						name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"
						>
						<?php

						if ( function_exists( 'wma_taxonomy_array' ) ) {

							$taxonomy_args = apply_filters( 'wmhook_widgets_wm_posts_widget_form_taxonomy', array(
								'post' => array(
									'optgroup'     => __( 'Posts tags', 'webman-amplifier' ),
									'all'          => false,
									'hierarchical' => '0',
									'tax_name'     => 'post_tag',
								),
							) );

							// All option
							echo '<option value="" ' . selected( esc_attr( $instance['taxonomy'] ), '', false ) . '>' . esc_html__( '- All posts/projects -', 'webman-amplifier' ) . '</option>';

							// Post tags
							foreach ( $taxonomy_args as $taxonomy => $tax_args ) {
								echo '<optgroup label="' . esc_attr( $tax_args['optgroup'] ) . '">';

									$options = wma_taxonomy_array( $tax_args );

									foreach ( $options as $value => $name ) {
										echo '<option value="' . esc_attr( $tax_args['tax_name'] . ':' . $value ) . '" ' . selected( esc_attr( $instance['taxonomy'] ), $tax_args['tax_name'] . ':' . $value, false ) . '>' . esc_html( $name ) . '</option>';
									}

								echo '</optgroup>';
							}
						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"><?php
						esc_html_e( 'Optional CSS class:', 'webman-amplifier' );
					?></label>
					<input
						class="widefat"
						id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>"
						type="text"
						value="<?php echo esc_attr( $instance['class'] ); ?>"
						/>
				</p>

				<?php

				do_action( 'wmhook_widgets_wm_posts_widget_form', $instance );

		} // /form



		/**
		 * Save the options
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function update( $new_instance, $old_instance ) {

			// Helper variables

				$instance = $old_instance;


			// Processing

				$instance['class']     = sanitize_text_field( $new_instance['class'] );
				$instance['count']     = absint( $new_instance['count'] );
				$instance['order']     = sanitize_text_field( $new_instance['order'] );
				$instance['post_type'] = sanitize_text_field( $new_instance['post_type'] );
				$instance['taxonomy']  = sanitize_text_field( $new_instance['taxonomy'] );
				$instance['title']     = sanitize_text_field( $new_instance['title'] );


			// Output

				return apply_filters( 'wmhook_widgets_wm_posts_widget_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 *
		 * @version  1.0.9.9
		 * @version  1.6.0
		 */
		function widget( $args, $instance ) {

			// Helper variables

				$output = '';

				$instance = wp_parse_args( $instance, apply_filters( 'wmhook_widgets_wm_posts_widget_defaults', array(
					'class'     => '',
					'count'     => 4,
					'layout'    => array( 'post' => 'widget' ),
					'order'     => 'new',
					'post_type' => 'post',
					'taxonomy'  => '',
					'title'     => '',
				) ) );


			// Processing

				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .=
						$args['before_title']
						. apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base, $args )
						. $args['after_title'];
				}

				$output .= do_shortcode(
					apply_filters(
						'wmhook_widgets_wm_posts_widget_shortcode',
						'[wm_posts'
						. ' class="' . esc_attr( $instance['class'] ) . '"'
						. ' columns="1"'
						. ' count="' . absint( $instance['count'] ) . '"'
						. ' image_size="thumbnail"'
						. ' layout="' . esc_attr( $instance['layout'][ $instance['post_type'] ] ) . '"'
						. ' order="' . esc_attr( $instance['order'] ) . '"'
						. ' post_type="' . esc_attr( $instance['post_type'] ) . '"'
						. ' taxonomy="' . esc_attr( $instance['taxonomy'] ) . '"'
						. ' /]',
						$args,
						$instance
					)
				);

				$output .= $args['after_widget'];


			// Output

				echo wp_kses_post(
					apply_filters(
						'wmhook_widgets_wm_posts_widget_output',
						$output,
						$args,
						$instance
					)
				);

		} // /widget

	} // /WM_Posts_Widget
