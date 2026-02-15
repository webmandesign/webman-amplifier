<?php
/**
 * Widget: Sub Navigation
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
 * 30) Widget class
 */
/**
 * Widget class
 *
 * @since    1.0.9.9
 * @version  1.4
 *
 * Contents:
 *
 *  0) Init
 * 10) Output
 * 20) Options
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with "wm"
class WM_Subnav extends WP_Widget {





	/**
	 * 0) Init
	 */

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

				$atts['id']          = 'wm-subnav';
				$atts['name']        = wp_get_theme( $theme )->get( 'Name' ) . ' ' . esc_html_x( 'Submenu', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
					'classname'                   => 'wm-subnav',
					'description'                 => esc_html_x( 'List of subpages', 'Widget description.', 'webman-amplifier' ),
					'customize_selective_refresh' => true,
				);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_wm_subnav_atts', $atts );


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
		 * @version  1.6.0
		 */
		function widget( $args, $instance ) {

			// Requirements check

				$post_types = get_post_types( array( 'hierarchical' => true ) );

				if (
					! is_singular( $post_types )
					|| apply_filters( 'wmhook_widgets_wm_subnav_disabled', false, $args, $instance )
				) {
					return;
				}


			// Helper variables

				global $post;

				$output = '';

				$instance = wp_parse_args( $instance, array(
					'depth'  => 3,
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
							$args['before_title'] = $args['before_title'] . '<a href="' . esc_url( get_permalink( $grandparent ) ) . '">';
							$instance['title']    = get_the_title( $grandparent );
							$args['after_title']  = '</a>' . $args['after_title'];
						} else {
							$args['before_title'] = $args['before_title'] . '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
							$instance['title']    = get_the_title( $post->ID );
							$args['after_title']  = '</a>' . $args['after_title'];
						}

						$instance['title'] = apply_filters( 'wmhook_widgets_wm_subnav_title_auto', $instance['title'], $args, $instance );
					}


				// Subpages or siblings

					$args_children = array(
						'post_type'   => get_post_type( $post ),
						'title_li'    => '',
						'depth'       => absint( $instance['depth'] ),
						'sort_column' => $instance['order'],
						'echo'        => false,
						'child_of'    => $post->ID,
					);

					if ( $grandparent ) {
						$args_children['child_of'] = $grandparent;
					}

					$children = wp_list_pages( (array) apply_filters( 'wmhook_widgets_wm_subnav_wp_list_pages_args', $args_children, $args, $instance ) );

				// If there are no pages, don't display the widget

					if ( empty( $children ) ) {
						return;
					}


			// Processing

				// Before widget
				$output .= $args['before_widget'];

				// Title
				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base, $args ) . $args['after_title'];
				}
				$output .= '<ul class="sub-nav">' . $children . '</ul>';


				// After widget
				$output .= $args['after_widget'];


			// Output

				echo wp_kses_post(
					apply_filters(
						'wmhook_widgets_wm_subnav_output',
						$output,
						$args,
						$instance
					)
				);

		} // /widget





	/**
	 * 20) Options
	 */

		/**
		 * Options form
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function form( $instance ) {

			// Helper variables

				$instance = wp_parse_args( $instance, array(
					'depth'  => 3,
					'order'  => 'menu_order',
					'parent' => '',
					'title'  => '',
				) );


			// Output

				?>

				<p class="wm-desc"><?php
					echo esc_html_x( 'Displays a hierarchical list of child and sibling pages for the current page.', 'Widget description.', 'webman-amplifier' );
				?></p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php
						esc_html_e( 'Title:', 'webman-amplifier' );
					?></label>
					<input
						type="text"
						name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
						value="<?php echo esc_attr( $instance['title'] ); ?>"
						class="widefat"
						/>
					<br>
					<small><?php
						esc_html_e( 'If you leave blank, the main parent page title will be displayed.', 'webman-amplifier' )
					?></small>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php
						esc_html_e( 'Child pages depth level:', 'webman-amplifier' );
					?></label>
					<input
						type="number"
						name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"
						value="<?php echo esc_attr( $instance['depth'] ); ?>"
						min="1"
						max="10"
						style="vertical-align: middle;"
						/>
				</p>

				<p>
					<input
						type="checkbox"
						name="<?php echo esc_attr( $this->get_field_name( 'parent' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'parent' ) ); ?>"
						<?php checked( (bool) $instance['parent'] ); ?>
						/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'parent' ) ); ?>"><?php
						esc_html_e( 'Direct parent and its child pages only', 'webman-amplifier' );
					?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php
						esc_html_e( 'List order:', 'webman-amplifier' );
					?></label>
					<select
						name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
						class="widefat"
						><?php

						$options = apply_filters( 'wmhook_widgets_wm_subnav_form_order', array(
							'post_title' => esc_html_x( 'By name', 'List order method.', 'webman-amplifier' ),
							'post_date'  => esc_html_x( 'By date', 'List order method.', 'webman-amplifier' ),
							'menu_order' => esc_html_x( 'Menu order', 'List order method.', 'webman-amplifier' ),
						) );

						foreach ( $options as $value => $name ) {
							echo '<option value="' . esc_attr( $value ) . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . esc_html( $name ) . '</option>';
						}

					?></select>
				</p>

				<?php

				do_action( 'wmhook_widgets_wm_subnav_form', $instance );

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

				$instance['depth']  = absint( $new_instance['depth'] );
				$instance['order']  = sanitize_text_field( $new_instance['order'] );
				$instance['parent'] = (bool) $new_instance['parent'];
				$instance['title']  = sanitize_text_field( $new_instance['title'] );


			// Output

				return apply_filters( 'wmhook_widgets_wm_subnav_instance', $instance, $new_instance, $old_instance );

		} // /update





} // /WM_Subnav





/**
 * Widget registration
 *
 * @since    1.0.9.9
 * @version  1.2.8
 */
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wm"
function wm_subnav_registration() {

	// Processing

		register_widget( 'WM_Subnav' );

} // /wm_subnav_registration

add_action( 'widgets_init', 'wm_subnav_registration' );
