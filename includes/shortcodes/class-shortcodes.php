<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WebMan Shortcodes class
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Setup
 * 100) Getters
 */
class WM_Shortcodes {





	/**
	 * 0) Init
	 */

		private static $instance;

		public static $definitions = array();

		public static $prefix_shortcode = 'wm_';
		public static $prefix_shortcode_name = 'WM ';



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 */
		private function __construct() {

			// Processing

				// Setup

					// Cache shortcode definitions array

						self::$definitions = self::get_definitions_from_file();

				// Hooks

				self::setup_filters();

				self::add_shortcodes();

				/**
				 * @todo  This should go into `includes/compatibility/` folder!
				 */
				// Beaver Builder plugin integration

					self::beaver_builder_support();

				// Visual Composer plugin integration

					if ( wma_is_active_vc() ) {
						self::visual_composer_support();
					}

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.5.0
		 * @version  1.5.0
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
	 * 10) Setup
	 */

		/**
		 * Register styles and scripts
		 *
		 * @since    1.0.0
		 * @version  1.3.15
		 */
		public static function assets_register() {

			// Helper variables

				$icon_font_url = WM_Amplifier::fix_ssl_urls( esc_url_raw( apply_filters( 'wmhook_metabox_' . 'iconfont_url', get_option( 'wmamp-icon-font' ) ) ) );
				$rtl           = ( is_rtl() ) ? ( '.rtl' ) : ( '' );

				$vc_backend_dependencies = ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.9', '<' ) ) ? ( array( 'wpb_js_composer_js_atts', 'wpb_js_composer_js_custom_views' ) ) : ( array( 'vc-backend-min-js' ) );


			// Processing

				// Styles

					wp_register_style( 'wm-radio',               WMAMP_ASSETS_URL . 'css/input-wm-radio.css',       array(), WMAMP_VERSION, 'screen' );
					wp_register_style( 'wm-shortcodes-bb-addon', WMAMP_ASSETS_URL . 'css/shortcodes-bb-addons.css', array(), WMAMP_VERSION, 'screen' );
					wp_register_style( 'wm-shortcodes-vc-addon', WMAMP_ASSETS_URL . 'css/shortcodes-vc-addons.css', array(), WMAMP_VERSION, 'screen' );
					if ( $icon_font_url ) {
						wp_register_style( 'wm-fonticons', $icon_font_url, array(), WMAMP_VERSION, 'screen' );
					}

				// Scripts

					wp_register_script( 'wm-shortcodes-accordion', WMAMP_ASSETS_URL . 'js/shortcode-accordion.js', array( 'jquery' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-parallax', WMAMP_ASSETS_URL . 'js/shortcode-parallax.js', array( 'jquery', 'jquery-parallax' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-posts-isotope', WMAMP_ASSETS_URL . 'js/shortcode-posts-isotope.js', array( 'jquery', 'imagesloaded' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-posts-masonry', WMAMP_ASSETS_URL . 'js/shortcode-posts-masonry.js', array( 'jquery', 'imagesloaded' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-posts-owlcarousel', WMAMP_ASSETS_URL . 'js/shortcode-posts-owlcarousel.js', array( 'jquery', 'imagesloaded' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-posts-slick', WMAMP_ASSETS_URL . 'js/shortcode-posts-slick.js', array( 'jquery', 'imagesloaded' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-slideshow-owlcarousel', WMAMP_ASSETS_URL . 'js/shortcode-slideshow-owlcarousel.js', array( 'jquery' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-tabs', WMAMP_ASSETS_URL . 'js/shortcode-tabs.js', array( 'jquery' ), WMAMP_VERSION, true );
					wp_register_script( 'wm-shortcodes-vc-addon', WMAMP_ASSETS_URL . 'js/shortcodes-vc-addons.js', (array) $vc_backend_dependencies, WMAMP_VERSION, true );

					// 3rd party scripts

						wp_register_script( 'isotope',             WMAMP_ASSETS_URL . 'js/plugins/isotope.pkgd.min.js',             array(),           WMAMP_VERSION, true );
						wp_register_script( 'jquery-lwtCountdown', WMAMP_ASSETS_URL . 'js/plugins/jquery.lwtCountdown.min.js',      array( 'jquery' ), WMAMP_VERSION, true );
						wp_register_script( 'jquery-owlcarousel',  WMAMP_ASSETS_URL . 'js/plugins/owl.carousel' . $rtl . '.min.js', array( 'jquery' ), WMAMP_VERSION, true );
						wp_register_script( 'jquery-parallax',     WMAMP_ASSETS_URL . 'js/plugins/jquery.parallax.min.js',          array( 'jquery' ), WMAMP_VERSION, true );
						wp_register_script( 'slick',               WMAMP_ASSETS_URL . 'js/plugins/slick.min.js',                    array( 'jquery' ), WMAMP_VERSION, true );

				// Allow hooking for deregistering

					do_action( 'wmhook_shortcode_' . 'assets_registered' );

		} // /assets_register



		/**
		 * Enqueue frontend styles and scripts
		 *
		 * @since    1.0
		 * @version  1.3.14
		 */
		public static function assets_frontend() {

			// Helper variables

				global $is_IE;
				$icon_font_url = apply_filters( 'wmhook_shortcode_' . 'iconfont_url', get_option( 'wmamp-icon-font' ) );


			// Processing

				// Styles

					if ( $icon_font_url ) {
						wp_enqueue_style( 'wm-fonticons' );
					}

					// Visual Composer - deregister frontend styles

						if ( wma_supports_subfeature( 'remove_vc_shortcodes' ) || wma_supports_subfeature( 'remove-vc-shortcodes' ) ) {
							wp_deregister_style( 'js_composer_front' );
						}

				// Allow hooking for dequeuing

					do_action( 'wmhook_shortcode_' . 'assets_frontend_enqueued' );

		} // /assets_frontend



		/**
		 * Enqueue backend (admin) styles and scripts for Visual Composer
		 *
		 * @since    1.2.9
		 * @version  1.5.0
		 */
		public static function assets_backend_vc() {

			// Requirements check

				if ( ! current_user_can( apply_filters( 'wmhook_wmamp_editor_capability', 'edit_posts' ) ) ) {
					return;
				}


			// Helper variables

				global $pagenow, $post_type;

				$admin_pages = array( 'post.php', 'post-new.php' );

				$vc_backend_dependencies = ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '4.9', '<' ) ) ? ( array( 'wpb_js_composer_js_atts', 'wpb_js_composer_js_custom_views' ) ) : ( array( 'vc-backend-min-js' ) );


			// Processing

				// Visual Composer plugin integration

					$vc_supported_post_types = ( get_option( 'wpb_js_content_types' ) ) ? ( (array) get_option( 'wpb_js_content_types' ) ) : ( array( 'page' ) );

					if (
						in_array( $pagenow, apply_filters( 'wmhook_shortcode_' . 'vc_admin_pages', $admin_pages ) )
						&& wma_is_active_vc()
						&& in_array( $post_type, $vc_supported_post_types )
						&& defined( 'WPB_VC_VERSION' )
					) {

						// Styles

							wp_enqueue_style( 'wm-shortcodes-vc-addon', WMAMP_ASSETS_URL . 'css/shortcodes-vc-addons.css', array(), WMAMP_VERSION, 'screen' );
							wp_enqueue_style( 'wm-radio', WMAMP_ASSETS_URL . 'css/input-wm-radio.css', array(), WMAMP_VERSION, 'screen' );

						// Scripts

							wp_enqueue_script( 'wm-shortcodes-vc-addon', WMAMP_ASSETS_URL . 'js/shortcodes-vc-addons.js', (array) $vc_backend_dependencies, WMAMP_VERSION, true );

						/**
						 * Yes, we need to set the whole `wp_enqueue_style/script()` function as Visual Composer loads
						 * assets strangely and those handles are not registered yet.
						 */

					}

				// Allow hooking for dequeuing

					do_action( 'wmhook_shortcode_' . 'assets_backend_vc_enqueued' );

		} // /assets_backend_vc



		/**
		 * Setup filter hooks
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 */
		public static function setup_filters() {

			// Processing

				// Assets

					add_action( 'init', __CLASS__ . '::assets_register', 998 ); // Has to be hooked early for shortcodes to use the registered script  @todo  Use full enqueue script syntax in shortcodes script enqueuing.
					add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets_frontend' );
					add_action( 'vc_backend_editor_enqueue_js_css', __CLASS__ . '::assets_backend_vc' );

				// Shortcodes in preprocess

					add_filter( 'wmhook_shortcode_preprocess_shortcodes_output', 'do_shortcode' );

				// Preprocess certain shortcodes

					add_filter( 'the_content',            __CLASS__ . '::preprocess_shortcodes', 7 );
					add_filter( 'wmhook_content_filters', __CLASS__ . '::preprocess_shortcodes', 7 );
					add_filter( 'widget_text',            __CLASS__ . '::preprocess_shortcodes', 7 );

				// Fixes HTML issues created by wpautop

					add_filter( 'the_content', __CLASS__ . '::fix_shortcodes' );

				// Process shortcodes `$content`

					add_filter( 'wmhook_shortcode__content', __CLASS__ . '::process_content', 20, 2 );

					// [pre]
					add_filter( 'wmhook_shortcode_' . 'pre' . '_content', __CLASS__ . '::process_content_pre', 10 );

					// [list]
					add_filter( 'wmhook_shortcode_' . 'list' . '_content', 'shortcode_unautop', 10 );

					// [widget_area]
					add_filter( 'wmhook_shortcode_' . 'widget_area' . '_output', 'wma_minify_html', 10 );

		} // /setup_filters



		/**
		 * Register shortcodes
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  array $shortcodes
		 */
		public static function add_shortcodes( $shortcodes = array() ) {

			// Helper variables

				$shortcodes = (array) $shortcodes;

				// Fall back to global shortcodes

					if ( empty( $shortcodes ) ) {
						$shortcodes = (array) self::get_definitions_processed( 'global' );
					}


			// Requirements check

				if ( empty( $shortcodes ) ) {
					return;
				}


			// Processing

				foreach ( $shortcodes as $shortcode ) {

					// Shortcode prefix may change for each shortcode down the way...

						$prefix_shortcode = self::$prefix_shortcode;

					// Modifying $prefix_shortcode if set

						if (
							is_array( $shortcode )
							&& isset( $shortcode['custom_prefix'] )
						) {
							$prefix_shortcode = $shortcode['custom_prefix'];
						}

					// Get shortcode name

						if (
							is_array( $shortcode )
							&& isset( $shortcode['name'] )
						) {
							$shortcode = $shortcode['name'];
						}

						$shortcode = $prefix_shortcode . $shortcode;

					// Add the shortcode now

						add_shortcode( $shortcode, __CLASS__ . '::shortcode_render' );

				}

		} // /add_shortcodes





	/**
	 * SHORTCODES OUTPUT MANIPULATION (FIXES)
	 */

		/**
		 * Content fixes for shortcodes
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  string $content Post/page content.
		 */
		public static function fix_shortcodes( $content = '' ) {
			$fix = array(
				'<p>['    => '[',
				']</p>'   => ']',
				']<br />' => ']',
				']<br>'   => ']'
			);
			$content = strtr( $content, $fix );

			return apply_filters( 'wmhook_shortcode_' . 'fix_shortcodes' . '_output', $content );
		} // /fix_shortcodes



		/**
		 * Preprocess shortcodes to prevent HTML mismatch
		 *
		 * Preprocessing shortcodes that use inline HTML tags prevent mess
		 * with <p> tags openings and closings.
		 * These shortcodes will be processed also normally (outside preprocessing)
		 * to retain compatibility with do_shortcode() (in sliders for example).
		 * Surely, if the shortcode was applied in preprocess, it shouldn't appear
		 * again in the content when processing shortcodes normally.
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  string $content
		 */
		public static function preprocess_shortcodes( $content = '' ) {

			// Helper variables

				$codes = (array) self::get_definitions_processed( 'preprocess' );


			// Requirements check

				if ( empty( $codes ) ) {
					return $content;
				}


			// Processing

				global $shortcode_tags;

				// Backup current registered shortcodes and clear them all out

					$shortcode_tags_backup = $shortcode_tags;
					remove_all_shortcodes();

				// Register shortcodes in preprocessing

					self::add_shortcodes( $codes );

				// Do the preprocess shortcodes prematurely (in WordPress standards)

					$content = (string) apply_filters( 'wmhook_shortcode_preprocess_shortcodes_output', $content, $codes );

				// Put the original shortcodes back

					$shortcode_tags = $shortcode_tags_backup;


			// Output

				return $content;

		} // /preprocess_shortcodes





	/**
	 * SHORTCODES' $content VARIABLE PROCESSING
	 */

		/**
		 * Shortcode content processing: Generic
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  string $content
		 * @param  string $shortcode
		 */
		public static function process_content( $content = '', $shortcode = '' ) {

			// Requirements check

				if ( empty( $content ) || empty( $shortcode ) ) {
					return '';
				}


			// Helper variables

				$run = apply_filters( 'wmhook_shortcode_process_content_run', array(
					'do_shortcode' => array(
						'accordion',
						'button',
						'call_to_action',
						'column',
						'content_module',
						'item',
						'list',
						'marker',
						'message',
						'posts',
						'price',
						'pricing_table',
						'progress',
						'pullquote',
						'row',
						'separator_heading',
						'tabs',
						// Visual Composer support
						'vc_row',
						'vc_row_inner',
						'vc_column',
						'vc_column_inner',
					),
					'inline_tags_only' => array(
						'progress',
					),
					'wpautop_no_br' => array(
						'item',
					),
					'wpautop_shortcodes' => array(
						'text_block',
					),
				) );


			// Processing

				if (
					isset( $run['do_shortcode'] )
					&& in_array( $shortcode, (array) $run['do_shortcode'] )
				) {
					$content = do_shortcode( $content );
				}

				if (
					isset( $run['inline_tags_only'] )
					&& in_array( $shortcode, (array) $run['inline_tags_only'] )
				) {
					$content = wp_kses( $content, self::get_inline_tags() );
				}

				if (
					isset( $run['wpautop_no_br'] )
					&& in_array( $shortcode, (array) $run['wpautop_no_br'] )
				) {
					$content = wpautop( $content, false );
				}

				if (
					isset( $run['wpautop_shortcodes'] )
					&& in_array( $shortcode, (array) $run['wpautop_shortcodes'] )
				) {
					$content = wpautop( preg_replace( '/<\/?p\>/', "\r\n", $content ) . "\r\n" );
					$content = do_shortcode( shortcode_unautop( $content ) );
				}


			// Output

				return $content;

		} // /process_content



		/**
		 * Shortcode content processing: [pre]
		 *
		 * @todo  Remove this shortcode.
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  string $content
		 */
		public static function process_content_pre( $content = '' ) {

			// Requirements check

				if ( empty( $content ) ) {
					return $content;
				}


			// Processing

					$content = str_replace(
						'[',
						'&#91;',
						$content
					);
					$content = str_replace(
						array( '<p>', '</p>', '<br />' ),
						'',
						$content
					);
					$content = esc_html( shortcode_unautop( $content ) );


			// Output

				return $content;

		} // /process_content_pre





	/**
	 * PLUGINS INTEGRATION
	 *
	 * @todo  This should go into `includes/compatibility/` folder!
	 */


		/**
		 * BEAVER BUILDER PLUGIN
		 */

			/**
			 * Add Beaver Builder plugin support
			 *
			 * @link  https://www.wpbeaverbuilder.com/
			 *
			 * Using 7, 8 and 9 position to hook the Beaver Builder support.
			 * If you intend to change these positions, change the numbers
			 * but keep the order.
			 *
			 * @since    1.1.0
			 * @version  1.5.0
			 */
			public static function beaver_builder_support() {

				// Requirements check

					if (
						! class_exists( 'FLBuilder' )
						|| (
							is_admin()
							&& (
								! isset( $_REQUEST['page'] )
								|| ! in_array( $_REQUEST['page'], array( 'fl-builder-settings', 'fl-builder-multisite-settings' ) )
								// @todo
								// This is also used in BB in `classes/class-fl-builder-admin-settings.php`.
								// However, I think we can do better if we try harder.
							)
						)
					) {
						return;
					}


				// Processing

					add_action( 'init', __CLASS__ . '::init_beaver_builder_support', 7 );

			} // /beaver_builder_support



			/**
			 * Add Beaver Builder plugin support init
			 *
			 * @since    1.1.0
			 * @version  1.5.0
			 */
			public static function init_beaver_builder_support() {

				// Processing

					require_once WMAMP_INCLUDES_DIR . 'shortcodes/page-builder/beaver-builder/beaver-builder.php';

			} // /init_beaver_builder_support



		/**
		 * VISUAL COMPOSER PLUGIN
		 */

			/**
			 * Add Visual Composer plugin support
			 *
			 * @link  http://vc.wpbakery.com/
			 *
			 * @since    1.0.0
			 * @version  1.5.0
			 */
			public static function visual_composer_support() {
				//VC 4+ disabling Frontend Editor
					if ( function_exists( 'vc_disable_frontend' ) ) {
						vc_disable_frontend();
					}

				//VC additional shortcodes admin interface
					$vc_shortcodes_admin_tweaks = apply_filters( 'wmhook_shortcode_' . 'vc_shortcodes_admin_tweaks_file',
					require_once WMAMP_INCLUDES_DIR . 'shortcodes/page-builder/visual-composer/visual-composer.php' );
					require_once( $vc_shortcodes_admin_tweaks );

				//VC setup screen modifications
					add_filter( 'vc_settings_tabs', __CLASS__ . '::visual_composer_setup' );
					delete_option( 'wpb_js_use_custom' );

				//Disable VC Guide Tour
					if ( function_exists( 'vc_editor_post_types' ) ) {
						foreach ( vc_editor_post_types() as $post_type ) {
							add_filter( 'vc_ui-pointers-' . $post_type, '__return_empty_array', 999 );
						}
					}

				//VC extending shortcode parameters
					vc_add_shortcode_param( 'wm_radio', __CLASS__ . '::visual_composer_custom_field_wm_radio' );

				//Remove default VC elements (only if current theme supports this)
					if (
							function_exists( 'vc_remove_element' )
							&& ( wma_supports_subfeature( 'remove_vc_shortcodes' ) || wma_supports_subfeature( 'remove-vc-shortcodes' ) )
							&& class_exists( 'WPBMap' )
						) {

						$vc_shortcodes_all  = array_keys( WPBMap::getShortCodes() );
						$vc_shortcodes_keep = array(
								//rows
									'vc_row',
									'vc_row_inner',
								//columns
									'vc_column',
									'vc_column_inner',
								//others
									'vc_raw_html',
									'vc_raw_js',
								//3rd party plugins support (check http://vc.wpbakery.com/features/content-elements/)
									'contact-form-7',
									'gravityform',
									'layerslider_vc',
									'rev_slider_vc',
							);

						// Do not remove custom mapped shortcodes via WP admin

							if (
									class_exists( 'Vc_Automap_Model' )
									&& is_callable( 'Vc_Automap_Model::findAll' )
								) {

								$vc_shortcodes_custom = Vc_Automap_Model::findAll();

								foreach ( $vc_shortcodes_custom as $shortcode ) {
									$vc_shortcodes_keep[] = $shortcode->tag;
								}

							}

						$vc_shortcodes_keep   = apply_filters( 'wmhook_shortcode_' . 'vc_keep', $vc_shortcodes_keep );
						$vc_shortcodes_remove = apply_filters( 'wmhook_shortcode_' . 'vc_remove', array_diff( $vc_shortcodes_all, $vc_shortcodes_keep ) );

						//Array check required due to filter applied above
							if ( is_array( $vc_shortcodes_remove ) && ! empty( $vc_shortcodes_remove ) ) {
								foreach ( $vc_shortcodes_remove as $shortcode ) {
									vc_remove_element( $shortcode );
								}
							}

					}

				//Add custom VC elements
					$vc_shortcodes = self::get_definitions_processed( 'vc_plugin' );
					if (
							function_exists( 'vc_map' )
							&& ! empty( $vc_shortcodes )
						) {
						ksort( $vc_shortcodes );
						foreach ( $vc_shortcodes as $shortcode ) {
							//simple validation (as of http://kb.wpbakery.com/index.php?title=Vc_map, the below 2 parameters are required)
								if ( ! isset( $shortcode['name'] ) || ! isset( $shortcode['base'] ) ) {
									continue;
								}
							//sort shortcode parameters array
								if ( isset( $shortcode['params'] ) ) {
									ksort( $shortcode['params'] );
								}

							// Fix required for Visual Composer 4.5.2+

								$shortcode['params'] = array_values( $shortcode['params'] );

							vc_map( $shortcode );
						}
					}
			} // /visual_composer_support



			/**
			 * Modify Visual Composer plugin settings page
			 *
			 * http://vc.wpbakery.com/
			 *
			 * @since    1.0.0
			 * @version  1.5.0
			 *
			 * @param  array $tabs
			 */
			public static function visual_composer_setup( $tabs = array() ) {
				$tabs_original = $tabs;

				unset( $tabs['color'] );
				unset( $tabs['vc-color'] );
				unset( $tabs['element_css'] );
				unset( $tabs['custom_css'] );
				unset( $tabs['vc-custom_css'] );

				return apply_filters( 'wmhook_shortcode_' . 'vc_setup' . '_output', $tabs, $tabs_original );
			} // /visual_composer_setup



			/**
			 * Visual Composer custom shortcode parameter - radio buttons
			 *
			 * @link  http://kb.wpbakery.com/index.php?title=Visual_Composer_Tutorial_Create_New_Param
			 *
			 * @since    1.0.0
			 * @version  1.5.0
			 *
			 * @param  array  $settings Array of settings parameters
			 * @param  string $value
			 */
			public static function visual_composer_custom_field_wm_radio( $settings, $value ) {

				// Helper variables

					$name  = $settings['param_name'];
					$field = $settings;

					$field['options'] = $field['value'];


				// Output

					return apply_filters( 'wmhook_shortcode_' . 'vc_custom_field_' . 'wm_radio' . '_output', wma_custom_field_wm_radio( $name, $value, $field ), $name, $value, $field );

			} // /visual_composer_custom_field_wm_radio





	/**
	 * SHORTCODES RENDERER
	 */

		/**
		 * Render the shortcode
		 *
		 * Outputs string of shortcode HTML.
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  array  $atts       Shortcode attributes.
		 * @param  string $content    Content of the shortcode.
		 * @param  string $shortcode  WordPress passes also the name of the shortcode here.
		 */
		public static function shortcode_render( $atts = array(), $content = '', $shortcode = '' ) {

			// Requirements check

				$prefix_shortcode = self::$prefix_shortcode;
				$shortcode        = trim( str_replace( $prefix_shortcode, '', $shortcode ) );

				if ( empty( $shortcode ) ) {
					return;
				}


			// Helper variables

				$codes_globals = self::get_codes_globals();

				$output = (string) apply_filters( 'wmhook_shortcode_' . $shortcode, '', $atts, $content, $codes_globals );


			// Processing

				// Premature output

					if ( $output ) {
						return $output;
					}

				// Is this alias shortcode (with custom renderer file)?

					$custom_render_shortcodes = self::get_definitions_processed( 'renderer' );

					$path_folder = self::get_path_renderers();
					$path_file   = $path_folder . $shortcode . '.php';

					if ( isset( $custom_render_shortcodes[ $shortcode ] ) ) {
						$custom_render_code = $custom_render_shortcodes[ $shortcode ];

						// Use default alias renderer file

							if (
								isset( $custom_render_code['alias'] )
								&& $custom_render_code['alias']
							) {
								$path_file = $path_folder . trim( $custom_render_code['alias'] ) . '.php';
							}

						// Use custom renderer file instead

							if (
								isset( $custom_render_code['path'] )
								&& $custom_render_code['path']
							) {
								$path_file = trim( $custom_render_code['path'] );
							}

						// Use custom shortcode prefix (even empty)

							if ( isset( $custom_render_code['custom_prefix'] ) ) {
								$prefix_shortcode = trim( $custom_render_code['custom_prefix'] );
							}

					}

					$path_file = apply_filters( 'wmhook_shortcode_renderer_path', $path_file, $shortcode );

				// The shortcode file contains `$output` variable

					/**
					 * @todo  Use PHP buffer instead.
					 * @todo  But keep `include()` below as we are passing some variables.
					 */
					if ( file_exists( $path_file ) ) {
						include( $path_file );
					}

					$output = apply_filters( 'wmhook_shortcode_output', $output, $shortcode, $atts );


			// Output

				return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );

		} // /shortcode_render





	/**
	 * 100) Getters
	 */

		/**
		 * Get shortcodes definitions array from file
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_definitions_from_file() {

			// Helper variables

				$shortcode_definitions = array();

				$file = apply_filters( 'wmhook_shortcode_definitions_path', WMAMP_INCLUDES_DIR . 'shortcodes/definitions/definitions.php' );


			// Processing

				if ( file_exists( $file ) ) {
					/**
					 * This file has to contain a `$shortcode_definitions` defined
					 * so we can override the above default with actual shortcodes
					 * definitions array.
					 */
					include_once( $file );
				}


			// Output

				return (array) $shortcode_definitions;

		} // /get_definitions_from_file



