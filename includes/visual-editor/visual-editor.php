<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Visual Editor addons
 *
 * Adds Shortcode Generator (and short, simplified version of it).
 *
 * This file is being included in the `init` hook, so we can use
 * WM_Shortcodes::get_definitions_processed() already.
 *
 * @package     WebMan Amplifier
 * @subpackage  Visual Editor
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.1.0
 * @version  1.6.0
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
	 * @uses  WM_Shortcodes::get_definitions_processed()
	 *
	 * @since    1.1.0
	 * @version  1.6.0
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

			ksort( $codes_default );
			ksort( $codes_short );

			$admin_pages = (array) apply_filters( 'wmhook_wmamp_generator_admin_pages', array(
				'post.php',
				'post-new.php',
			) );


		// Processing

			if (
				! empty( $codes_default )
				&& apply_filters( 'wmhook_wmamp_generator_enable', ( is_admin() && in_array( $pagenow, $admin_pages ) ) )
			) {

				// Full size shortcode generator

					// Styles

						wp_enqueue_style(
							'wm-shortcodes-generator',
							WMAMP_ASSETS_URL . 'css/shortcodes-generator.css',
							array(),
							WMAMP_VERSION,
							'screen'
						);
						wp_style_add_data( 'wm-shortcodes-generator', 'rtl', 'replace' );

					// Scripts: inline

						wp_localize_script(
							'jquery',
							'$wmShortcodesArray',
							array_values( $codes_default )
						);

				// Short, simplified version of shortcode generator (for page builders, for example)

					if (
						! empty( $codes_short )
						// This is disabled by default as we usually load full generator only.
						&& apply_filters( 'wmhook_wmamp_generator_short_enable', false )
					) {

						// Scripts: inline

							wp_localize_script(
								'jquery',
								'$wmShortcodesArrayShort',
								array_values( $codes_short )
							);

					}

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
	 * @uses  WM_Shortcodes::get_definitions_processed()
	 *
	 * @since    1.0.0
	 * @version  1.6.0
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


		// Processing

			if (
				! empty( $codes_default )
				&& apply_filters( 'wmhook_wmamp_generator_enable', ( is_admin() && in_array( $pagenow, $admin_pages ) ) )
			) {
				$plugins_array['wmShortcodes'] = WMAMP_ASSETS_URL . 'js/shortcodes-button.js';
			}


		// Output

			return $plugins_array;

	} // /wma_ve_custom_mce_plugin

	// Must load after Beaver Builder (9999) to keep compatibility.
	add_filter( 'mce_external_plugins', 'wma_ve_custom_mce_plugin', 10010 );



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
