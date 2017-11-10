<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder plugin compatibility class
 *
 * Making shortcodes work as WPBakery Page Builder elements/modules.
 * Note that this page builder was previously called Visual Composer.
 * And its plugin folder name is `js_composer` to make things more complicated.
 * Simply put, what a tragedy plugin Visual Composer is... but I need to keep
 * the backwards compatibility, unfortunately.
 *
 * Why there is a compatibility for this plugin anyway?
 * ====================================================
 * At the time I was releasing Mustang WordPress theme, customers asked me to provide
 * compatibility for this page builder. It was the most used one then. Demand for this
 * integration was quite tough, so I had to overcome my dislike and introduced the
 * plugin compatibility. I knew it would be mistake, and it really was... So many
 * incompatible changes from version to version, pour code and extensibility,
 * a real nightmare to develop anything. At that time it even didn't have many useful
 * features so I had to implement them into my plugin extensions which, of course,
 * proved to be incompatible with future Visual Composer version when similar features
 * were actually introduced to the plugin. Anyway, here is a what you need to do:
 *
 * @todo  Remove this plugin compatibility! Make it separate plugin for those who still use this...
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Integration
 *  20) Shortcode output modifications
 *  30) Forms
 *  40) Assets
 * 100) Getters
 */
class WM_Amplifier_JS_Composer {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		private function __construct() {

			// Processing

				// Setup

					self::setup();

				// Hooks

					// Actions

