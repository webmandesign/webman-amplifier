<?php
/**
 * Widget: Tabbed Widgets
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

		add_action( 'init',         'wm_tabbed_widgets_init'         );
		add_action( 'widgets_init', 'wm_tabbed_widgets_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_tabbed_widgets_registration() {
		register_widget( 'WM_Tabbed_Widgets' );
	} // /wm_tabbed_widgets_registration



	/**
	 * Register additional widget area for the widget
	 */
	if ( ! function_exists( 'wm_tabbed_widgets_init' ) ) {
		function wm_tabbed_widgets_init() {
			register_sidebar( array(
				'name'        => _x( 'Tabbed Widgets', 'Widgets area name.', 'wm_domain' ),
				'id'          => 'tabbed-widgets',
				'description' => _x( 'Default widget area for Tabbed Widgets widget.', 'Widgets area description.', 'wm_domain' ),
			) );
		}
	} // /wm_tabbed_widgets_init





/**
 * 30) Widget class
 */

	class WM_Tabbed_Widgets extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['name'] = ( defined( 'WM_THEME_NAME' ) ) ? ( WM_THEME_NAME . ' ' ) : ( '' );

				$atts['id']          = 'wm-tabbed-widgets';
				$atts['name']       .= _x( 'Tabbed Widgets', 'Widget name.', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-tabbed-widgets',
						'description' => _x( 'Multiple widgets in tabs', 'Widget description.', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_tabbed_widgets' . '_atts', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'sidebar' => 'tabbed-widgets',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays widgets from selected widget area in tabbed interface.', 'Widget description.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'sidebar' ); ?>"><?php _e( 'Widgets area displayed', 'wm_domain' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'sidebar' ); ?>" id="<?php echo $this->get_field_id( 'sidebar' ); ?>">
						<?php
						if ( function_exists( 'wma_widget_areas_array' ) ) {
							$options = wma_widget_areas_array();
							foreach ( $options as $value => $name ) {
								echo '<option value="' . $value . '" ' . selected( $instance['sidebar'], $value, false ) . '>' . $name . '</option>';
							}
						}
						?>
					</select>
				</p>
				<?php

				do_action( WM_WIDGETS_HOOK_PREFIX . 'wm_tabbed_widgets' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['sidebar'] = $new_instance['sidebar'];

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_tabbed_widgets' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Enqueue required scripts
				wp_enqueue_script( 'wm-shortcodes-tabs' );

			//Output
				add_filter( 'dynamic_sidebar_params', array( &$this, 'wm_tabbed_widget_parameters' ), 99 );
				// add_filter( 'widget_title', 'strip_tags', 99 );

				echo $args['before_widget'];

					if ( $args['id'] !== $instance['sidebar'] ) {

						echo '<div id="' . $args['widget_id'] . '" class="' . $args['widget_id'] . ' wm-tabbed-widgets wm-tabs clearfix layout-top">';
						dynamic_sidebar( $instance['sidebar'] );
						echo '</div>';

					} else {

						_e( 'Widget area conflict in Tabbed Widgets widget.', 'wm_domain' );

					}

				echo $args['after_widget'];

				remove_filter( 'dynamic_sidebar_params', array( &$this, 'wm_tabbed_widget_parameters' ), 99 );
				// remove_filter( 'widget_title', 'strip_tags', 99 );

		} // /widget



		/**
		 * Redefine widget parameters
		 */
		public function wm_tabbed_widget_parameters( $params ) {

			//Helper variables
				$params[0]['before_widget'] = '<div class="wm-item ' . $params[0]['widget_id'] . '" id="' . $params[0]['widget_id'] . '" data-title="' . $params[0]['widget_id'] . '&&">';
				$params[0]['after_widget']  = '</div>';
				$params[0]['before_title']  = '<p class="tab-title">';
				$params[0]['after_title']   = '</p>';

			//Output
				return $params;

		} // /wm_tabbed_widget_parameters

	} // /WM_Tabbed_Widgets

?>