		/**
		 * Get filtered shortcodes definitions array
		 *
		 * @since    1.1.0
		 * @version  1.5.0
		 */
		public static function get_definitions() {

			// Output

				return (array) apply_filters( 'wmhook_shortcode_definitions', self::$definitions );

		} // /get_definitions



		/**
		 * Shortcodes globals setup
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 *
		 * @param  string $scope  White processed shortcodes definitions to get.
		 */
		public static function get_definitions_processed( $scope = '' ) {

			// Helper variables

				$definitions = (array) self::get_definitions();
				$output      = array(
					'bb_plugin'       => array(),
					'generator'       => array(),
					'generator_short' => array(),
					'global'          => array(),
					'preprocess'      => array(),
					'renderer'        => array(),
					'styles'          => array(),
					'vc_plugin'       => array(),
				);


			// Processing

				foreach ( $definitions as $code => $definition ) {

					// Shortcode prefix may change for each shortcode down the way...

						$prefix_shortcode = self::$prefix_shortcode;

					// Skip this shortcode definition processing?

						// Shortcode requires a specific post type?

							if (
								isset( $definition['post_type_required'] )
								&& ! in_array( $definition['post_type_required'], get_post_types() )
							) {
								continue;
							}

						// Shortcode version supported by the theme?

							if (
								isset( $definition['since'] )
								&& version_compare(
									apply_filters( 'wmhook_shortcode_supported_version', WMAMP_VERSION ),
									$definition['since'],
									'<'
								)
							) {
								continue;
							}

					// For global processing (all except [pre] and [raw])

						if ( ! in_array( $code, array( 'pre', 'raw' ) ) ) {

							if ( isset( $definition['custom_prefix'] ) ) {

								$output['global'][] = array(
									'name'          => $code,
									'custom_prefix' => $definition['custom_prefix'],
								);
								$prefix_shortcode = $definition['custom_prefix'];

							} else {

								$output['global'][] = $code;

							}

						}

					// Preprocessing needed?

						if (
							isset( $definition['preprocess'] )
							&& $definition['preprocess']
						) {
							$output['preprocess'][] = $code;
						}

					// Is this an alias (rendering override)?

						if (
							isset( $definition['renderer'] )
							&& $definition['renderer']
						) {

							$output['renderer'][ $code ] = $definition['renderer'];

							if ( isset( $definition['custom_prefix'] ) ) {
								$output['renderer'][ $code ]['custom_prefix'] = $definition['custom_prefix'];
							}

						}

					// For Shortcode Generator

						if (
							isset( $definition['generator'] )
							&& $definition['generator']
							&& isset( $definition['generator']['name'] )
							&& isset( $definition['generator']['code'] )
						) {

							$definition['generator']['class'] = 'generator_item_' . $code;
							$definition['generator']['code']  = str_replace(
								'PREFIX_',
								$prefix_shortcode,
								$definition['generator']['code']
							);

							$output['generator'][$code] = $definition['generator'];

							// Display in short, simplified Shortcode Generator?

								if (
									isset( $definition['generator']['short'] )
									&& $definition['generator']['short']
								) {
									$output['generator_short'][$code] = $definition['generator'];
								}

						}

					// For Beaver Builder

						if (
							isset( $definition['bb_plugin'] )
							&& ! empty( $definition['bb_plugin'] )
						) {

							$definition['bb_plugin']['output'] = str_replace(
								'PREFIX_',
								$prefix_shortcode,
								$definition['bb_plugin']['output']
							);

							if ( isset( $definition['bb_plugin']['output_children'] ) ) {
								$definition['bb_plugin']['output_children'] = str_replace(
									'PREFIX_',
									$prefix_shortcode,
									$definition['bb_plugin']['output_children']
								);
							}

							$output['bb_plugin'][$code] = $definition['bb_plugin'];

						}

					// For Visual Composer

						if (
								wma_is_active_vc()
								&& isset( $definition['vc_plugin'] )
								&& ! empty( $definition['vc_plugin'] )
								&& isset( $definition['vc_plugin']['name'] ) //Required parameter by the Visual Composer plugin
								&& isset( $definition['vc_plugin']['base'] ) //Required parameter by the Visual Composer plugin
							) {
							$output['vc_plugin'][$code] = $definition['vc_plugin'];
						}

				} // /foreach

				$output = (array) apply_filters( 'wmhook_shortcode_definitions_processed', $output );


			// Output

				if ( ! empty( $scope ) ) {
					if ( isset( $output[ $scope ] ) ) {
						return $output[ $scope ];
					} else {
						return array();
					}
				} else {
					return $output;
				}

		} // /get_definitions_processed



