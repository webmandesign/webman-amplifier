<?php
/**
 * WebMan Amplifier
 *
 * @package    WebMan Amplifier
 * @copyright  2015 WebMan - Oliver Juhas
 * @license    GPL-2.0+, http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @link  http://www.webmandesign.eu
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Main WM Apmlifier Class
 *
 * Contains the main functions for WebMan Amplifier.
 *
 * @package	 WebMan Amplifier
 * @author   WebMan
 *
 * @since    1.0
 * @version	 1.1.3
 */
if ( ! class_exists( 'WM_Amplifier' ) ) {

	class WM_Amplifier {

		/**
		 * VARIABLES DEFINITION
		 */

			/**
			 * @var  array
			 */
			public $errors = array();





		/**
		 * SINGLETON
		 */

			/**
			 * Main WebMan Amplifier Instance
			 *
			 * Please load it only one time.
			 *
			 * Insures that only one instance of WebMan Amplifier exists in memory
			 * at any one time.
			 * Also prevents needing to define globals all over the place.
			 *
			 * @since    1.0
			 * @version  1.0.9.15
			 * @access   public
			 *
			 * @return  The one true WebMan Amplifier
			 */
			public static function instance() {

				//Store the instance locally to avoid private static replication
					static $instance = null;

				//Only run these methods if they haven't been ran previously
					if ( null === $instance ) {
						$instance = new WM_Amplifier;

						$instance->setup_actions();
						$instance->setup_features();
					}

				//Always return the instance
					return $instance;
			} // /instance





		/**
		 * MAGIC METHODS (more in http://php.net/manual/en/language.oop5.magic.php)
		 */

			/**
			 * Constructor
			 *
			 * A dummy constructor to prevent class from being loaded more than once.
			 *
			 * @since   1.0
			 * @access  private
			 */
			private function __construct() {
				/* Do nothing here */
			} // /__construct



			/**
			 * Magic method to prevent notices and errors from invalid method calls
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   string $name
			 * @param   array  $args
			 */
			public function __call( $name = '', $args = array() ) {
				unset( $name, $args );
				return null;
			} // /__call



			/**
			 * A dummy magic method to prevent class from being cloned
			 *
			 * @since   1.0
			 * @access  public
			 */
			public function __clone() {
				_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wm_domain' ), '2.1' );
			} // /__clone



			/**
			 * A dummy magic method to prevent class from being unserialized
			 *
			 * @since   1.0
			 * @access  public
			 */
			public function __wakeup() {
				_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wm_domain' ), '2.1' );
			} // /__wakeup





		/**
		 * SETUP METHODS
		 */

			/**
			 * Setup the default hooks and actions
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access  public
			 */
			public function setup_actions() {
				//Array of core actions
					$actions = array(
						'load_textdomain'               => 'plugins_loaded',             //Load textdomain
						'register_metaboxes'            => 'plugins_loaded',             //Register metaboxes
						'register_widgets'              => 'widgets_init|-10',           //Register widgets
						'save_permalinks'               => 'init',                       //Save custom permalinks
						'register_post_types'           => 'init',                       //Register post types
						'custom_taxonomies'             => 'init|98',                    //Register additional custom taxonomies
						'register_shortcodes'           => 'init',                       //Register shortcodes
						'register_visual_editor_addons' => 'init',                       //Register Visual Editor addons
						'register_icons'                => 'init',                       //Register icon font
						'admin_notices'                 => 'admin_notices',              //Display admin notices
						'admin_footer_scripts'          => 'admin_print_footer_scripts', //Display admin pointers
						'deactivate'                    => 'switch_theme|10|2',          //Deactivate plugin when theme changed
					);

				//Add actions
					foreach( $actions as $class_action => $hook ) {
						$hook = explode( '|', $hook );

						if ( ! isset( $hook[1] ) ) {
							$hook[1] = 10;
						}
						if ( ! isset( $hook[2] ) ) {
							$hook[2] = 1;
						}

						add_action( $hook[0], array( $this, $class_action ), $hook[1], $hook[2] );
					}

				//Add filters
					add_filter( 'request', array( $this, 'post_types_in_feed' ) );
					add_filter( 'plugin_action_links_' . plugin_basename( WMAMP_PLUGIN_FILE ), array( $this, 'setup_action_links' ) );

				//Loaded action
					do_action( WMAMP_HOOK_PREFIX . 'loaded' );
			} // /setup_actions



			/**
			 * Setup WordPress features
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 */
			public function setup_features() {
				//Cropped squared image used in admin post tables
					$admin_thumb_size = apply_filters( WMAMP_HOOK_PREFIX . 'admin_thumb_size', array( 100, 100 ) );
					add_image_size( 'admin-thumbnail', $admin_thumb_size[0], $admin_thumb_size[1], true );

				//Load assets (JS and CSS)
					add_action( 'admin_enqueue_scripts', array( $this, 'assets' ), 998 );
			} // /setup_features



			/**
			 * Setup WordPress plugin action links
			 *
			 * @since    1.1
			 * @version  1.1
			 *
			 * @access  public
			 */
			public function setup_action_links( $links ) {
				//Preparing output
					//Icon font setup link
						if (
								apply_filters( WMAMP_HOOK_PREFIX . 'enable_iconfont', true )
								&& ! wma_supports_subfeature( 'disable-fonticons' )
							) {
							$links[] = '<a href="' . get_admin_url( null, 'themes.php?page=icon-font' ) . '">' . _x( 'Icon Font', 'Plugin action link.', 'wm_domain' ) . '</a>';
						}

					//Themes link
						$links[] = '<a href="http://www.webmandesign.eu/" target="_blank" style="color: #83A552;">WebMan Themes</a>';

				//Output
					return $links;
			} // /setup_action_links





		/**
		 * PUBLIC METHODS
		 */

			/**
			 * Register (and include) styles and scripts
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access  public
			 */
			public function assets() {
				//Helper variables
					global $current_screen, $wp_version;

					$display_isotope = apply_filters( WMAMP_HOOK_PREFIX . 'notice_isotope_licence', true ) && ! wma_supports_subfeature( 'disable-isotope-notice' );
					$pointers_seen   = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

				//Register
					//Styles
						wp_register_style( 'wmamp-admin-styles', WMAMP_ASSETS_URL . 'css/admin-addons.css', false, WMAMP_VERSION, 'screen' );

				//Enqueue (only on specific admin pages)
					if ( in_array( $current_screen->base, array( 'edit', 'post' ) ) ) {
						//Styles
							wp_enqueue_style( 'wmamp-admin-styles' );
					}

				//Isotope license pointer
					if (
							$display_isotope
							&& ! in_array( 'wmamp_isotope_license', $pointers_seen )
						) {
						wp_enqueue_style( 'wp-pointer' );
						wp_enqueue_script( 'wp-pointer' );
					}
			} // /assets



			/**
			 * Print admin footer scripts
			 *
			 * @since    1.1.3
			 * @version  1.1.3
			 *
			 * @access  public
			 */
			public function admin_footer_scripts() {
				//Helper variables
					$output = '';

					$display_isotope = apply_filters( WMAMP_HOOK_PREFIX . 'notice_isotope_licence', true ) && ! wma_supports_subfeature( 'disable-isotope-notice' );
					$pointers_seen   = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

				//Preparing output
					//Isotope license notice
						if (
								$display_isotope
								&& ! in_array( 'wmamp_isotope_license', $pointers_seen )
							) {
							$output .= '
									if ( "undefined" !== typeof( jQuery().pointer ) ) {
										var $wmampPointerObject = ( jQuery( "#menu-plugins" ).length ) ? ( jQuery( "#menu-plugins" ) ) : ( jQuery( "#menu-appearance" ) );

										$wmampPointerObject
											.pointer( {
												pointerClass : "wp-pointer wmamp_isotope_license",
												content : "' . addslashes( '<h3>' . __( 'Isotope Licensing', 'wm_domain' ) . '</h3><p><strong>' . __( 'You are using WebMan Amplifier plugin, which includes the <a href="http://isotope.metafizzy.co/" target="_blank">Isotope JavaScript filter</a>.', 'wm_domain' ) . '</strong></p><p>' . __( 'If you use the plugin for commercial applications, you are required to <a href="http://isotope.metafizzy.co/license.html" target="_blank">purchase the Isotope licence</a>.', 'wm_domain' ) . '</p>' ) . '",
												position : {
														edge  : "left",
														align : "center"
													},
												close : function() {
														jQuery.post( ajaxurl, {
																pointer : "wmamp_isotope_license",
																action  : "dismiss-wp-pointer"
															} );
													}
											} )
											.pointer( "open" );
									}
								';
						}

				//Output
					if ( $output ) {
						echo '<script type="text/javascript">jQuery( function() { ' . $output . ' } );</script>';
					}
			} // /admin_footer_scripts



			/**
			 * Save permalinks
			 *
			 * @since   1.0
			 * @access  public
			 */
			public function save_permalinks() {
				if ( ! is_admin() ) {
					return;
				}

				//We need to save the options ourselves.
				//Settings api does not trigger save for the permalinks page.
					if ( isset( $_POST['permalink_structure'] ) && isset( $_POST['wmamp-permalinks'] ) ) {
						$permalinks = $_POST['wmamp-permalinks'];

						//Validation
							if ( ! $permalinks || ! is_array( $permalinks ) ) {
								$permalinks = array();
							} else {
								foreach ( $permalinks as $key => $permalink ) {
									$permalinks[$key] = untrailingslashit( trim( $permalink ) );
								}
							}

						//Save permalinks
							update_option( 'wmamp-permalinks', $permalinks );

						//Flush rewrite rules
							// flush_rewrite_rules();
					}
			} // /save_permalinks



			/**
			 * Setup the post types
			 *
			 * @since    1.0
			 * @version  1.1.4
			 *
			 * @access  public
			 */
			public function register_post_types() {
				//Content Modules
					if ( wma_supports_subfeature( 'cp-modules' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'custom-posts/modules.php' );
					}

				//Logos
					if ( wma_supports_subfeature( 'cp-logos' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'custom-posts/logos.php' );
					}

				//Projects
					if ( wma_supports_subfeature( 'cp-projects' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'custom-posts/projects.php' );
					}

				//Staff
					if ( wma_supports_subfeature( 'cp-staff' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'custom-posts/staff.php' );
					}

				//Testimonials
					if ( wma_supports_subfeature( 'cp-testimonials' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'custom-posts/testimonials.php' );
					}

				//Plugin register custom posts action
					do_action( WMAMP_HOOK_PREFIX . 'register_post_types' );
			} // /register_post_types



			/**
			 * Register additional custom taxonomies
			 *
			 * This function provides a taxonomy help for WordPress themes.
			 * In case your theme needs to register taxonomy, hook into the
			 * 'wmhook_wmamp_custom_taxonomies' and add your own taxonomy
			 * args. The array is set up like this:
			 *   array(
			 *     'taxonomy_id' => array(
			 *       'object_type' => array(),
			 *       'args'        => array()
			 *   )
			 * @link  http://codex.wordpress.org/Function_Reference/register_taxonomy
			 *
			 * @since   1.0.9.15
			 * @access  public
			 */
			public function custom_taxonomies() {
				//Helper variables
					$taxonomies = (array) apply_filters( WMAMP_HOOK_PREFIX . 'custom_taxonomies', array() );

				//Requirements check
					if ( empty( $taxonomies ) ) {
						return;
					}

				//Processing
					foreach ( $taxonomies as $taxonomy_id => $taxonomy ) {
						if ( isset( $taxonomy['object_type'] ) && isset( $taxonomy['args'] ) ) {
							register_taxonomy( $taxonomy_id, $taxonomy['object_type'], $taxonomy['args'] );
						}
					} // /foreach
			} // /custom_taxonomies



			/**
			 * Custom post types in feed
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access  public
			 *
			 * @param   array $query
			 *
			 * @return  array Modified feed query
			 */
			public function post_types_in_feed( $query ) {
				if (
						isset( $query['feed'] )
						&& ! isset( $query['post_type'] )
					) {

					//First, make sure to display standard posts
						$query['post_type'] = array( 'post' );

					//Content Modules
						if (
								wma_supports_subfeature( 'cp-modules' )
								&& apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_' . 'wm_modules', false )
							) {
							$query['post_type'][] = 'wm_modules';
						}

					//Logos
						if (
								wma_supports_subfeature( 'cp-logos' )
								&& apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_' . 'wm_logos', false )
							) {
							$query['post_type'][] = 'wm_logos';
						}

					//Projects
						if (
								wma_supports_subfeature( 'cp-projects' )
								&& apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_' . 'wm_projects', true )
							) {
							$query['post_type'][] = 'wm_projects';
						}

					//Staff
						if (
								wma_supports_subfeature( 'cp-staff' )
								&& apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_' . 'wm_staff', false )
							) {
							$query['post_type'][] = 'wm_staff';
						}

					//Testimonials
						if (
								wma_supports_subfeature( 'cp-testimonials' )
								&& apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_' . 'wm_testimonials', false )
							) {
							$query['post_type'][] = 'wm_testimonials';
						}

				}

				//Output
					return apply_filters( WMAMP_HOOK_PREFIX . 'post_types_in_feed_query', $query );
			} // /post_types_in_feed



			/**
			 * Register metaboxes
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @uses  WM_Metabox
			 */
			public function register_metaboxes() {
				if ( is_admin() ) {
					require( WMAMP_INCLUDES_DIR . 'metabox/class-metabox.php' );
				}
			} // /register_metaboxes



			/**
			 * Register shortcodes
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @uses  WM_Shortcodes
			 */
			public function register_shortcodes() {
				if (
						apply_filters( WMAMP_HOOK_PREFIX . 'enable_shortcodes', true )
						&& ! wma_supports_subfeature( 'disable-shortcodes' )
					) {
					require( WMAMP_INCLUDES_DIR . 'shortcodes/class-shortcodes.php' );
					return wma_shortcodes();
				}
			} // /register_shortcodes



			/**
			 * Register Visual Editor addons
			 *
			 * @since    1.1
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @uses  Visual Editor addons
			 */
			public function register_visual_editor_addons() {
				if (
						apply_filters( WMAMP_HOOK_PREFIX . 'enable_visual_editor_addons', true )
						&& ! wma_supports_subfeature( 'disable-visual-editor-addons' )
					) {
					require( WMAMP_INCLUDES_DIR . 'visual-editor/visual-editor.php' );
				}
			} // /register_visual_editor_addons



			/**
			 * Register icon font file
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @uses  WM_Icons
			 */
			public function register_icons() {
				if (
						apply_filters( WMAMP_HOOK_PREFIX . 'enable_iconfont', true )
						&& ! wma_supports_subfeature( 'disable-fonticons' )
					) {
					require( WMAMP_INCLUDES_DIR . 'class-icon-font.php' );
					return WM_Icons::instance();
				}
			} // /register_icons



			/**
			 * Register widgets
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access  public
			 */
			public function register_widgets() {
				//Contact widget
					if ( wma_supports_subfeature( 'widget-contact' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-contact.php' );
					}

				//Content Module widget
					if ( wma_supports_subfeature( 'widget-module' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-module.php' );
					}

				//Posts widget
					if ( wma_supports_subfeature( 'widget-posts' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-posts.php' );
					}

				//Sub navigation widget
					if ( wma_supports_subfeature( 'widget-subnav' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-subnav.php' );
					}

				//Tabbed widgets widget
					if ( wma_supports_subfeature( 'widget-tabbed-widgets' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-tabbed-widgets.php' );
					}

				//Twitter widget
					if ( wma_supports_subfeature( 'widget-twitter' ) ) {
						include_once( WMAMP_INCLUDES_DIR . 'widgets/w-twitter.php' );
					}
			} // /register_widgets



			/**
			 * Admin notices
			 *
			 * Displays the message stored in "wmamp-admin-notice" transient cache
			 * once or multiple times, than deletes the message cache.
			 * Transient structure:
			 * set_transient(
			 *   'wmamp-admin-notice',
			 *   array( $text, $class, $capability, $number_of_displays )
			 * );
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access   public
			 */
			public function admin_notices() {
				//Requirements check
					if ( ! is_admin() ) {
						return;
					}

				//Helper variables
					$output = '';
					$class  = 'updated';
					$repeat = 0;

					$capability = apply_filters( WMAMP_HOOK_PREFIX . 'notice_capability', 'switch_themes' );
					$message    = get_transient( 'wmamp-admin-notice' );

				//Requirements check
					if ( empty( $message ) ) {
						return;
					}

				//Preparing output
					if ( ! is_array( $message ) ) {
						$message = array( $message, $class, $capability, $repeat );
					}
					if ( ! isset( $message[1] ) || empty( $message[1] ) ) {
						$message[1] = $class;
					}
					if ( ! isset( $message[2] ) || empty( $message[2] ) ) {
						$message[2] = $capability;
					}
					if ( ! isset( $message[3] ) ) {
						$message[3] = $repeat;
					}

					if ( $message[0] && current_user_can( $message[2] ) ) {
						$output .= '<div class="' . trim( 'wm-notice ' . $message[1] ) . '"><p>' . $message[0] . '</p></div>';
						delete_transient( 'wmamp-admin-notice' );
					}

					//Delete the transient cache after specific number of displays
						if ( 1 < intval( $message[3] ) ) {
							$message[3] = intval( $message[3] ) - 1;
							set_transient( 'wmamp-admin-notice', $message, ( 60 * 60 * 48 ) );
						}

				//Output
					if ( $output ) {
						echo apply_filters( WMAMP_HOOK_PREFIX . 'admin_notices_output', $output, $message );
					}
			} // /admin_notices



			/**
			 * Localization
			 *
			 * Load the translation file for the current language.
			 * Checks the languages folder inside the plugin first,
			 * and then the default WordPress languages folder.
			 *
			 * Note that custom translation files inside the plugin folder
			 * will be removed on plugin updates. If you're creating custom
			 * translation files, please use the global language folder.
			 *
			 * Note: the first-loaded translation file overrides any
			 * following ones if the same translation is present.
			 *
			 * @since    1.0
			 * @version  1.1.3
			 *
			 * @access  public
			 *
			 * @return  boolean
			 */
			public function load_textdomain() {
				//Traditional WordPress plugin locale filter
					$locale = apply_filters( 'plugin_locale', get_locale(), 'wm_domain' );
					$mofile = $locale . '.mo';

				//Look in local /wp-content/plugins/webman-amplifier/languages/ folder
					load_textdomain( 'wm_domain', trailingslashit( WMAMP_PLUGIN_DIR ) . 'languages/' . $mofile );

				//Look in global /wp-content/languages/webman-amplifier folder
					load_textdomain( 'wm_domain', trailingslashit( WP_LANG_DIR ) . 'plugins/webman-amplifier/' . $mofile );
			} // /load_textdomain



			/**
			 * Plugin deactivation
			 *
			 * @since   1.0.9.9
			 * @access  public
			 */
			public function deactivate( $newname, $newtheme ) {
				if (
					current_user_can( 'activate_plugins' )
					&& defined( 'WM_THEME_NAME' )
					&& WM_THEME_NAME !== $newname
					&& get_transient( 'wmamp-deactivate' )
				) {
					delete_transient( 'wmamp-deactivate' );
					deactivate_plugins( plugin_basename( WMAMP_PLUGIN_FILE ) );
				}
			} // /deactivate

	} // /WM_Amplifier

} // /class WM_Amplifier check





/**
 * HELPER GLOBAL FUNCTIONS
 */

	require_once( 'includes/functions.php' );

?>