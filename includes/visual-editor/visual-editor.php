<?php
/**
 * Visual Editor addons
 *
 * Does not add Format button, nor registers styles for the Format button.
 * Adds Shortcode Generator (and Short Shortcode Generator) button only.
 * Supports page builder plugins.
 *
 * This file is being included in the `init` hook, so we can use
 * wma_shortcodes()->get_definitions()['generator'] already.
 *
 * @package     WebMan Amplifier
 * @subpackage  Visual Editor
 *
 * @uses  wma_shortcodes()->get_definitions()['generator']
 *
 * @since    1.1
 * @version  1.1.3
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Assets
 * - 30) Visual editor addons
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Assets
			add_action( 'wp_enqueue_scripts',    'wma_ve_assets' );
			add_action( 'admin_enqueue_scripts', 'wma_ve_assets' );



	/**
	 * Filters
	 */

		//Visual editor
			add_filter( 'mce_buttons',          'wma_ve_add_buttons_row1'         );
			add_filter( 'mce_external_plugins', 'wma_ve_custom_mce_plugin', 19998 ); //-> 9999 in Beaver Builder





/**
 * 20) Assets
 */

	/**
	 * Enqueuing required assets
	 */
	if ( ! function_exists( 'wma_ve_assets' ) ) {
		function wma_ve_assets() {
			//Helper variables
				global $pagenow;

				$codes = ( is_callable( 'wma_shortcodes' ) ) ? ( wma_shortcodes()->get_definitions() ) : ( array( 'generator' => null ) );

				$admin_pages = apply_filters( WMAMP_HOOK_PREFIX . 'generator_admin_pages', array( 'post.php', 'post-new.php' ) );

				//Requirements check
					if (
							empty( $codes['generator'] )
							//page builders check
							|| ( is_admin() && ! in_array( $pagenow, $admin_pages ) )
							|| ( ! is_admin() && ! isset( $_GET['fl_builder'] ) )
						) {
						return;
					}

				$post_type = get_post_type();

				$supported_post_types = array(
						'beaver-builder'  => ( get_option( '_fl_builder_post_types' ) ) ? ( (array) get_option( '_fl_builder_post_types' ) ) : ( array( 'page' ) ),
						'visual-composer' => ( get_option( 'wpb_js_content_types' ) ) ? ( (array) get_option( 'wpb_js_content_types' ) ) : ( array( 'page' ) ),
					);

			/**
			 * Register
			 */

				//Styles
					wp_register_style( 'wm-shortcodes-generator',     WMAMP_ASSETS_URL . 'css/shortcodes-generator.css',     array(), WMAMP_VERSION, 'screen' );
					wp_register_style( 'wm-shortcodes-generator-rtl', WMAMP_ASSETS_URL . 'css/rtl-shortcodes-generator.css', array(), WMAMP_VERSION, 'screen' );



			/**
			 * Enqueue
			 */

				/**
				 * Shortcode generator: standard
				 */

					//Styles
						wp_enqueue_style( 'wm-shortcodes-generator' );

						if ( is_rtl() ) {
							wp_enqueue_style( 'wm-shortcodes-generator-rtl' );
						}

					//Scripts: inline
						wp_localize_script( 'jquery', 'wmShortcodesArray', array_values( wma_ksort( (array) $codes['generator'] ) ) );



				/**
				 * Shortcode generator: short
				 *
				 * Supported in page builders.
				 */

					if (
							! empty( $codes['generator_short'] )
							&& (
								//Beaver Builder
								( ! is_admin() && isset( $_GET['fl_builder'] ) && in_array( $post_type, $supported_post_types['beaver-builder'] ) )
								//Visual Composer
								|| ( wma_is_active_vc() && in_array( $post_type, $supported_post_types['visual-composer'] ) )
							)
						) {

						//Scripts: inline
							wp_localize_script( 'jquery', 'wmShortcodesArrayShort', array_values( wma_ksort( (array) $codes['generator_short'] ) ) );

					}
		}
	} // /wma_ve_assets





/**
 * 30) Visual editor addons
 */

	/**
	 * Visual Editor custom plugin
	 *
	 * @since    1.0
	 * @version  1.1.3
	 *
	 * @param  array $plugins_array
	 */
	if ( ! function_exists( 'wma_ve_custom_mce_plugin' ) ) {
		function wma_ve_custom_mce_plugin( $plugins_array = array() ) {
			//Helper variables
				global $pagenow;

				$codes = ( is_callable( 'wma_shortcodes' ) ) ? ( wma_shortcodes()->get_definitions() ) : ( array( 'generator' => null ) );

				$admin_pages = apply_filters( WMAMP_HOOK_PREFIX . 'generator_admin_pages', array( 'post.php', 'post-new.php' ) );

				//Requirements check
					if (
							empty( $codes['generator'] )
							//page builders check
							|| ( is_admin() && ! in_array( $pagenow, $admin_pages ) )
							|| ( ! is_admin() && ! isset( $_GET['fl_builder'] ) )
						) {
						return;
					}

			//Preparing output
				$plugins_array['wmShortcodes'] = WMAMP_ASSETS_URL . 'js/shortcodes-button.js';

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_ve_custom_mce_plugin' . '_output', $plugins_array );
		}
	} // /wma_ve_custom_mce_plugin



	/**
	 * Add buttons to visual editor
	 *
	 * First row.
	 *
	 * @param  array $buttons
	 */
	if ( ! function_exists( 'wma_ve_add_buttons_row1' ) ) {
		function wma_ve_add_buttons_row1( $buttons ) {
			//Requirements check
				if ( ! current_user_can( apply_filters( WMAMP_HOOK_PREFIX . 'editor_capability', 'edit_posts' ) ) ) {
					return $buttons;
				}

			//Inserting buttons after "more" button
				$pos = array_search( 'wp_adv', $buttons, true );
				if ( false !== $pos ) {
					$add   = array_slice( $buttons, 0, $pos );
					$add[] = '|';
					$add[] = 'wm_shortcodes_list';
					$add[] = 'wm_shortcodes_list_short';
					$add[] = '|';
					$add[] = 'wp_adv';

					$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
				}

			//Output
				return $buttons;
		}
	} // /wma_ve_add_buttons_row1

?>