						add_action( 'vc_backend_editor_enqueue_js_css', __CLASS__ . '::assets_enqueue_vc' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets_enqueue' );

					// Filters

						add_filter( 'wmhook_shortcode_definitions_processed', __CLASS__ . '::set_definitions_processed', 10, 4 );

						add_filter( 'wmhook_shortcode_process_content_run', __CLASS__ . '::process_content' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Integration
	 */

		/**
		 * Plugin setup
		 *
		 * @since    1.0.0
		 * @version  1.6.0
		 */
		public static function setup() {

			// Requirements check

				if ( ! self::is_active() ) {
					return;
				}


			// Processing

				// Options modifications

					delete_option( 'wpb_js_use_custom' );

				// Disable Frontend Editor

					if (
						function_exists( 'vc_disable_frontend' )
						&& apply_filters( 'wmhook_amplifier_js_composer_disable_frontend', true )
					) {
						vc_disable_frontend();
					}

				// Remove default VC shortcodes if the theme supports this functionality

					if (
						function_exists( 'vc_remove_element' )
						&& class_exists( 'WPBMap' )
						&& (
							wma_supports_subfeature( 'remove_vc_shortcodes' )
							|| wma_supports_subfeature( 'remove-vc-shortcodes' )
						)
					) {

						$vc_shortcodes_all  = array_keys( WPBMap::getShortCodes() );
						$vc_shortcodes_keep = array(
							// Rows
							'vc_row',
							'vc_row_inner',
							// Columns
							'vc_column',
							'vc_column_inner',
						);

						if ( is_callable( 'Vc_Automap_Model::findAll' ) ) {
							foreach ( Vc_Automap_Model::findAll() as $shortcode ) {
								// Do not remove custom mapped shortcodes
								$vc_shortcodes_keep[] = $shortcode->tag;
							}
						}

						$vc_shortcodes_keep   = (array) apply_filters( 'wmhook_shortcode_vc_keep', $vc_shortcodes_keep );
						$vc_shortcodes_remove = (array) apply_filters( 'wmhook_shortcode_vc_remove', array_diff( $vc_shortcodes_all, $vc_shortcodes_keep ) );

						foreach ( $vc_shortcodes_remove as $shortcode ) {
							vc_remove_element( $shortcode );
						}

					}

				// Register custom shortcodes

					$vc_shortcodes = WM_Shortcodes::get_definitions_processed( 'vc_plugin' );

					if (
						function_exists( 'vc_map' )
						&& ! empty( $vc_shortcodes )
					) {
						ksort( $vc_shortcodes );

						foreach ( $vc_shortcodes as $shortcode ) {

							if ( isset( $shortcode['params'] ) ) {
								ksort( $shortcode['params'] ); // Yes, you can sort nested arrays
							}

							// Fix required for Visual Composer 4.5.2+
							$shortcode['params'] = array_values( $shortcode['params'] );

							vc_map( $shortcode );

						}
					}

				// Custom shortcode admin interface

					/**
					 * @todo  Does this still work?
					 */
					require_once( WMAMP_INCLUDES_DIR . 'compatibility/js-composer/class-js-composer-extend.php' );

					vc_add_shortcode_param(
						'wm_radio',
						__CLASS__ . '::form_field_radio_custom'
					);

				// Custom shortcode render

					require_once( WMAMP_INCLUDES_DIR . 'compatibility/js-composer/functions-js-composer-render.php' );

		} // /setup



		/**
		 * Shortcodes globals setup
		 *
		 * @see  WM_Shortcodes::get_definitions_processed()
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  array  $output
		 * @param  string $code
		 * @param  array  $definition
		 * @param  string $prefix_shortcode
		 */
		public static function set_definitions_processed( $output = array(), $code = '', $definition = array(), $prefix_shortcode = '' ) {

			// Requirements check

				if ( ! self::is_active() ) {
					return $output;
				}


			// Processing

				if (
					isset( $definition['vc_plugin'] ) && ! empty( $definition['vc_plugin'] )
					// Check for VC required parameters
					&& isset( $definition['vc_plugin']['name'] )
					&& isset( $definition['vc_plugin']['base'] )
				) {
					$output['vc_plugin'][$code] = $definition['vc_plugin'];
				}


			// Output

				return $output;

		} // /set_definitions_processed





	/**
	 * 20) Shortcode output modifications
	 */

		/**
		 * Shortcode content processing setup
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  array $run  Process setup array.
		 */
		public static function process_content( $run = array() ) {

			// Processing

				if ( ! isset( $run['do_shortcode'] ) ) {
					$run['do_shortcode'] = array();
				}

				$run['do_shortcode'][] = 'vc_row';
				$run['do_shortcode'][] = 'vc_row_inner';
				$run['do_shortcode'][] = 'vc_column';
				$run['do_shortcode'][] = 'vc_column_inner';


			// Output

				return $run;

		} // /process_content



		/**
		 * Render custom shortcode
		 *
		 * @see  WM_Shortcodes::shortcode_render()
		 * @see  `includes/compatibility/js-composer/functions-js-composer.php`
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  array  $atts
		 * @param  string $content
		 * @param  string $shortcode
		 */
		public static function shortcode_render( $atts = array(), $content = '', $shortcode = '' ) {

			// Requirements check

				if ( ! class_exists( 'WM_Shortcodes' ) ) {
					return '';
				}


			// Helper variables

				if ( empty( $shortcode ) ) {
					$shortcode = 'vc_row';
				}

				$prefix_shortcode = WM_Shortcodes::$prefix_shortcode;

				$output = (string) apply_filters( 'wmhook_shortcode_' . $shortcode, '', $atts, $content );


			// Processing

				// Premature output

					if ( $output ) {
						return $output;
					}

				// Set renderer file path

					$path_folder = WM_Shortcodes::get_path_renderers();
					$path_file   = $path_folder . $shortcode . '.php';
					$path_file   = apply_filters( 'wmhook_shortcode_renderer_path', $path_file, $shortcode );

				// The shortcode file contains `$output` variable

					/**
					 * @todo  Use PHP buffer instead?
					 * @todo  But maybe still keep `include()` below as we are passing some variables (see above).
					 */
					if ( file_exists( $renderer_file_path ) ) {
						include( $renderer_file_path );
					}

					$output = apply_filters( 'wmhook_shortcode_output', $output, $shortcode, $atts );


			// Output

				return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );

		} // /shortcode_render





	/**
	 * 30) Forms
	 */

		/**
		 * Custom page builder input field: `wm_radio`
		 *
		 * @link  http://kb.wpbakery.com/index.php?title=Visual_Composer_Tutorial_Create_New_Param
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  array  $settings
		 * @param  string $value
		 */
		public static function form_field_radio_custom( $settings, $value ) {

			// Processing

				$name  = $settings['param_name'];
				$field = $settings;

				$field['options'] = $field['value'];


			// Output

				return WM_Amplifier_Page_Builder::form_field_radio_custom( $name, $value, $field, 'vc' );

		} // /form_field_radio_custom





	/**
	 * 40) Assets
	 */

		/**
		 * Enqueue frontend styles and scripts
		 *
		 * @since    1.0.0
		 * @version  1.6.0
		 */
		public static function assets_enqueue() {

			// Processing

				// Styles

					// Deregister frontend styles

						if (
							wma_supports_subfeature( 'remove_vc_shortcodes' )
							|| wma_supports_subfeature( 'remove-vc-shortcodes' )
						) {
							wp_deregister_style( 'js_composer_front' );
						}

		} // /assets_enqueue



		/**
		 * Enqueue admin styles and scripts
		 *
		 * We need to use full syntax of the `wp_enqueue_style()/wp_enqueue_script()` functions
		 * here, not just referencing registered style/script name, as Visual Composer loads assets
		 * quite strangely, and those handles are not registered yet.
		 *
		 * @since    1.2.9
		 * @version  1.6.0
		 */
		public static function assets_enqueue_vc() {

			// Requirements check

				if ( ! current_user_can( apply_filters( 'wmhook_wmamp_editor_capability', 'edit_posts' ) ) ) {
					return;
				}


			// Helper variables

				global $pagenow, $post_type;

				$admin_pages = (array) apply_filters( 'wmhook_shortcode_vc_admin_pages', array(
					'post.php',
					'post-new.php'
				) );

				$deps_js = ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.9', '<' ) ) ? ( array( 'wpb_js_composer_js_atts', 'wpb_js_composer_js_custom_views' ) ) : ( array( 'vc-backend-min-js' ) );


			// Processing

				$vc_supported_post_types = ( get_option( 'wpb_js_content_types' ) ) ? ( (array) get_option( 'wpb_js_content_types' ) ) : ( array( 'page' ) );

				if (
					in_array( $pagenow, $admin_pages )
					&& WM_Amplifier_JS_Composer::is_active()
					&& in_array( $post_type, $vc_supported_post_types )
					&& defined( 'WPB_VC_VERSION' )
				) {

					// Styles

						wp_enqueue_style(
							'wm-shortcodes-vc-addon',
							WMAMP_ASSETS_URL . 'css/shortcodes-vc-addons.css',
							array(),
							WMAMP_VERSION,
							'screen'
						);

						wp_enqueue_style(
							'wm-radio',
							WMAMP_ASSETS_URL . 'css/input-wm-radio.css',
							array(),
							WMAMP_VERSION,
							'screen'
						);

					// Scripts

						wp_enqueue_script(
							'wm-shortcodes-vc-addon',
							WMAMP_ASSETS_URL . 'js/shortcodes-vc-addons.js',
							(array) $deps_js,
							WMAMP_VERSION,
							true
						);

				}

				// Allow hooking for dequeuing

					do_action( 'wmhook_shortcode_assets_enqueued_vc' );

		} // /assets_enqueue_vc





	/**
	 * 100) Getters
	 */

		/**
		 * Check if page builder is active
		 *
		 * Supports both 4.2+ plugin versions and older too.
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		public static function is_active() {

			// Requirements check

				if ( wma_supports_subfeature( 'disable-visual-composer-support' ) ) {
					return false;
				}


			// Output

				return (bool) apply_filters( 'wmhook_amplifier_js_composer_is_active', ( class_exists( 'Vc_Manager' ) || class_exists( 'WPBakeryVisualComposer' ) ) );

		} // /is_active





} // /WM_Amplifier_JS_Composer

add_action( 'init', 'WM_Amplifier_JS_Composer::init', 6 ); // Just after WM_Shortcodes()