		/**
		 * Get globals array
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_codes_globals() {

			// Helper variables

				$post_types = self::get_post_types();
				$icons      = self::get_icons();


			// Processing

				$codes_globals = array(

					'colors' => array(
						'blue'   => esc_html__( 'Blue', 'webman-amplifier' ),
						'gray'   => esc_html__( 'Gray', 'webman-amplifier' ),
						'green'  => esc_html__( 'Green', 'webman-amplifier' ),
						'orange' => esc_html__( 'Orange', 'webman-amplifier' ),
						'red'    => esc_html__( 'Red', 'webman-amplifier' ),
					),

					'column_widths' => array(
						'1/2',
						'1/3',
						'2/3',
						'1/4',
						'3/4',
						'1/5',
						'2/5',
						'3/5',
						'4/5',
					),

					'divider_appearance'  => array(
						'line'        => esc_html__( 'Line', 'webman-amplifier' ),
						'dotted'      => esc_html__( 'Dotted', 'webman-amplifier' ),
						'dashed'      => esc_html__( 'Dashed', 'webman-amplifier' ),
						'double-line' => esc_html__( 'Double line', 'webman-amplifier' ),
						'whitespace'  => esc_html__( 'Whitespace', 'webman-amplifier' ),
					),

					'dropcap_shapes' => array(
						'circle'         => esc_html__( 'Circle', 'webman-amplifier' ),
						'square'         => esc_html__( 'Square', 'webman-amplifier' ),
						'rounded-square' => esc_html__( 'Rounded square', 'webman-amplifier' ),
						'leaf-left'      => esc_html__( 'Leaf left', 'webman-amplifier' ),
						'leaf-right'     => esc_html__( 'Leaf right', 'webman-amplifier' ),
						'half-circle'    => esc_html__( 'Half circle', 'webman-amplifier' ),
					),

					'font_icons' => $icons,

					'post_types' => $post_types,

					'sizes' => array(

						// Readable (for select dropdown, for example)

							'options' => array(
								's'  => esc_html__( 'Small', 'webman-amplifier' ),
								'm'  => esc_html__( 'Medium', 'webman-amplifier' ),
								'l'  => esc_html__( 'Large', 'webman-amplifier' ),
								'xl' => esc_html__( 'Extra-large', 'webman-amplifier' ),
							),

						// Value to CSS class translator

							'values' =>	array(
								's'  => 'small',
								'm'  => 'medium',
								'l'  => 'large',
								'xl' => 'extra-large',
							),

						),

					'social_icons' => array(
						'Behance',
						'Blogger',
						'Delicious',
						'DeviantART',
						'Digg',
						'Dribbble',
						'Facebook',
						'Flickr',
						'Forrst',
						'Github',
						'Google+',
						'Instagram',
						'LinkedIn',
						'MySpace',
						'Pinterest',
						'Reddit',
						'RSS',
						'Skype',
						'SoundCloud',
						'StumbleUpon',
						'Tumblr',
						'Twitter',
						'Vimeo',
						'WordPress',
						'YouTube',
					),

					'table_appearance' => array(
						'basic'            => esc_html__( 'Basic', 'webman-amplifier' ),
						'bordered'         => esc_html__( 'Bordered', 'webman-amplifier' ),
						'striped'          => esc_html__( 'Zebra striping', 'webman-amplifier' ),
						'bordered-striped' => esc_html__( 'Bordered zebra striping', 'webman-amplifier' ),
					),

				);


			// Output

				return (array) apply_filters( 'wmhook_shortcode_codes_globals', $codes_globals, $post_types, $icons );

		} // /get_codes_globals



		/**
		 * Get supported post types array
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_post_types() {

			// Helper variables

				$registered_post_types = get_post_types( array(), 'objects' );

				$post_types = array_intersect( array(
					'post',
					'wm_logos',
					'wm_projects',
					'wm_staff',
				), array_keys( $registered_post_types ) );


			// Processing

				foreach ( $post_types as $key => $post_type ) {
					$labels = get_post_type_labels( $registered_post_types[ $post_type ] );
					$post_types[ $post_type ] = $labels->name;
					unset( $post_types[ $key ] );
				}

				asort( $post_types );


			// Output

				return (array) apply_filters( 'wmhook_shortcode_post_types', $post_types );

		} // /get_post_types



		/**
		 * Get array of font icons
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_icons() {

			// Helper variables

				$icons = get_option( 'wmamp-icons' );


			// Processing

				if ( isset( $icons['icons_select'] ) ) {
					$icons = array_merge(
						array( '' => '' ),
						$icons['icons_select']
					);
				} else {
					$icons = array();
				}


			// Output

				return (array) apply_filters( 'wmhook_shortcode_icons', $icons );

		} // /get_icons



		/**
		 * Get path: To shortcode render files
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_path_renderers() {

			// Output

				return trailingslashit( apply_filters( 'wmhook_shortcode_renderers_dir', WMAMP_INCLUDES_DIR . 'shortcodes/renderers' ) );

		} // /get_path_renderers



		/**
		 * Get allowed inline HTML tags
		 *
		 * Outputs array of allowed tags and their attributes for `wp_kses()` use.
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_inline_tags() {

			// Helper variables

				$tags = array(

					'a' => array(
						'class' => array(),
						'href'  => array(),
						'rel'   => array(),
						'title' => array(),
					),

					'abbr' => array(
						'title' => array(),
					),

					'b' => array(),

					'br' => array(
						'class' => array(),
					),

					'code' => array(),

					'del' => array(
						'datetime' => array(),
						'title' => array(),
					),

					'em' => array(),

					'i' => array(),

					'img' => array(
						'alt'    => array(),
						'class'  => array(),
						'height' => array(),
						'src'    => array(),
						'width'  => array(),
					),

					'mark' => array(
						'class' => array(),
					),

					'q' => array(
						'cite' => array(),
						'title' => array(),
					),

					'small' => array(
						'class' => array(),
					),

					'span' => array(
						'class' => array(),
						'title' => array(),
						'style' => array(),
					),

					'strike' => array(),

					'strong' => array(),

					'u' => array(),

				);


			// Output

				return (array) apply_filters( 'wmhook_shortcode_inline_tags', $tags );

		} // /get_inline_tags





} // /WM_Shortcodes





/**
 * WM_Shortcodes helper functions
 *
 * @since    1.0.9.8
 * @version  1.4.11
 */

