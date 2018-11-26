<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Visual Editor addons
 *
 * Does not add Format button, nor registers styles for the Format button.
 * Adds Shortcode Generator (and Short Shortcode Generator) button only.
 * Supports page builder plugins.
 *
 * This file is being included in the `init` hook, so we can use
 * WM_Shortcodes::get_definitions_processed() already.
 *
 * @uses  WM_Shortcodes::get_definitions_processed()
 *
 * @package     WebMan Amplifier
 * @subpackage  Visual Editor
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.1.0
 * @version  1.5.5
 *
 * Contents:
 *
 * 10) Assets
 * 20) Visual editor addons
 */





/**
 * 10) Assets
 */

	/**
	 * Enqueuing required assets
	 *
	 * @since    1.1.0
	 * @version  1.5.0
	 */
	function wma_ve_assets() {

		// Requirements check

			if ( ! is_callable( 'WM_Shortcodes::get_definitions_processed' ) ) {
				return;
			}


		// Helper variables

			global $pagenow;

			$codes_default = (array) WM_Shortcodes::get_definitions_processed( 'generator' );
			$codes_short   = (array) WM_Shortcodes::get_definitions_processed( 'generator_short' );

			$admin_pages = (array) apply_filters( 'wmhook_wmamp_generator_admin_pages', array(
				'post.php',
				'post-new.php',
			) );

			// Requirements check

				if (
					empty( $codes_default )
					// Page builders check:
					|| ( is_admin() && ! in_array( $pagenow, $admin_pages ) )
					|| ( ! is_admin() && ( ! class_exists( 'FLBuilderModel' ) || ! FLBuilderModel::is_builder_active() ) )
				) {
					return;
				}

			$post_type = get_post_type();

			$supported_post_types = array(
				'beaver-builder'  => ( get_option( '_fl_builder_post_types' ) ) ? ( (array) get_option( '_fl_builder_post_types' ) ) : ( array( 'page' ) ),
				'visual-composer' => ( get_option( 'wpb_js_content_types' ) ) ? ( (array) get_option( 'wpb_js_content_types' ) ) : ( array( 'page' ) ),
			);

			ksort( $codes_default );
			ksort( $codes_short );


		// Processing

			// Full size shortcode generator

				// Styles

					wp_enqueue_style(
						'wm-shortcodes-generator',
						WMAMP_ASSETS_URL . 'css/shortcodes-generator.css',
						array(),
						WMAMP_VERSION,
						'screen'
					);

					wp_style_add_data(
						'wm-shortcodes-generator',
						'rtl',
						'replace'
					);

				// Scripts: inline

					wp_localize_script(
						'jquery',
						'wmShortcodesArray',
						array_values( $codes_default )
					);


			// Short version of shortcode generator for page builders

				if (
					! empty( $codes_short )
					&& (
						(
							! is_admin()
							&& in_array( $post_type, $supported_post_types['beaver-builder'] )
						) || (
							wma_is_active_vc()
							&& in_array( $post_type, $supported_post_types['visual-composer'] )
						)
					)
				) {

					// Scripts: inline

						wp_localize_script(
							'jquery',
							'wmShortcodesArrayShort',
							array_values( $codes_short )
						);

				}

	} // /wma_ve_assets

	add_action( 'wp_enqueue_scripts',    'wma_ve_assets' );
	add_action( 'admin_enqueue_scripts', 'wma_ve_assets' );





/**
 * 20) Visual editor addons
 */

	/**
	 * Visual Editor custom plugin
	 *
	 * @since    1.0.0
	 * @version  1.5.5
	 *
	 * @param  array $plugins_array
	 */
	function wma_ve_custom_mce_plugin( $plugins_array = array() ) {

		// Requirements check

			if ( ! is_callable( 'WM_Shortcodes::get_definitions_processed' ) ) {
				return $plugins_array;
			}


		// Helper variables

			global $pagenow;

			$codes_default = (array) WM_Shortcodes::get_definitions_processed( 'generator' );

			$admin_pages = (array) apply_filters( 'wmhook_wmamp_generator_admin_pages', array(
				'post.php',
				'post-new.php',
			) );


		// Requirements check

			if (
				empty( $codes_default )
				// Page builders check:
				|| ( is_admin() && ! in_array( $pagenow, $admin_pages ) )
				|| ( ! is_admin() && ( ! class_exists( 'FLBuilderModel' ) || ! FLBuilderModel::is_builder_active() ) )
			) {
				return $plugins_array;
			}


		// Processing

			$plugins_array['wmShortcodes'] = WMAMP_ASSETS_URL . 'js/shortcodes-button.js';


		// Output

			return $plugins_array;

	} // /wma_ve_custom_mce_plugin

	add_filter( 'mce_external_plugins', 'wma_ve_custom_mce_plugin', 19998 ); //-> 9999 in Beaver Builder



	/**
	 * Add buttons to visual editor
	 *
	 * First row.
	 *
	 * @since    1.0.0
	 * @version  1.2.2
	 *
	 * @param  array $buttons
	 */
	function wma_ve_add_buttons_row1( $buttons ) {

		// Pre

			$pre = apply_filters( 'wmhook_wmamp_fn_wma_ve_add_buttons_row1_pre', false, $buttons );

			if ( false !== $pre ) {
				return $pre;
			}


		// Requirements check

			if ( ! current_user_can( apply_filters( 'wmhook_wmamp_editor_capability', 'edit_posts' ) ) ) {
				return $buttons;
			}


		// Processing

			// Inserting buttons before "Toolbar Toggle" (kitchensink) button

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


		// Output

			return $buttons;

	} // /wma_ve_add_buttons_row1

	add_filter( 'mce_buttons', 'wma_ve_add_buttons_row1' );
