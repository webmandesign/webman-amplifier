<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder plugin compatibility class
 *
 * Making shortcodes work as Beaver Builder elements/modules.
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
 *  20) Forms
 *  30) Shortcodes generator
 *  40) Assets
 * 100) Getters
 */
class WM_Amplifier_Beaver_Builder {





	/**
	 * 0) Init
	 */

		private static $instance;

		public static $definitions = array();



		/**
		 * Constructor
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		private function __construct() {

			// Requirements check

				if (
					! class_exists( 'FLBuilder' )
					|| (
						is_admin()
						&& (
							/**
							 * Run this plugin compatibility code in admin area on Beaver Builder admin setup pages only,
							 * so our custom shortcodes/modules are displayed in admin modules list and can be disabled.
							 * This is used in Beaver Builder code in `classes/class-fl-builder-admin-settings.php`.
							 *
							 * @todo  Try to improve this.
							 */
							! isset( $_REQUEST['page'] )
							|| ! in_array( $_REQUEST['page'], array( 'fl-builder-settings', 'fl-builder-multisite-settings' ) )
						)
					)
				) {
					return;
				}


			// Processing

				// Hooks

					// Actions

						/**
						 * @todo  Document plugin priority.
						 *
						 * Using priority of `WM_Shortcodes(5) < FLBuilder` to hook the plugin compatibility setup.
						 */
						add_action( 'init', __CLASS__ . '::register_modules', 8 );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets_enqueue' );

						add_action( 'wmhook_amplifier_beaver_builder_module_frontend', __CLASS__ . '::render_module', 10, 2 );

						add_action( 'wmhook_amplifier_beaver_builder_module_frontend_js', __CLASS__ . '::module_frontend_js', 10, 2 );

						add_action( 'fl_builder_control_' . 'wm_radio', __CLASS__ . '::form_field_radio_custom_render', 10, 3 );

					// Filters

						// Low priority to allow later modifications (even with default filter priority, which is 10)
						add_filter( 'wmhook_shortcode_definitions', __CLASS__ . '::get_definitions_beaver_builder', 0 );

						add_filter( 'wmhook_shortcode_definitions_processed_code', __CLASS__ . '::set_definitions_processed', 10, 4 );

						add_filter( 'wmhook_wmamp_generator_enable', __CLASS__ . '::shortcode_generator_enable' );

						add_filter( 'wmhook_wmamp_generator_short_enable', __CLASS__ . '::shortcode_generator_short_enable' );

						add_filter( 'fl_builder_upgrade_url', __CLASS__ . '::upgrade_url' );

						add_filter( 'fl_builder_module_custom_class', __CLASS__ . '::wrapper_css_class', 10, 2 );

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
		 * Register shortcodes as Beaver Builder modules
		 *
		 * @todo  Maybe also use `FLBuilder::register_module_alias()` to separate [posts] shortcode per post type?
		 *
		 * @since    1.1.0
		 * @version  1.6.0
		 */
		public static function register_modules() {

			// Helper variables

				$definitions = (array) self::get_definitions_processed( 'all' );
				$file_path   = WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/modules/';


			// Processing

				/**
				 * Load the module registration helper class first.
				 */
				require_once WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/class-beaver-builder-register-module.php';

				/**
				 * Now load each module registration.
				 */
				foreach ( $definitions as $module => $args ) {
					$file = $file_path . WM_Shortcodes::$prefix_shortcode . $module . '.php';

					if ( file_exists( $file ) ) {
						require_once $file;
					}
				}

		} // /register_modules



		/**
		 * Output the module
		 *
		 * @since    1.1.0
		 * @version  1.6.0
		 *
		 * @param  object $module    Current module object.
		 * @param  array  $settings  Settings passed from module form.
		 */
		public static function render_module( $module, $settings = array() ) {

			// Requirements check

				if ( ! isset( $module->slug ) ) {
					return;
				}


			// Helper variables

				$output = $replace_children = '';

				$module = substr( $module->slug, strlen( WM_Shortcodes::$prefix_shortcode ) );
				$args   = self::get_definitions_processed( $module );

				$output_partial = array(
					'parent' => (string) $args['output'],
					'child'  => (string) $args['output_children'],
				);

				$params = array(
					'parent' => (array) $args['params'],
					'child'  => (array) $args['params_children'],
				);

				$children = ( isset( $settings->children ) ) ? ( array_filter( $settings->children ) ) : ( false );


			// Processing

				// Parent

					foreach ( $params['parent'] as $param ) {

						$replace = '';
						$param   = trim( $param );

						if ( $param ) {

							if ( isset( $settings->$param ) && ! empty( $settings->$param ) ) {
								$value = $settings->$param;
								if ( is_array( $value ) ) {
									$value = implode( ',', $value );
								}

								$replace = ( 'content' === $param ) ? ( $value ) : ( ' ' . $param . '="' . $value . '"' );
							}

							$output_partial['parent'] = str_replace(
								'{{' . $param . '}}',
								$replace,
								$output_partial['parent']
							);

						}

					} // /foreach

				// Children

					if (
						is_array( $children )
						&& ! empty( $children )
						&& ! empty( $params['child'] )
					) {
						foreach ( $children as $child ) {

							// Requirements check

								if (
									! is_object( $child )
									|| empty( $child )
								) {
									continue;
								}

							$replace_child = $output_partial['child'];

							foreach ( $params['child'] as $param ) {

								$replace = '';
								$param   = trim( $param );

								if ( $param ) {

									if ( isset( $child->$param ) && ! empty( $child->$param ) ) {
										$value = $child->$param;
										if ( is_array( $value ) ) {
											$value = implode( ',', $value );
										}

										$replace = ( 'content' === $param ) ? ( $value ) : ( ' ' . $param . '="' . $value . '"' );
									}

									$replace_child = str_replace(
										'{{' . $param . '}}',
										$replace,
										$replace_child
									);

								}

							} // /foreach

							$replace_children .= $replace_child;

						} // /foreach
					}

				// Set module output

					$output = str_replace(
						array(
							'{{children}}',
							'{{items}}',
						),
						$replace_children,
						$output_partial['parent']
					);


			// Output

				echo apply_filters( 'wmhook_amplifier_beaver_builder_render_module_output', $output, $module, $settings );

		} // /render_module



		/**
		 * Remove custom module CSS classes on module wrapper
		 *
		 * @since    1.1.1
		 * @version  1.6.0
		 *
		 * @param  string $class   CSS class applied on module node wrapper.
		 * @param  object $module  Module node object.
		 */
		public static function wrapper_css_class( $class, $module ) {

			// Helper variables

				$definitions = array_keys( (array) self::get_definitions_processed( 'all' ) );


			// Processing

				if ( in_array( $module->settings->type, $definitions ) ) {
					$class = '';
				}


			// Output

				return $class;

		} // /wrapper_css_class



		/**
		 * Shortcodes definitions processing
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

			// Helper variables

				// Backwards compatibility

					if (
						! isset( $definition['compatibility/beaver-builder'] )
						&& isset( $definition['bb_plugin'] )
					) {
						$definition['compatibility/beaver-builder'] = $definition['bb_plugin'];
					}


			// Processing

				if ( isset( $definition['compatibility/beaver-builder'] ) && ! empty( $definition['compatibility/beaver-builder'] ) ) {

					// Apply shortcode prefix on module output

						if ( isset( $definition['compatibility/beaver-builder']['output'] ) ) {
							$definition['compatibility/beaver-builder']['output'] = str_replace(
								'PREFIX_',
								$prefix_shortcode,
								$definition['compatibility/beaver-builder']['output']
							);
						}

						if ( isset( $definition['compatibility/beaver-builder']['output_children'] ) ) {
							$definition['compatibility/beaver-builder']['output_children'] = str_replace(
								'PREFIX_',
								$prefix_shortcode,
								$definition['compatibility/beaver-builder']['output_children']
							);
						}

					$output['compatibility/beaver-builder'][ $code ] = $definition['compatibility/beaver-builder'];

				}


			// Output

				return $output;

		} // /set_definitions_processed



		/**
		 * Upgrade link URL
		 *
		 * @since    1.1.6
		 * @version  1.6.0
		 *
		 * @param  string $url
		 */
		public static function upgrade_url( $url ) {

			// Output

				return esc_url( add_query_arg( 'fla', '67', $url ) );

		} // /upgrade_url





	/**
	 * 20) Forms
	 */

		/**
		 * Render custom page builder input field: `wm_radio`
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  string $name
		 * @param  string $value
		 * @param  array  $field
		 */
		public static function form_field_radio_custom_render( $name, $value, $field ) {

			// Output

				echo WM_Amplifier_Page_Builder::form_field_radio_custom_render( $name, $value, $field, 'beaver-builder' );

		} // /form_field_radio_custom_render





	/**
	 * 30) Shortcodes generator
	 */

		/**
		 * Enable full shortcode generator?
		 *
		 * By default the shortcode generator is only added on admin pages, as that's
		 * where TinyMCE is loaded, anyway. But we need to load the shortcode generator
		 * in Beaver Builder editor, which is on frontend.
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  boolean $enable
		 */
		public static function shortcode_generator_enable( $enable ) {

			// Processing

				if (
					! is_admin()
					&& self::is_active()
				) {
					$enable = true;
				}


			// Output

				return $enable;

		} // /shortcode_generator_enable



		/**
		 * Enable short, simplified shortcode generator?
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  boolean $enable
		 */
		public static function shortcode_generator_short_enable( $enable ) {

			// Helper variables

				$supported_post_types = (array) get_option( '_fl_builder_post_types' );
				if ( empty( $supported_post_types ) ) {
					$supported_post_types = array( 'page' );
				}


			// Processing

				if (
					! is_admin()
					&& is_singular()
					&& in_array( get_post_type(), $supported_post_types )
				) {
					$enable = true;
				}


			// Output

				return $enable;

		} // /shortcode_generator_short_enable





	/**
	 * 40) Assets
	 */

		/**
		 * Enqueue frontend styles and scripts
		 *
		 * @since    1.1.0
		 * @version  1.6.0
		 */
		public static function assets_enqueue() {

			// Requirements check

				if ( ! self::is_active() ) {
					return;
				}


			// Processing

				// Styles

					wp_enqueue_style(
						'wm-radio',
						WMAMP_ASSETS_URL . 'css/input-wm-radio.css',
						array(),
						WMAMP_VERSION,
						'screen'
					);

					wp_enqueue_style(
						'wm-shortcodes-bb-addon',
						WMAMP_ASSETS_URL . 'css/shortcodes-bb-addons.css',
						array(),
						WMAMP_VERSION,
						'screen'
					);

		} // /assets_enqueue



		/**
		 * Enqueue frontend styles and scripts
		 *
		 * @since    1.3.15
		 * @version  1.6.0
		 *
		 * @param  object $module    Current module object.
		 * @param  array  $settings  Settings passed from module form.
		 */
		public static function module_frontend_js( $module, $settings = array() ) {

			// Requirements check

				if (
					! self::is_active()
					|| ! isset( $module->slug )
					|| ! isset( $module->node )
				) {
					return;
				}


			// Helper variables

				$output = '';

				$node     = $module->node;
				$settings = (array) $settings;
				$module   = str_replace( WM_Shortcodes::$prefix_shortcode, '', $module->slug );


			// Processing

				switch ( $module ) {

					case 'accordion':
							$output = "WmampAccordion( '.fl-node-{{node}} .wm-accordion' );";
						break;

					case 'content_module':
					case 'posts':
					case 'testimonials':

						// Isotope

							if ( isset( $settings['filter'] ) && $settings['filter'] ) {
								$output = "if ( typeof WmampIsotope == 'function' ) { WmampIsotope( '.fl-node-{{node}} .filter-this' ); }";
							}

						// Masonry

							if ( isset( $settings['class'] ) && false !== strpos( $settings['class'], 'masonry' ) ) {
								$output = "if ( typeof WmampMasonry == 'function' ) { WmampMasonry( '.fl-node-{{node}} .masonry-this' ); }";
							}

						// Slick

							if ( isset( $settings['scroll'] ) && $settings['scroll'] ) {
								if ( version_compare( apply_filters( 'wmhook_shortcode_supported_version', WMAMP_VERSION ), '1.3', '<' ) ) {
									$output = "if ( typeof WmampOwl == 'function' ) { WmampOwl( '.fl-node-{{node}} [class*=\"scrollable-\"]' ); }";
								} else {
									$output = "if ( typeof WmampSlick == 'function' ) { WmampSlick( '.fl-node-{{node}} [class*=\"scrollable-\"]' ); }";
								}
							}

						break;

					case 'tabs':
							$output = "if ( typeof WmampTabs == 'function' ) { WmampTabs( '.fl-node-{{node}} .wm-tabs' ); }";
						break;

					default:
						break;

				} // /switch

				$output = trim( (string) $output );


			// Output

				if ( $output ) {
					echo 'jQuery( function() { ' . str_replace( '{{node}}', $node, $output ) . ' } );';
				}

		} // /module_frontend_js






	/**
	 * 100) Getters
	 */

		/**
		 * Check if page builder is active
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		public static function is_active() {

			// Output

				return (bool) apply_filters( 'wmhook_amplifier_beaver_builder_is_active', ( is_callable( 'FLBuilderModel::is_builder_active' ) && FLBuilderModel::is_builder_active() ) );

		} // /is_active



		/**
		 * Get Beaver Builder module definitions from file
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  array $definitions
		 */
		public static function get_definitions_beaver_builder( $definitions = array() ) {

			// Helper variables

				$file = (string) apply_filters( 'wmhook_amplifier_beaver_builder_definitions_path', WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/definitions/definitions.php' );

			// Processing

				if ( file_exists( $file ) ) {
					/**
					 * This file has to contain a `$definitions` defined.
					 */
					include_once( $file );
				}


			// Output

				return (array) $definitions;

		} // /get_definitions_beaver_builder



		/**
		 * Get shortcode definitions processed
		 *
		 * @uses  WM_Shortcodes::get_definitions_processed()
		 *
		 * @since    1.1.0
		 * @version  1.6.0
		 *
		 * @param  string $shortcode
		 * @param  string $property
		 */
		public static function get_definitions_processed( $shortcode = 'all', $property = '' ) {

			// Requirements check

				if ( empty( $shortcode ) ) {
					return null;
				}


			// Helper variables

				if ( empty( self::$definitions ) ) {
					// Cache Beaver Builder module definitions array
					self::$definitions = (array) WM_Shortcodes::get_definitions_processed( 'compatibility/beaver-builder' );
				}


			// Processing

				if ( 'all' === $shortcode ) {

					$output = self::$definitions;

				} elseif ( isset( self::$definitions[ $shortcode ] ) ) {

					$output = wp_parse_args( self::$definitions[ $shortcode ], array(
						'name'            => '-',
						'description'     => '',
						'category'        => esc_html_x( 'Theme Modules', 'Page builder modules category name.', 'webman-amplifier' ),
						'enabled'         => true,
						'editor_export'   => true, // Export content to WP editor after BB plugin uninstall?
						'dir'             => WMAMP_INCLUDES_DIR . 'compatibility/beaver-builder/modules/',
						'url'             => WMAMP_INCLUDES_URL . 'compatibility/beaver-builder/modules/',
						'partial_refresh' => true,
						'output'          => '',
						'output_children' => '',
						'params'          => array(),
						'params_children' => array(),
						'form'            => array(),
						'form_children'   => array(),
					) );

					// Apply prefix on module name

						if ( apply_filters( 'wmhook_amplifier_beaver_builder_get_definitions_force_name_prefix', true ) ) {
							$output['name'] = WM_Shortcodes::$prefix_shortcode_name . str_replace(
								WM_Shortcodes::$prefix_shortcode_name,
								'',
								$output['name']
							);
						}

					// Put all module registration values into a single array

						$output['register'] = array(
							'name'            => $output['name'],
							'description'     => $output['description'],
							'category'        => $output['category'],
							'enabled'         => $output['enabled'],
							'editor_export'   => $output['editor_export'],
							'dir'             => $output['dir'],
							'url'             => $output['url'],
							'partial_refresh' => $output['partial_refresh'],
						);

				}

				// Filter the output array before retrieving a single property value

					$output = (array) apply_filters( 'wmhook_amplifier_beaver_builder_get_definitions_array', $output, $shortcode, $property );

				// Single property value requested?

					if ( $property ) {
						if ( isset( $output[ $property ] ) ) {
							$output = $output[ $property ];
						} else {
							$output = null;
						}
					}


			// Output

				/**
				 * We do not force particular output type as it could be one of these: array, string, null.
				 */
				return apply_filters( 'wmhook_amplifier_beaver_builder_get_definitions', $output, $shortcode, $property );

		} // /get_definitions_processed





} // /WM_Amplifier_Beaver_Builder

// Load just after WM_Shortcodes()
add_action( 'init', 'WM_Amplifier_Beaver_Builder::init', 6 );