	/**
	 * Shortcode enqueue scripts
	 *
	 * @since    1.0.9.8
	 * @version  1.4.11
	 *
	 * @param  string $shortcode
	 * @param  array  $enqueue_scripts
	 * @param  array  $atts
	 */
	if ( ! function_exists( 'wma_shortcode_enqueue_scripts' ) ) {
		function wma_shortcode_enqueue_scripts( $shortcode = '', $enqueue_scripts = array(), $atts = array() ) {

			// Helper variables

				$enqueue_scripts = array_filter( (array) apply_filters( 'wmhook_shortcode_' . $shortcode . '_enqueue_scripts', $enqueue_scripts, $atts ) );


			// Requirements check

				if (
						! $shortcode
						|| empty( $enqueue_scripts )
					) {
					return;
				}


			// Processing

				// Fixing legacy theme compatibility (@todo Remove when themes are updated)

					if ( in_array( 'slick', $enqueue_scripts ) ) {
						$enqueue_scripts = array_merge( $enqueue_scripts, array(
							'wm-shortcodes-posts-slick'
						) );
					}

				// Enqueue scripts

					foreach ( $enqueue_scripts as $script_name ) {
						wp_enqueue_script( $script_name );
					}

				/**
				 * Using this action hook will remove all the previously added shortcode scripts
				 * @todo  Find out why this happens
				 */
				do_action( 'wmhook_shortcode_' . $shortcode . '_do_enqueue_scripts', $atts );

		}
	} // /wma_shortcode_enqueue_scripts



