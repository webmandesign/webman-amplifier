<?php
/**
 * Widget: Tabbed Widgets
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

		add_action( 'init',         'wm_tabbed_widgets_init'         );
		add_action( 'widgets_init', 'wm_tabbed_widgets_registration' );





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
	function wm_tabbed_widgets_registration() {

		// Processing

			register_widget( 'WM_Tabbed_Widgets' );

	} // /wm_tabbed_widgets_registration



	/**
	 * Register additional widget area for the widget
	 *
	 * @since    1.0.9.9
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wm_tabbed_widgets_init' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wm"
		function wm_tabbed_widgets_init() {

			// Processing

				register_sidebar( array(
					'name'        => esc_html_x( 'Tabbed Widgets', 'Widgets area name.', 'webman-amplifier' ),
					'id'          => 'tabbed-widgets',
					'description' => esc_html_x( 'Default widget area for Tabbed Widgets widget.', 'Widgets area description.', 'webman-amplifier' ),
				) );

		}
	} // /wm_tabbed_widgets_init





/**
 * 30) Widget class
 */

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with "wm"
	class WM_Tabbed_Widgets extends WP_Widget {

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

				$atts['id']          = 'wm-tabbed-widgets';
				$atts['name']        = wp_get_theme( $theme )->get( 'Name' ) . ' ' . esc_html_x( 'Tabbed Widgets', 'Widget name.', 'webman-amplifier' );
				$atts['widget_ops']  = array(
					'classname'                   => 'wm-tabbed-widgets',
					'description'                 => _x( 'Multiple widgets in tabs', 'Widget description.', 'webman-amplifier' ),
					// 'customize_selective_refresh' => true,
				);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_widgets_wm_tabbed_widgets_atts', $atts );


			// Processing

				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

				// Enqueue style if widget is active (appears in a sidebar) or if in Customizer preview.
				if (
					is_active_widget( false, false, $this->id_base )
					|| is_customize_preview()
				) {
					add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
				}

		} // /__construct



		/**
		 * Enqueue assets
		 *
		 * @since    1.0.9.9
		 * @version  1.3.10
		 */
		public function assets() {

			// Processing

				wp_enqueue_script( 'wm-shortcodes-tabs' );

		} // /assets



		/**
		 * Options form
		 */
		function form( $instance ) {

			// Helper variables

				$sidebars = wma_widget_areas_array();
				$instance = wp_parse_args( $instance, array(
					'sidebar' => 'tabbed-widgets',
					'title'   => '',
				) );

				if ( isset( $sidebars[ $instance['sidebar'] ] ) ) {
					$instance['title'] = '"' . $sidebars[ $instance['sidebar'] ] . '"';
				}

			// Output

				?>

				<p class="wm-desc"><?php
					echo esc_html_x( 'Displays widgets from selected widget area in tabbed interface.', 'Widget description.', 'webman-amplifier' );
				?></p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>"><?php
						esc_html_e( 'Widgets area displayed', 'webman-amplifier' );
					?></label>
					<select
						class="widefat"
						name="<?php echo esc_attr( $this->get_field_name( 'sidebar' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>"
						>
						<?php

						if ( function_exists( 'wma_widget_areas_array' ) ) {
							foreach ( $sidebars as $value => $name ) {
								echo '<option value="' . esc_attr( $value ) . '" ' . selected( $instance['sidebar'], $value, false ) . '>' . esc_html( $name ) . '</option>';
							}
						}

						?>
					</select>
				</p>

				<input
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					type="hidden"
					value="<?php echo esc_attr( $instance['title'] ); ?>"
					/>

				<?php

				do_action( 'wmhook_widgets_wm_tabbed_widgets_form', $instance );

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
				$sidebars = wma_widget_areas_array();


			// Processing

				$instance['sidebar'] = sanitize_text_field( $new_instance['sidebar'] );

				if ( isset( $sidebars[ $instance['sidebar'] ] ) ) {
					$instance['title'] = sanitize_text_field( '"' . $sidebars[ $instance['sidebar'] ] . '"' );
				}


			// Output

				return apply_filters(
					'wmhook_widgets_wm_tabbed_widgets_instance',
					$instance,
					$new_instance,
					$old_instance
				);

		} // /update



		/**
		 * Widget HTML
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		function widget( $args, $instance ) {

			// Output

				add_filter( 'dynamic_sidebar_params', array( &$this, 'wm_tabbed_widget_parameters' ), 99 );

				ob_start();

					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see below
					echo $args['before_widget'];

					echo '<div id="' . esc_attr( $args['widget_id'] ) . '" class="' . esc_attr( $args['widget_id'] ) . ' wm-tabbed-widgets wm-tabs clearfix layout-top">';

					if ( $args['id'] !== $instance['sidebar'] ) {
						dynamic_sidebar( $instance['sidebar'] );
					} else {
						esc_html_e( 'Widget area conflict in Tabbed Widgets widget.', 'webman-amplifier' );
					}

					echo '</div>';

					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see below
					echo $args['after_widget'];

				$output = ob_get_clean();

				echo wp_kses( $output, WMA_KSES::$prefix . 'post+form' );

				remove_filter( 'dynamic_sidebar_params', array( &$this, 'wm_tabbed_widget_parameters' ), 99 );

		} // /widget



		/**
		 * Redefine widget parameters
		 *
		 * @since    1.0.9.9
		 * @version  1.6.0
		 */
		public function wm_tabbed_widget_parameters( $params ) {

			// Helper variables

				$params[0]['before_widget'] = '<div class="wm-item ' . esc_attr( $params[0]['widget_id'] ) . '" id="' . esc_attr( $params[0]['widget_id'] ) . '" data-title="' . esc_attr( $params[0]['widget_id'] ) . '&&">';
				$params[0]['after_widget']  = '</div>';
				$params[0]['before_title']  = '<p class="tab-title">';
				$params[0]['after_title']   = '</p>';


			// Output

				return $params;

		} // /wm_tabbed_widget_parameters

	} // /WM_Tabbed_Widgets
