<?php
/**
 * WebMan Shortcodes class
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
		 * @version  1.6.0
		 */
		private function __construct() {

			// Processing

				// Setup

					// Cache shortcode definitions array
					self::$definitions = self::get_definitions_from_file();

				// Hooks

					// Actions

						// Has to be hooked earlier than `wp_enqueue_scripts` action for shortcodes to use registered script.
						add_action( 'init', __CLASS__ . '::assets_register', 998 );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets_enqueue' );

					// Filters

						add_filter( 'the_content',            __CLASS__ . '::preprocess_shortcodes', 7 );
						add_filter( 'wmhook_content_filters', __CLASS__ . '::preprocess_shortcodes', 7 );
						add_filter( 'widget_text',            __CLASS__ . '::preprocess_shortcodes', 7 );

						add_filter( 'wmhook_shortcode_preprocess_shortcodes_output', 'do_shortcode' );

						add_filter( 'the_content', __CLASS__ . '::fix_shortcodes' );

						add_filter( 'wmhook_shortcode_output', __CLASS__ . '::shortcode_kses', 99, 2 );

						// Process shortcodes `$content`

							add_filter( 'wmhook_shortcode__content', __CLASS__ . '::process_content', 20, 2 );

							// [list]
							add_filter( 'wmhook_shortcode_list_content', 'shortcode_unautop', 10 );

							// [widget_area]
							add_filter( 'wmhook_shortcode_widget_area_output', 'wma_minify_html', 10 );

				// Register shortcodes in WordPress

					self::add_shortcodes();

				// Shortcodes loaded

					do_action( 'wmhook_shortcodes_loaded' );

				// Plugins compatibility

					// Beaver Builder plugin integration.
					self::beaver_builder_support();

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
	 * 10) Add & render shortcodes
	 */

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

				$prefix_shortcode = self::$prefix_shortcode; // Used inside shortcode renderer file.
				$shortcode        = trim( str_replace( $prefix_shortcode, '', $shortcode ) );

				if ( empty( $shortcode ) ) {
					return;
				}


			// Helper variables

				$codes_globals = self::get_codes_globals(); // Used inside shortcode renderer file.

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

					if ( file_exists( $path_file ) ) {
						include( $path_file );
					}

					$output = apply_filters( 'wmhook_shortcode_output', $output, $shortcode, $atts );


			// Output

				return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $output, $atts );

		} // /shortcode_render





	/**
	 * 20) Shortcode output modifications
	 */

		/**
		 * Shortcode content processing: Generic
		 *
		 * @since    1.0.0
		 * @version  1.6.0
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

				$run = (array) apply_filters( 'wmhook_shortcode_process_content_run', array(

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
					$content = wp_kses( $content, WMA_KSES::$prefix . 'inline' );
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
					$content = preg_replace( '/<\/?p\>/', "\r\n", $content );
					$content = wpautop( $content . "\r\n" );
					$content = do_shortcode( shortcode_unautop( $content ) );
				}


			// Output

				return $content;

		} // /process_content



		/**
		 * Content fixes for shortcodes
		 *
		 * Fixes HTML issues created by wpautop.
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  string $content
		 */
		public static function fix_shortcodes( $content = '' ) {

			// Helper variables

				$fix = array(
					'<p>['    => '[',
					']</p>'   => ']',
					']<br />' => ']',
					']<br>'   => ']'
				);


			// Output

				return (string) apply_filters( 'wmhook_shortcode_fix_shortcodes_output', strtr( $content, $fix ) );

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
		 * KSES for shortcode output
		 *
		 * @since  1.6.0
		 *
		 * @param  string $data       Post content to filter.
		 * @param  string $shortcode  Shortcode being processed.
		 *
		 * @return  string  Filtered post content with allowed HTML tags and attributes intact.
		 */
		public static function shortcode_kses( string $data, string $shortcode = '' ): string {

			// Output

				if ( in_array( $shortcode, array( 'search_form', 'widget_area' ) ) ) {
					return wp_kses( $data, WMA_KSES::$prefix . 'post+form' );
				} else {
					return wp_kses( $data, WMA_KSES::$prefix . 'post' );
				}

		} // /shortcode_kses





	/**
	 * 30) Assets
	 */

		/**
		 * Register styles and scripts
		 *
		 * @since    1.0.0
		 * @version  1.6.0
		 */
		public static function assets_register() {

			// Processing

				// Styles

					// Page builders related.
					$register_assets = array(
						'wm-radio'               => array( WMAMP_ASSETS_URL . 'css/input-wm-radio.css' ),
						'wm-shortcodes-bb-addon' => array( WMAMP_ASSETS_URL . 'css/shortcodes-bb-addons.css' ),
					);

					foreach ( $register_assets as $handle => $atts ) {

						$src   = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
						$deps  = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( false );
						$ver   = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( WMAMP_VERSION );
						$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'screen' );

						wp_register_style( $handle, $src, $deps, $ver, $media );

					} // /foreach

				// Scripts

					$register_assets = array(
						'isotope'                             => array( 'src' => WMAMP_ASSETS_URL . 'js/plugins/isotope.pkgd.min.js', 'deps' => array() ),
						'jquery-lwtCountdown'                 => array( WMAMP_ASSETS_URL . 'js/plugins/jquery.lwtCountdown.min.js' ),
						'jquery-owlcarousel'                  => array( WMAMP_ASSETS_URL . 'js/plugins/owl.carousel.min.js' ),
						'jquery-parallax'                     => array( WMAMP_ASSETS_URL . 'js/plugins/jquery.parallax.min.js' ),
						'slick'                               => array( WMAMP_ASSETS_URL . 'js/plugins/slick.min.js' ),
						'wm-shortcodes-accordion'             => array( WMAMP_ASSETS_URL . 'js/shortcode-accordion.js' ),
						'wm-shortcodes-parallax'              => array( 'src' => WMAMP_ASSETS_URL . 'js/shortcode-parallax.js', 'deps' => array( 'jquery', 'jquery-parallax' ) ),
						'wm-shortcodes-posts-isotope'         => array( 'src' => WMAMP_ASSETS_URL . 'js/shortcode-posts-isotope.js', 'deps' => array( 'jquery', 'imagesloaded' ) ),
						'wm-shortcodes-posts-masonry'         => array( 'src' => WMAMP_ASSETS_URL . 'js/shortcode-posts-masonry.js', 'deps' => array( 'jquery', 'imagesloaded' ) ),
						'wm-shortcodes-posts-owlcarousel'     => array( 'src' => WMAMP_ASSETS_URL . 'js/shortcode-posts-owlcarousel.js', 'deps' => array( 'jquery', 'imagesloaded' ) ),
						'wm-shortcodes-posts-slick'           => array( 'src' => WMAMP_ASSETS_URL . 'js/shortcode-posts-slick.js', 'deps' => array( 'jquery', 'imagesloaded' ) ),
						'wm-shortcodes-slideshow-owlcarousel' => array( WMAMP_ASSETS_URL . 'js/shortcode-slideshow-owlcarousel.js' ),
						'wm-shortcodes-tabs'                  => array( WMAMP_ASSETS_URL . 'js/shortcode-tabs.js' ),

						// Page builders related.
						'wm-shortcodes-custom-field-wm_radio' => array( WMAMP_ASSETS_URL . 'js/shortcodes--field--wm_radio.js' ),
					);

					foreach ( $register_assets as $handle => $atts ) {

						$src       = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
						$deps      = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( array( 'jquery' ) );
						$ver       = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( WMAMP_VERSION );
						$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true );

						wp_register_script( $handle, $src, $deps, $ver, $in_footer );

					} // /foreach

				// Allow hooking for deregistering

					do_action( 'wmhook_shortcode_assets_registered' );

		} // /assets_register



		/**
		 * Enqueue frontend styles and scripts
		 *
		 * @since    1.0.0
		 * @version  1.6.0
		 */
		public static function assets_enqueue() {

			// Processing

				// Styles

					if ( apply_filters( 'wmhook_shortcode_iconfont_url', get_option( 'wmamp-icon-font' ) ) ) {
						wp_enqueue_style( 'wm-fonticons' );
					}

				// Allow hooking for dequeuing

					do_action( 'wmhook_shortcode_assets_enqueued' );

		} // /assets_enqueue



		/**
		 * Enqueue scripts specific for the shortcode
		 *
		 * This method is actually called inside shortcode renderer file.
		 * The scripts are being enqueued only when shortcode is displayed.
		 *
		 * @since    1.0.9.8
		 * @version  1.5.0
		 *
		 * @param  string $shortcode
		 * @param  array  $scripts
		 * @param  array  $atts
		 */
		public static function enqueue_scripts( $shortcode = '', $scripts = array(), $atts = array() ) {

			// Helper variables

				$scripts = array_filter( (array) apply_filters( 'wmhook_shortcode_' . $shortcode . '_enqueue_scripts', $scripts, $atts ) );


			// Requirements check

				if (
					empty( $shortcode )
					|| empty( $scripts )
				) {
					return;
				}


			// Processing

				/**
				 * @todo  Remove when all themes are updated.
				 */
				// Fixing legacy theme compatibility

					if ( in_array( 'slick', $scripts ) ) {
						$scripts = array_merge( $scripts, array(
							'wm-shortcodes-posts-slick',
						) );
					}

				// Enqueue scripts

					foreach ( $scripts as $script_name ) {
						wp_enqueue_script( $script_name );
					}

				/**
				 * Using this action hook will remove all the previously added shortcode scripts.
				 *
				 * @todo  Find out why this happens...
				 */
				do_action( 'wmhook_shortcode_' . $shortcode . '_do_enqueue_scripts', $atts );

		} // /enqueue_scripts





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

				$definitions = array();

				$file = (string) apply_filters( 'wmhook_shortcode_definitions_path', WMAMP_INCLUDES_DIR . 'shortcodes/definitions/definitions.php' );


			// Processing

				if ( file_exists( $file ) ) {
					/**
					 * This file has to contain a `$definitions` defined
					 * so we can override the above default with actual shortcodes
					 * definitions array.
					 */
					include_once( $file );
				}


			// Output

				return (array) $definitions;

		} // /get_definitions_from_file



		/**
		 * Get filtered shortcodes definitions array
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 */
		public static function get_definitions_filtered() {

			// Output

				return (array) apply_filters( 'wmhook_shortcode_definitions', self::$definitions );

		} // /get_definitions_filtered



		/**
		 * Shortcodes globals setup
		 *
		 * @since    1.5.0
		 * @version  1.6.0
		 *
		 * @param  string $scope  White processed shortcodes definitions to get.
		 */
		public static function get_definitions_processed( $scope = '' ) {

			// Helper variables

				$definitions = (array) self::get_definitions_filtered();
				$output      = array(
					'bb_plugin'       => array(),
					'generator'       => array(),
					'generator_short' => array(),
					'global'          => array(),
					'preprocess'      => array(),
					'renderer'        => array(),
					'styles'          => array(),
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

					// For global processing (all except [pre] and [raw] - as of version 1.6.0 there are no [pre] and [raw] shortcodes)

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

					'heading_tags' => array(
						''   => esc_html_x( 'Default', 'Default HTML heading tag value.', 'webman-amplifier' ),
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),

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
		 * @version  1.6.0
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
					$post_types[ $post_type ] = get_post_type_object( $post_type )->label;
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
	 * 200) Plugins compatibility
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
			 * @version  1.6.0
			 */
			public static function beaver_builder_support() {

				// Requirements check

					if (
						! class_exists( 'FLBuilder' )
						|| (
							is_admin()
							&& (
								// This check is also used in BB in `classes/class-fl-builder-admin-settings.php`.
								! isset( $_REQUEST['page'] ) // phpcs:ignore
								|| ! in_array( $_REQUEST['page'], array( 'fl-builder-settings', 'fl-builder-multisite-settings' ) ) // phpcs:ignore
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





} // /WM_Shortcodes

WM_Shortcodes::init();





/**
 * Page builders
 */

	/**
	 * Custom page builder input fields
	 */

		/**
		 * Custom page builder input field: wm_radio
		 *
		 * @since    1.1
		 * @version  1.6.0
		 *
		 * @param  string $name
		 * @param  string $value
		 * @param  array  $field
		 */
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
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
						$output .=
							'<div class="filter">'
							. '<input
								type="text"
								value=""
								placeholder="' . esc_attr__( 'Filter: start typing...', 'webman-amplifier' ) . '"
								class="filter-text"
								/>'
							. '</div>';
					}

					// Radio buttons
					$output .= '<div class="radio-items">';
					foreach ( $field['options'] as $option_value => $option ) {

						$i++;

						$output .= ( ! $field['inline'] ) ? ( '<p class="input-item radio-item"' ) : ( '<span class="inline-radio input-item radio-item"' );
						$output .= ' data-value="' . esc_attr( $option_value ) . '">';

						$checked = trim( checked( $value, $option_value, false ) . ' /' );

						if ( ! isset( $field['custom'] ) || ! $field['custom'] ) {

							$output .=
								'<input
									type="radio"
									name="' . esc_attr( $name ) . '"
									id="' . esc_attr( $name . '-' . $i ) . '"
									value="' . esc_attr( $option_value ) . '"
									title="' . esc_attr( $option ) . '"
									class="wm-radio' . esc_attr( $class ) . '" '
									. $checked
									. '> ';

							$output .=
								'<label for="' . esc_attr( $name . '-' . $i ) . '">'
								. $option
								. '</label>';

						} else {

							$output .=
								'<label for="' . esc_attr( $name . '-' . $i ) . '">'
								. trim( str_replace(
									array( '{{value}}', '{{name}}' ),
									array( $option_value, $option ),
									$field['custom']
								) )
								. '</label>';

							$output .=
								'<input
									type="radio"
									name="' . esc_attr( $name ) . '"
									id="' . esc_attr( $name . '-' . $i ) . '"
									value="' . esc_attr( $option_value ) . '"
									title="' . esc_attr( $option ) . '"
									class="wm-radio' . esc_attr( $class ) . '" '
									. $checked
									. '>';
						}

						$output .= ( ! $field['inline'] ) ? ( '</p>' ) : ( '</span> ' );
					}
					$output .= '</div>';

					/**
					 * @todo
					 * IMPORTANT: JavaScript required!
					 * When using `wma_custom_field_wm_radio()` function, don't forget to enqueue
					 * required JavaScript too: `wp_enqueue_script( 'wm-shortcodes-custom-field-wm_radio' );`.
					 */

				$output .= '</div>';


			// Output

				return $output;

		} // /wma_custom_field_wm_radio