	/**
	 * Custom page builder input fields
	 */

		/**
		 * Custom page builder input field: wm_radio
		 *
		 * @since    1.1
		 * @version  1.2.8
		 *
		 * @param  string $name
		 * @param  string $value
		 * @param  array  $field
		 */
		function wma_custom_field_wm_radio( $name, $value, $field ) {

			// Pre

				$pre = apply_filters( 'wmhook_wmamp_fn_wma_custom_field_wm_radio_pre', false, $name, $value, $field );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = $block_class = '';

				$i = 0;

				if ( ! isset( $field['custom'] ) || ! $field['custom'] ) {
					$field['custom'] = '';
				} else {
					$block_class .= ' custom-label';
				}

				$class = ( isset( $field['hide_radio'] ) && $field['hide_radio'] && isset( $field['custom'] ) && $field['custom'] ) ? ( ' hide' ) : ( '' );

				// Adding field class required in Visual Composer

					if ( wma_is_active_vc() ) {
						$class .= ' wpb_vc_param_value';
					}

				$field['inline'] = ( isset( $field['inline'] ) && $field['inline'] ) ? ( true ) : ( false );

				if ( isset( $field['filter'] ) && $field['filter'] ) {
					$field['filter'] = true;
					$block_class .= ' filterable';
				} else {
					$field['filter'] = false;
				}


			// Processing

				$output = '<div class="fl-wm-radio wm-radio-block' . esc_attr( $block_class ) . '">';

				// Filter

					if ( $field['filter'] ) {
						$output .= '<div class="filter"><input type="text" value="" placeholder="' . esc_attr__( 'Filter: start typing...', 'webman-amplifier' ) . '" class="filter-text" /></div>';
					}

				// Radio buttons

					$output .= '<div class="radio-items">';

						foreach ( $field['options'] as $option_value => $option ) {

							$i++;

							$output .= ( ! $field['inline'] ) ? ( '<p class="input-item radio-item"' ) : ( '<span class="inline-radio input-item radio-item"' );
							$output .= ' data-value="' . esc_attr( $option_value ) . '">';

							$checked = trim( checked( $value, $option_value, false ) . ' /' );

							if ( ! isset( $field['custom'] ) || ! $field['custom'] ) {

								$output .= '<input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name . '-' . $i ) . '" value="' . esc_attr( $option_value ) . '" title="' . esc_attr( $option ) . '" class="wm-radio' . esc_attr( $class ) . '" ' . $checked . '> ';

								$output .= '<label for="' . esc_attr( $name . '-' . $i ) . '">' . $option . '</label>';

							} else {

								$output .= '<label for="' . esc_attr( $name . '-' . $i ) . '">' . trim( str_replace(
										array( '{{value}}', '{{name}}' ),
										array( $option_value, $option ),
										$field['custom']
									) ) . '</label>';

								$output .= '<input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name . '-' . $i ) . '" value="' . esc_attr( $option_value ) . '" title="' . esc_attr( $option ) . '" class="wm-radio' . esc_attr( $class ) . '" ' . $checked . '>';

							}

							$output .= ( ! $field['inline'] ) ? ( '</p>' ) : ( '</span> ' );

						} // /foreach

					$output .= '</div>';

					// JavaScript

						$output .= '<script>jQuery( function() {';

							// Add "active" class to radio button items if custom label is used

								$output .= "
									jQuery( '.wm-radio-block.custom-label .radio-item' )
										.find( 'input' )
											.on( 'change', function() {

												jQuery( this )
													.parent( '.inline-radio' )
														.addClass( 'active' )
														.siblings( '.inline-radio' )
															.removeClass( 'active' );

											} )
										.end()
										.find( 'input:checked' )
											.parent( '.inline-radio' )
												.addClass( 'active' );
									";

							// Radio buttons filtering

								if ( $field['filter'] ) {

									$output .= "
										jQuery( '.wm-radio-block.filterable .filter-text' )
											.on( 'keyup', function() {

												var search = jQuery( this ),
												    text   = search.val();

												search
													.closest( '.filterable' )
													.find( '.radio-item' )
														.each( function() {

															var item  = jQuery( this ),
															    value = item.data( 'value' ).replace( 'icon', '' );

															if ( -1 == value.indexOf( text ) ) {
																item.hide();
															} else {
																item.show();
															}

														} );

											} );
										";

								}

						$output .= '} );</script>';

				$output .= '</div>';


			// Output

				return $output;

		} // /wma_custom_field_wm_radio





/**
 * Additional Visual Composer requirements
 *
 * @todo  This should go into `includes/compatibility/` folder!
 *
 * @since    1.0
 * @version  1.4
 */
if ( wma_is_active_vc() ) {

	/**
	 * Customize vc_row shortcode output
	 *
	 * Making the output the same as wm_row shortcode.
	 *
	 * @link  http://kb.wpbakery.com/index.php?title=Extend_Visual_Composer
	 *
	 * @param  array  $atts
	 * @param  string $content
	 */
	function vc_theme_vc_row( $atts, $content = '', $shortcode = '' ) {
		//Helper variables
			if ( ! $shortcode ) {
				$shortcode = 'vc_row';
			}

		//Allow plugins/themes to override the default shortcode template
			$output = apply_filters( 'wmhook_shortcode_' . $shortcode, '', $atts, $content );
			if ( $output ) {
				return $output;
			}

		//Render the shortcode
			$renderer_file_dir  = apply_filters( 'wmhook_shortcode_' . 'renderers_dir', trailingslashit( WMAMP_INCLUDES_DIR . 'shortcodes/renderers' ) );
			$renderer_file_path = apply_filters( 'wmhook_shortcode_' . 'renderer_path', $renderer_file_dir . 'row.php', $shortcode );
			if ( file_exists( $renderer_file_path ) ) {
				$prefix_shortcode = 'wm_';
				include( $renderer_file_path );
			}

		//Output
			//general filter to process the output of all shortcodes
			$output = apply_filters( 'wmhook_shortcode_' . 'output', $output, $shortcode, $atts );
			//filter to process the specific shortcode output ($atts are validated already)
			return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );
	} // /vc_theme_vc_row



