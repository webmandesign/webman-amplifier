<?php
/**
 * Widget: Content Module
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

		add_action( 'widgets_init', 'wm_module_widget_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 *
	 * @since    1.0.9.9
	 * @version  1.6.0
	 */
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wm"
	function wm_module_widget_registration() {

		// Processing

			register_widget( 'WM_Module_Widget' );

	} // /wm_module_widget_registration





/**
 * 30) Widget class
 */

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with "wm"
	class WM_Module_Widget extends WP_Widget {

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

				$atts['id']          = 'wm-module-widget';
				$atts['name']        = wp_get_theme( $theme )->get( 'Name' ) . ' ' . esc_html_x( 'Content Module', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
					'classname'                   => 'wm-module-widget',
					'description'                 => _x( 'Displays specific Content Module post', 'Widget description.', 'webman-amplifier' ),
					'customize_selective_refresh' => true,
				);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_wm_module_widget_atts', $atts );


			// Processing

				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function form( $instance ) {

			// Helper variables

				$instance = wp_parse_args( $instance, array(
					'class'  => '',
					'module' => '',
					'title'  => '',
				) );


			// Output

				?>

				<p class="wm-desc"><?php
					echo esc_html_x( 'Displays content of the specific Content Module custom post. Please choose the Content Module below.', 'Widget description.', 'webman-amplifier' );
				?></p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php
						esc_html_e( 'Title:', 'webman-amplifier' );
					?></label>
					<input
						class="widefat"
						id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
						type="text"
						value="<?php echo esc_attr( $instance['title'] ); ?>"
						/>
				</p>

				<p>
					<?php

					$posts = get_posts( apply_filters( 'wmhook_widgets_wm_module_widget_form_get_posts', array(
						'posts_per_page' => 40,
						'orderby'        => 'title',
						'order'          => 'ASC',
						'post_type'      => 'wm_modules',
					) ) );

					if ( ! empty( $posts ) ) {

						?>
						<label for="<?php echo esc_attr( $this->get_field_id( 'module' ) ); ?>"><?php
							esc_html_e( 'Content Module to display:', 'webman-amplifier' );
						?></label>
						<select
							class="widefat"
							id="<?php echo esc_attr( $this->get_field_id( 'module' ) ); ?>"
							name="<?php echo esc_attr( $this->get_field_name( 'module' ) ); ?>"
							>
							<option value="" <?php selected( $instance['module'], '' ); ?>><?php
								esc_html_e( '- Select Content Module -', 'webman-amplifier' );
							?></option>
							<?php

							foreach ( $posts as $post ) {

								$tags  = '';
								$terms = get_the_terms( $post->ID , apply_filters( 'wmhook_widgets_wm_module_widget_form_taxonomy', 'module_tag' ) );

								if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {

									$taxonomy = array();

									foreach ( $terms as $term ) {
										if ( isset( $term->name ) ) {
											$taxonomy[] = $term->name;
										}
									}

									$tags .= sprintf(
										/* translators: %s: list of tag names. */
										esc_html__( ' (tags: %s)', 'webman-amplifier' ),
										implode( ', ', $taxonomy )
									);
								}

								?>
								<option value="<?php echo esc_attr( $post->post_name ); ?>" <?php selected( $instance['module'], $post->post_name ); ?>><?php
									echo esc_html( $post->post_title . $tags );
								?></option>
								<?php
							}

							?>
						</select>
						<?php

					} else {

						esc_html_e( 'There are no Content Modules to choose from. Please add a new Content Module first.', 'webman-amplifier' );
					};

					?>
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

				do_action( 'wmhook_widgets_wm_module_widget_form', $instance );

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

				$instance['class']  = sanitize_text_field( $new_instance['class'] );
				$instance['module'] = sanitize_text_field( $new_instance['module'] );
				$instance['title']  = sanitize_text_field( $new_instance['title'] );


			// Output

				return apply_filters( 'wmhook_widgets_wm_module_widget_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function widget( $args, $instance ) {

			// Helper variables

				$output = '';

				$instance = wp_parse_args( $instance, array(
					'class'  => '',
					'module' => '',
					'title'  => '',
				) );


			// Processing

				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base, $args ) . $args['after_title'];
				}

				$output .= do_shortcode(
					apply_filters(
						'wmhook_widgets_wm_module_widget_shortcode',
						'[wm_content_module'
						. ' class="' . esc_attr( $instance['class'] ) . '"'
						. ' module="' . esc_attr( $instance['module'] ) . '"'
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

	} // /WM_Module_Widget
