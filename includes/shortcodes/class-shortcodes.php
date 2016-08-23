<?php
/**
 * WebMan Shortcodes
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * WebMan Shortcodes Class
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.3.15
 */
if ( ! class_exists( 'WM_Shortcodes' ) ) {

	class WM_Shortcodes {

		/**
		 * VARIABLES DEFINITION
		 */

			/**
			 * @var  array
			 */
			private static $codes = array();

			/**
			 * @var  array Various attribute defaults used across multiple shortcodes
			 */
			private static $codes_globals = array();

			/**
			 * @var  string Allowed inline HTML tags (in Accordion title for example)
			 */
			private $inline_tags = '';

			/**
			 * @var  string Path to shortcode renderers
			 */
			private $renderers_dir = '';

			/**
			 * @var  string Shortcode name prefix (if required, for example inside Visual Composer plugin)
			 */
			private $prefix_shortcode_name = '';

			/**
			 * @var  string Shortcode code prefix
			 */
			private $prefix_shortcode = 'wm_';

			/**
			 * @var  string Editor user capability
			 */
			private $editor_capability = '';

			/**
			 * @var  object
			 */
			protected static $instance;





		/**
		 * INITIALIZATION FUNCTIONS
		 */

			/**
			 * Constructor
			 *
			 * @since    1.0
			 * @version  1.3.4
			 * @access   public
			 */
			public function __construct() {

				$this->setup_globals();
				$this->setup_filters();
				$this->add_shortcodes();

				// Beaver Builder plugin integration

					$this->beaver_builder_support();

				// Visual Composer plugin integration

					if ( wma_is_active_vc() ) {
						$this->visual_composer_support();
					}

			} // /__construct



			/**
			 * Return an instance of the class
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @return  object A single instance of this class.
			 */
			public static function instance() {
				if ( ! isset( self::$instance ) ) {
					self::$instance = new WM_Shortcodes;
				}
				return self::$instance;
			} // /instance



			/**
			 * Shortcodes globals setup
			 *
			 * @since    1.0
			 * @version  1.2.2
			 *
			 * @access  private
			 */
			private function setup_globals() {
				//Helper variables
					$postTypes = get_post_types(); //get all post types to check if the shortcode should be added
					$fonticons = get_option( 'wmamp-icons' );
					if ( isset( $fonticons['icons_select'] ) ) {
						$fonticons = array_merge( array( '' => '' ), $fonticons['icons_select'] );
					} else {
						$fonticons = array();
					}
					$post_types = array( 'post' => __( 'Posts', 'webman-amplifier' ) );
					if ( in_array( 'wm_logos', $postTypes ) ) {
						$post_types['wm_logos'] = __( 'Logos', 'webman-amplifier' );
					}
					if ( in_array( 'wm_projects', $postTypes ) ) {
						$post_types['wm_projects'] = __( 'Projects', 'webman-amplifier' );
					}
					if ( in_array( 'wm_staff', $postTypes ) ) {
						$post_types['wm_staff'] = __( 'Staff', 'webman-amplifier' );
					}
					$post_types = apply_filters( 'wmhook_shortcode_' . 'post_types', $post_types );
					asort( $post_types );

				//Editor user capability
					$this->editor_capability = apply_filters( 'wmhook_wmamp_' . 'editor_capability', 'edit_posts' );

				//Paths and URLs
					$this->definitions_dir  = apply_filters( 'wmhook_shortcode_' . 'definitions_dir', trailingslashit( WMAMP_INCLUDES_DIR . 'shortcodes/definitions' ) );
					$this->renderers_dir    = apply_filters( 'wmhook_shortcode_' . 'renderers_dir',   trailingslashit( WMAMP_INCLUDES_DIR . 'shortcodes/renderers' ) );
					$this->page_builder_dir = apply_filters( 'wmhook_shortcode_' . 'vc_addons_dir',   trailingslashit( WMAMP_INCLUDES_DIR . 'shortcodes/page-builder' ) );

				//Visual Composer integration
					if ( ! ( wma_supports_subfeature( 'remove_vc_shortcodes' ) || wma_supports_subfeature( 'remove-vc-shortcodes' ) ) ) {
						$this->prefix_shortcode_name = apply_filters( 'wmhook_shortcode_' . 'prefix_name', 'WM ' );
					}

				//Shortcodes globals (variables used across multiple shortcodes)
					$this->inline_tags   = apply_filters( 'wmhook_shortcode_' . 'inline_tags',   '<a><abbr><b><br><code><em><i><img><mark><small><span><strong><u>' );
					self::$codes_globals = apply_filters( 'wmhook_shortcode_' . 'codes_globals', array(
							'colors' => array(
									'blue'   => __( 'Blue', 'webman-amplifier' ),
									'gray'   => __( 'Gray', 'webman-amplifier' ),
									'green'  => __( 'Green', 'webman-amplifier' ),
									'orange' => __( 'Orange', 'webman-amplifier' ),
									'red'    => __( 'Red', 'webman-amplifier' ),
								),
							'column_widths' => array( '1/2', '1/3', '2/3', '1/4', '3/4', '1/5', '2/5', '3/5', '4/5' ),
							'divider_appearance'  => array(
									'line'        => __( 'Line', 'webman-amplifier' ),
									'dotted'      => __( 'Dotted', 'webman-amplifier' ),
									'dashed'      => __( 'Dashed', 'webman-amplifier' ),
									'double-line' => __( 'Double line', 'webman-amplifier' ),
									'whitespace'  => __( 'Whitespace', 'webman-amplifier' ),
								),
							'dropcap_shapes' => array(
									'circle'         => __( 'Circle', 'webman-amplifier' ),
									'square'         => __( 'Square', 'webman-amplifier' ),
									'rounded-square' => __( 'Rounded square', 'webman-amplifier' ),
									'leaf-left'      => __( 'Leaf left', 'webman-amplifier' ),
									'leaf-right'     => __( 'Leaf right', 'webman-amplifier' ),
									'half-circle'    => __( 'Half circle', 'webman-amplifier' ),
								),
							'font_icons' => $fonticons,
							'post_types' => $post_types,
							'sizes' => array(
								//Actual sizes options used in select form field
									'options' => array(
										's'  => __( 'Small', 'webman-amplifier' ),
										'm'  => __( 'Medium', 'webman-amplifier' ),
										'l'  => __( 'Large', 'webman-amplifier' ),
										'xl' => __( 'Extra-large', 'webman-amplifier' ),
									),
								//Parameter value to CSS class translation
									'values' =>	array(
										's'  => 'small',
										'm'  => 'medium',
										'l'  => 'large',
										'xl' => 'extra-large',
									),
								),
							'social_icons' => array( 'Behance', 'Blogger', 'Delicious', 'DeviantART', 'Digg', 'Dribbble', 'Facebook', 'Flickr', 'Forrst', 'Github', 'Google+', 'Instagram', 'LinkedIn', 'MySpace', 'Pinterest', 'Reddit', 'RSS', 'Skype', 'SoundCloud', 'StumbleUpon', 'Tumblr', 'Twitter', 'Vimeo', 'WordPress', 'YouTube' ),
							'table_appearance' => array(
									'basic'            => __( 'Basic', 'webman-amplifier' ),
									'bordered'         => __( 'Bordered', 'webman-amplifier' ),
									'striped'          => __( 'Zebra striping', 'webman-amplifier' ),
									'bordered-striped' => __( 'Bordered zebra striping', 'webman-amplifier' ),
								),
						), $post_types, $fonticons );

				//Get shortcodes definitions array
					$definitions_file_path = apply_filters( 'wmhook_shortcode_' . 'definitions_path', $this->definitions_dir . 'definitions.php' );
					if ( file_exists( $definitions_file_path ) ) {
						include_once( $definitions_file_path );
					}

				//Define the shortcodes
					$codes = apply_filters( 'wmhook_shortcode_' . 'definitions', $shortcode_definitions );

				//Empty self::$codes variable before processing
					self::$codes = array(
							'generator'       => array(),
							'global'          => array(),
							'preprocess'      => array(),
							'renderer'        => array(),
							'styles'          => array(),
							'generator_short' => array(),
							'bb_plugin'       => array(),
							'vc_plugin'       => array(),
						);

				//Separate shortcodes into groups
					foreach ( (array) $codes as $code => $definition ) {

						$prefix_shortcode = $this->prefix_shortcode;

						//Skip the shortcode if the required post type is not supported in the theme
							if ( isset( $definition['post_type_required'] ) && trim( $definition['post_type_required'] ) && ! in_array( $definition['post_type_required'], $postTypes ) ) {
								continue;
							}

						//Check if shortcode supported by the theme
							if (
									isset( $definition['since'] )
									&& $definition['since']
									&& version_compare( apply_filters( 'wmhook_shortcode_' . 'supported_version', WMAMP_VERSION ), $definition['since'], '<' )
								) {
								continue;
							}

						//All shortcodes will be processed globally (except [pre] and [raw])
							if ( ! in_array( $code, array( 'pre', 'raw' ) ) ) {
								if (
										array_key_exists( 'custom_prefix', $definition )
										&& isset( $definition['custom_prefix'] )
									) {
									self::$codes['global'][] = array(
											'name'          => $code,
											'custom_prefix' => $definition['custom_prefix'],
										);
									$prefix_shortcode = $definition['custom_prefix'];
								} else {
									self::$codes['global'][] = $code;
								}
							}

						//Select only shortcodes that need preprocessing
							if ( isset( $definition['preprocess'] ) && $definition['preprocess'] ) {
								self::$codes['preprocess'][] = $code;
							}

						//Rendering overrides
							if ( isset( $definition['renderer'] ) && $definition['renderer'] ) {
								self::$codes['renderer'][ $code ] = $definition['renderer'];

								if (
										array_key_exists( 'custom_prefix', $definition )
										&& isset( $definition['custom_prefix'] )
									) {
									self::$codes['renderer'][ $code ]['custom_prefix'] = $definition['custom_prefix'];
								}
							}

						//Setting Shortcode Generator setup
							if (
									isset( $definition['generator'] ) && $definition['generator']
									&& isset( $definition['generator']['name'] )
									&& isset( $definition['generator']['code'] )
								) {
								$definition['generator']['class'] = 'generator_item_' . $code;
								$definition['generator']['code']  = str_replace( 'PREFIX_', $prefix_shortcode, $definition['generator']['code'] );
								self::$codes['generator'][$code]  = $definition['generator'];
								//Shortcodes in Shortcode Generator displayed in Visual Composer plugin
								if ( isset( $definition['generator']['short'] ) && $definition['generator']['short'] ) {
									self::$codes['generator_short'][$code] = $definition['generator'];
								}
							}

						//Beaver Builder integration
							if (
									isset( $definition['bb_plugin'] )
									&& is_array( $definition['bb_plugin'] ) && ! empty( $definition['bb_plugin'] )
								) {
								$definition['bb_plugin']['output'] = str_replace( 'PREFIX_', $prefix_shortcode, $definition['bb_plugin']['output'] );
								if ( isset( $definition['bb_plugin']['output_children'] ) ) {
									$definition['bb_plugin']['output_children'] = str_replace( 'PREFIX_', $prefix_shortcode, $definition['bb_plugin']['output_children'] );
								}

								self::$codes['bb_plugin'][$code] = $definition['bb_plugin'];
							}

						//Visual Composer plugin integration
							if (
									wma_is_active_vc()
									&& isset( $definition['vc_plugin'] )
									&& is_array( $definition['vc_plugin'] ) && ! empty( $definition['vc_plugin'] )
									&& isset( $definition['vc_plugin']['name'] ) && trim( $definition['vc_plugin']['name'] ) //"name" is required parameter by the Visual Composer plugin
									&& isset( $definition['vc_plugin']['base'] ) && trim( $definition['vc_plugin']['base'] ) //"base" is required parameter by the Visual Composer plugin
								) {
								self::$codes['vc_plugin'][$code] = $definition['vc_plugin'];
							}

					} // /foreach

				//Postprocess filters
					self::$codes = apply_filters( 'wmhook_shortcode_' . 'definitions_processed', self::$codes );
			} // /setup_globals



			/**
			 * Register styles and scripts
			 *
			 * @since    1.0
			 * @version  1.3.15
			 *
			 * @access   public
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
			 *
			 * @access  public
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
			 * @version  1.3.6
			 *
			 * @access  public
			 */
			public function assets_backend_vc() {

				// Requirements check

					if ( ! current_user_can( $this->editor_capability ) ) {
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
			 * @since    1.0
			 * @version  1.3.14
			 *
			 * @access  private
			 */
			public function setup_filters() {

				// Processing

					// Assets

						add_action( 'init', __CLASS__ . '::assets_register', 998 ); // Has to be hooked early for shortcodes to use the registered script  @todo  Use full enqueue script syntax in shortcodes script enqueuing.
						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets_frontend' );
						add_action( 'vc_backend_editor_enqueue_js_css', array( $this, 'assets_backend_vc' ) );

					// Shortcodes in text widget

						add_filter( 'widget_text', 'do_shortcode' );

					// Preprocess certain shortcodes

						add_filter( 'the_content',            array( $this, 'preprocess_shortcodes' ), 7 );
						add_filter( 'wmhook_content_filters', array( $this, 'preprocess_shortcodes' ), 7 );
						add_filter( 'widget_text',            array( $this, 'preprocess_shortcodes' ), 7 );

					// Fixes HTML issues created by wpautop

						add_filter( 'the_content', array( $this, 'fix_shortcodes' ) );

					// Shortcodes' $content variable filtering

						add_filter( 'wmhook_shortcode_' . '_content',          array( $this, 'shortcodes_content' ),     20, 2 );
						add_filter( 'wmhook_shortcode_' . 'pre' . '_content',  array( $this, 'shortcodes_content_pre' ), 10    );
						add_filter( 'wmhook_shortcode_' . 'list' . '_content', 'shortcode_unautop',                      10    );

					// Shortcodes' output filtering

						add_filter( 'wmhook_shortcode_' . 'widget_area' . '_output', 'wma_minify_html', 10 );

			} // /setup_filters



			/**
			 * Register shortcodes
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   array $shortcodes
			 */
			public function add_shortcodes( $shortcodes = array() ) {
				//If no shortcodes array set, use global shortcodes only
					if ( empty( $shortcodes ) ) {
						$shortcodes = (array) self::$codes['global'];
					}

				//If still no shortcodes to register, don't run the add_shortcode() function
					if ( ! empty( $shortcodes ) ) {
						foreach ( $shortcodes as $shortcode ) {
							//Helper variables
								$prefix_shortcode = $this->prefix_shortcode;

							//Modifying $prefix_shortcode if set
								if (
										is_array( $shortcode )
										&& array_key_exists( 'custom_prefix', $shortcode )
										&& isset( $shortcode['custom_prefix'] )
									) {
									$prefix_shortcode = $shortcode['custom_prefix'];
								}

							//Setting shortcode name
								if (
										is_array( $shortcode )
										&& array_key_exists( 'name', $shortcode )
										&& isset( $shortcode['name'] )
									) {
									$shortcode = $shortcode['name'];
								}

							add_shortcode( $prefix_shortcode . $shortcode, array( $this, 'shortcode_render' ) );
						}
					}
			} // /add_shortcodes





		/**
		 * VARIABLES ACCESS
		 */

			/**
			 * Get definitions array
			 *
			 * @since    1.1
			 * @version  1.1
			 *
			 * @access  public
			 */
			public function get_definitions() {
				return apply_filters( 'wmhook_shortcode_' . 'get_definitions', self::$codes );
			} // /get_definitions



			/**
			 * Get globals array
			 *
			 * @since    1.1
			 * @version  1.1
			 *
			 * @access  public
			 */
			public function get_globals() {
				return apply_filters( 'wmhook_shortcode_' . 'get_globals', self::$codes_globals );
			} // /get_definitions





		/**
		 * SHORTCODES OUTPUT MANIPULATION (FIXES)
		 */

			/**
			 * Content fixes for shortcodes
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   string $content Post/page content.
			 */
			public function fix_shortcodes( $content = '' ) {
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
			 * @since    1.0
			 * @version  1.0.9.6
			 * @access   public
			 *
			 * @param   string $content Post/page content.
			 */
			public function preprocess_shortcodes( $content = '' ) {
				//Helper variables
					$codes = (array) apply_filters( 'wmhook_shortcode_' . 'preprocess_shortcodes_array', self::$codes['preprocess'] );

				//If there is no shortcode to preprocess, do nothing
					if ( empty( $codes ) ) {
						return $content;
					}

				//Variables
					global $shortcode_tags;

				//Backup current registered shortcodes and clear them all out
					$shortcodesBackup = $shortcode_tags;
					remove_all_shortcodes();

				//Register shortcodes in preprocessing
					call_user_func_array( array( $this, 'add_shortcodes' ), array( $codes ) );

					do_action( 'wmhook_shortcode_' . 'preprocess_shortcodes', $codes, $content );

				//Do the preprocess shortcodes prematurely (in WordPress standards)
					$content = do_shortcode( $content );

				//Put the original shortcodes back
					$shortcode_tags = $shortcodesBackup;

				//Output
					return apply_filters( 'wmhook_shortcode_' . 'preprocess_shortcodes' . '_output', $content );
			} // /preprocess_shortcodes





		/**
		 * SHORTCODES' $content VARIABLE PROCESSING
		 */

			/**
			 * General processing
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   string $content
			 * @param   string $shortcode
			 */
			public function shortcodes_content( $content = '', $shortcode = '' ) {
				//Requirements check
					if (
							empty( $content )
							|| empty( $shortcode )
						) {
						return $content;
					}

				//Helper variables
					$codes = apply_filters( 'wmhook_shortcode_' . 'shortcodes_content_codes', array(
							'do_shortcode'       => array(
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
									//Visual Composer support
									'vc_row',
									'vc_row_inner',
									'vc_column',
									'vc_column_inner',
								),
							'strip_tags_inline'  => array(
									'progress',
								),
							'wpautop_no_br'      => array(
									'item',
								),
							'wpautop_shortcodes' => array(
									'text_block',
								),
						) );

				//Preparing output
					//do_shortcode()
						if (
								isset( $codes['do_shortcode'] )
								&& is_array( $codes['do_shortcode'] )
								&& ! empty( $codes['do_shortcode'] )
								&& in_array( $shortcode, $codes['do_shortcode'] )
							) {
							$content = do_shortcode( $content );
						}

					//strip_tags() (allow inline tags)
						if (
								isset( $codes['strip_tags_inline'] )
								&& is_array( $codes['strip_tags_inline'] )
								&& ! empty( $codes['strip_tags_inline'] )
								&& in_array( $shortcode, $codes['strip_tags_inline'] )
							) {
							$content = strip_tags( $content, $this->inline_tags );
						}

					//wpautop() (no <br /> tags)
						if (
								isset( $codes['wpautop_no_br'] )
								&& is_array( $codes['wpautop_no_br'] )
								&& ! empty( $codes['wpautop_no_br'] )
								&& in_array( $shortcode, $codes['wpautop_no_br'] )
							) {
							$content = wpautop( $content, false );
						}

					//correct shortcodes in wpautop()
						if (
								isset( $codes['wpautop_shortcodes'] )
								&& is_array( $codes['wpautop_shortcodes'] )
								&& ! empty( $codes['wpautop_shortcodes'] )
								&& in_array( $shortcode, $codes['wpautop_shortcodes'] )
							) {
							$content = wpautop( preg_replace( '/<\/?p\>/', "\r\n", $content ) . "\r\n" );
							$content = do_shortcode( shortcode_unautop( $content ) );
						}

				//Output
					return $content;
			} // /shortcodes_content



			/**
			 * [pre] shortcode
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   string $content
			 */
			public function shortcodes_content_pre( $content = '' ) {
				//Requirements check
					if ( empty( $content ) ) {
						return $content;
					}

				//Preparing output
						$content = str_replace( '[', '&#91;', $content );
						$content = str_replace( array( '<p>', '</p>', '<br />' ), '', $content );
						$content = esc_html( shortcode_unautop( $content ) );

				//Output
					return $content;
			} // /shortcodes_content_pre





		/**
		 * PLUGINS INTEGRATION
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
				 * @see  `$this->page_builder_dir . beaver-builder/beaver-builder.php` action hooks
				 *
				 * @since    1.1
				 * @version  1.1
				 *
				 * @access  public
				 */
				public function beaver_builder_support() {
					if ( class_exists( 'FLBuilder' ) && ! is_admin() ) {
						add_action( 'init', array( $this, 'init_beaver_builder_support' ), 7 );
					}
				} // /beaver_builder_support



				/**
				 * Add Beaver Builder plugin support init
				 *
				 * @since    1.1
				 * @version  1.1
				 *
				 * @access  public
				 */
				public function init_beaver_builder_support() {
					require_once( $this->page_builder_dir . 'beaver-builder/beaver-builder.php' );
				} // /init_beaver_builder_support



			/**
			 * VISUAL COMPOSER PLUGIN
			 */

				/**
				 * Add Visual Composer plugin support
				 *
				 * @link  texthttp://vc.wpbakery.com/
				 *
				 * @todo  Support for Frontend Editor (VC4+)
				 *
				 * @since    1.0
				 * @version  1.2.3
				 *
				 * @access  public
				 */
				public function visual_composer_support() {
					//VC 4+ disabling Frontend Editor
						if ( function_exists( 'vc_disable_frontend' ) ) {
							vc_disable_frontend();
						}

					//VC additional shortcodes admin interface
						$vc_shortcodes_admin_tweaks = apply_filters( 'wmhook_shortcode_' . 'vc_shortcodes_admin_tweaks_file', $this->page_builder_dir . 'visual-composer/visual-composer.php' );
						require_once( $vc_shortcodes_admin_tweaks );

					//VC setup screen modifications
						add_filter( 'vc_settings_tabs', array( $this, 'visual_composer_setup' ) );
						delete_option( 'wpb_js_use_custom' );

					//Disable VC Guide Tour
						if ( function_exists( 'vc_editor_post_types' ) ) {
							foreach ( vc_editor_post_types() as $post_type ) {
								add_filter( 'vc_ui-pointers-' . $post_type, '__return_empty_array', 999 );
							}
						}

					//VC extending shortcode parameters
						add_shortcode_param( 'wm_radio',  array( $this, 'visual_composer_custom_field_wm_radio' ) );

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
						if (
								function_exists( 'vc_map' )
								&& ! empty( self::$codes['vc_plugin'] )
							) {
							ksort( self::$codes['vc_plugin'] );
							foreach ( self::$codes['vc_plugin'] as $shortcode ) {
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
				 * @since    1.0
				 * @version  1.1.7
				 *
				 * @access  public
				 *
				 * @param  array $tabs
				 */
				public function visual_composer_setup( $tabs = array() ) {
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
				 * @link    http://kb.wpbakery.com/index.php?title=Visual_Composer_Tutorial_Create_New_Param
				 *
				 * @since    1.0
				 * @version  1.1
				 *
				 * @access  public
				 *
				 * @param  array  $settings Array of settings parameters
				 * @param  string $value
				 */
				public function visual_composer_custom_field_wm_radio( $settings, $value ) {
					//Helper variables
						$name = $settings['param_name'];

						$field = $settings;

						$field['options'] = $field['value'];

						$dependency = vc_generate_dependencies_attributes( $settings );

					//Output
						return apply_filters( 'wmhook_shortcode_' . 'vc_custom_field_' . 'wm_radio' . '_output', wma_custom_field_wm_radio( $name, $value, $field ), $name, $value, $field );
				} // /visual_composer_custom_field_wm_radio





		/**
		 * SHORTCODES RENDERER
		 */

			/**
			 * Shortcode renderer method
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   array  $atts      Shortcode attributes.
			 * @param   string $content   Content of the shortcode.
			 * @param   string $shortcode WordPress passes also the name of the shortcode here.
			 *
			 * @return  string HTML output of the shortcode.
			 */
			public function shortcode_render( $atts = array(), $content = '', $shortcode = '' ) {
				$prefix_shortcode = $this->prefix_shortcode;

				$shortcode = trim( str_replace( $prefix_shortcode, '', $shortcode ) );
				if ( ! $shortcode ) {
					return;
				}

				//Allow plugins/themes to override the default shortcode template
					$codes_globals = self::$codes_globals;
					$output        = apply_filters( 'wmhook_shortcode_' . $shortcode, '', $atts, $content, $codes_globals );
					if ( $output ) {
						return $output;
					}

				//Render the shortcode
					//Renderer overrides (can be used for shortcode aliases -> see definitions.php)
						$renderer_file_path = $this->renderers_dir . $shortcode . '.php';

						if (
								isset( self::$codes['renderer'][ $shortcode ] )
								&& self::$codes['renderer'][ $shortcode ]
							) {

							//Setting alias shortcode renderer
								if (
									isset( self::$codes['renderer'][ $shortcode ]['alias'] )
									&& self::$codes['renderer'][ $shortcode ]['alias']
								) {
									$renderer_file_path = $this->renderers_dir . trim( self::$codes['renderer'][ $shortcode ]['alias'] ) . '.php';
								}

							//Setting custom renderer file
								if (
									isset( self::$codes['renderer'][ $shortcode ]['path'] )
									&& self::$codes['renderer'][ $shortcode ]['path']
								) {
									$renderer_file_path = trim( self::$codes['renderer'][ $shortcode ]['path'] );
								}

							//Setting custom shortcode prefix
								if (
										array_key_exists( 'custom_prefix', self::$codes['renderer'][ $shortcode ] )
										&& isset( self::$codes['renderer'][ $shortcode ]['custom_prefix'] )
									) {
									$prefix_shortcode = trim( self::$codes['renderer'][ $shortcode ]['custom_prefix'] );
								}
						}

					$renderer_file_path = apply_filters( 'wmhook_shortcode_' . 'renderer_path', $renderer_file_path, $shortcode );

					if ( file_exists( $renderer_file_path ) ) {
						include( $renderer_file_path );
					}

				//Output
					//filter to process the output of shortcodes
					$output = apply_filters( 'wmhook_shortcode_' . 'output', $output, $shortcode, $atts );
					//filter to process the specific shortcode output ($atts are validated already)
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );
			} // /shortcode_render

	} // /WM_Shortcodes

} // /class WM_Shortcodes check



/**
 * Shortcodes instance
 *
 * @since    1.1
 * @version  1.1
 *
 * @return  WM_Shortcodes instance
 */
function wma_shortcodes() {
	return WM_Shortcodes::instance();
} // /wma_shortcodes





/**
 * WM_Shortcodes helper functions
 *
 * @since    1.0.9.8
 * @version  1.3.11
 */

	/**
	 * Shortcode enqueue scripts
	 *
	 * @since    1.0.9.8
	 * @version  1.3.11
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

						$enqueue_scripts = array(
								'slick',
								'wm-shortcodes-posts-slick'
							);

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
 * @since    1.0
 * @version  1.1.7
 */
if ( wma_is_active_vc() ) {

	/**
	 * Removing Visual Composer 4.4 "Grid Elements" custom post type
	 *
	 * @since    1.1
	 * @version  1.1.7
	 *
	 * @access  public
	 */
	if ( ! function_exists( 'wma_vc_custom_post_removal' ) ) {
		function wma_vc_custom_post_removal() {
			global $wp_post_types, $vc_teaser_box;

			if ( isset( $wp_post_types['vc_grid_item'] ) ) {

				unset( $wp_post_types['vc_grid_item'] );
				// remove_menu_page( 'edit.php?post_type=vc_grid_item' );

				if ( function_exists( 'vc_menu_page_build' ) ) {
					remove_action( 'vc_menu_page_build', 'vc_gitem_add_submenu_page' );
				}

				if ( isset( $vc_teaser_box ) && is_object( $vc_teaser_box ) ) {
					remove_action( 'admin_init', array( $vc_teaser_box, 'jsComposerEditPage' ), 6 );
				}

			}
		}
	} // /wma_vc_custom_post_removal

	add_action( 'init', 'wma_vc_custom_post_removal', 999 );



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