	/**
	 * Customize vc_row_inner shortcode output
	 *
	 * Making the output the same as wm_row shortcode.
	 *
	 * @link  http://kb.wpbakery.com/index.php?title=Extend_Visual_Composer
	 *
	 * @param  array  $atts
	 * @param  string $content
	 */
	function vc_theme_vc_row_inner( $atts, $content = '' ) {
		return vc_theme_vc_row( $atts, $content, 'vc_row_inner' );
	} // /vc_theme_vc_row_inner



	/**
	 * Customize vc_column shortcode output
	 *
	 * Making the output the same as wm_column shortcode.
	 *
	 * @link  http://kb.wpbakery.com/index.php?title=Extend_Visual_Composer
	 *
	 * @param  array  $atts
	 * @param  string $content
	 */
	function vc_theme_vc_column( $atts, $content = '', $shortcode = '' ) {
		//Helper variables
			if ( ! $shortcode ) {
				$shortcode = 'vc_column';
			}

		//Allow plugins/themes to override the default shortcode template
			$output = apply_filters( 'wmhook_shortcode_' . $shortcode, '', $atts, $content );
			if ( $output ) {
				return $output;
			}

		//Render the shortcode
			$renderer_file_dir  = apply_filters( 'wmhook_shortcode_' . 'renderers_dir', trailingslashit( WMAMP_INCLUDES_DIR . 'shortcodes/renderers' ) );
			$renderer_file_path = apply_filters( 'wmhook_shortcode_' . 'renderer_path', $renderer_file_dir . 'column.php', $shortcode );
			if ( file_exists( $renderer_file_path ) ) {
				$prefix_shortcode = 'wm_';
				include( $renderer_file_path );
			}

		//Output
			//general filter to process the output of all shortcodes
			$output = apply_filters( 'wmhook_shortcode_' . 'output', $output, $shortcode, $atts );
			//filter to process the specific shortcode output ($atts are validated already)
			return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );
	} // /vc_theme_vc_column



	/**
	 * Customize vc_column_inner shortcode output
	 *
	 * Making the output the same as wm_column shortcode.
	 *
	 * @link  http://kb.wpbakery.com/index.php?title=Extend_Visual_Composer
	 *
	 * @param  array  $atts
	 * @param  string $content
	 */
	function vc_theme_vc_column_inner( $atts, $content = '' ) {
		return vc_theme_vc_column( $atts, $content, 'vc_column_inner' );
	} // /vc_theme_vc_column_inner

} // /wma_is_active_vc() check
