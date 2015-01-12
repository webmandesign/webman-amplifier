<?php
/**
 * WebMan Amplifier plugin setup
 *
 * THEME IMPLEMENTATION
 * Copy this file into your theme's folder and inlude it in the theme's `functions.php` file
 * with `locate_template( 'webman-amplifier-setup.php', true );` WordPress function.
 * Edit the file to your needs.
 *
 * PLUGIN LOCALIZATION
 * Note that custom translation files inside the plugin folder will be removed on plugin updates.
 * If you're creating custom translation files, please use the global WordPress language folder.
 * Just create a `wp-content/languages/wm-amplifier` folder and place your plugin localization
 * files (such as `pt_BR.mo` for Brazilian Portuguese localization file) in there.
 *
 * @package    WebMan Amplifier
 * @copyright  2015 WebMan - Oliver Juhas
 * @license    GPL-2.0+, http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @link  http://www.webmandesign.eu
 *
 * @since    1.0
 * @version  1.1
 */



/**
 * SET UP THE PLUGIN
 */

	/**
	 * Enabling plugin features
	 *
	 * Please note that your theme must support them. If you enable any of custom
	 * post types, make sure your theme contains the appropriate single post
	 * and archive templates.
	 */
	add_theme_support( 'webman-amplifier', array(
			/**
			 * Uncomment to enable Logos custom post type ("wm_logos")
			 *
			 * This will also create a new taxonomy: "logo_category"
			 */
			// 'cp-logos',

			/**
			 * Uncomment to enable Content Modules (icon boxes) custom post type ("wm_modules")
			 *
			 * This will also create a new taxonomy: "module_tag"
			 */
			// 'cp-modules',

			/**
			 * Uncomment to enable Projects (portfolio) custom post type ("wm_projects")
			 *
			 * This will also create a new taxonomy: "project_tag" and "project_category"
			 */
			// 'cp-projects',

			/**
			 * Uncomment to enable Staff (team) custom post type ("wm_staff")
			 *
			 * This will also create a new taxonomy: "staff_department" and "staff_position"
			 */
			// 'cp-staff',

			/**
			 * Uncomment to enable Testimonials custom post type ("wm_testimonials")
			 *
			 * This will also create a new taxonomy: "testimonial_category"
			 */
			// 'cp-testimonials',


			/**
			 * Uncomment to enable Contact widget
			 */
			// 'widget-contact',

			/**
			 * Uncomment to enable Content Module widget
			 */
			// 'widget-module',

			/**
			 * Uncomment to enable Posts widget
			 */
			// 'widget-posts',

			/**
			 * Uncomment to enable Sub-navigation widget
			 */
			// 'widget-subnav',

			/**
			 * Uncomment to enable Tabbed Widgets widget
			 */
			// 'widget-tabbed-widgets',

			/**
			 * Uncomment to enable Twitter widget
			 */
			// 'widget-twitter',


			/**
			 * Uncomment to remove default Visual Composer elements (shortcodes)
			 */
			// 'remove-vc-shortcodes',


			/**
			 * Uncomment to disable the plugin's feature
			 */
			// 'disable-fonticons',
			// 'disable-isotope-notice',
			// 'disable-shortcodes',
		) );



		/**
		 * Uncomment to enable WebMan Advanced Metaboxes
		 */
		// add_filter( 'wmhook_metabox_visual_wrapper_toggle', '__return_true' );

		/**
		 * Uncomment to disable plugin's frontend shortcodes styles
		 */
		// add_filter( 'wmhook_shortcode_enqueue_shortcode_css', '__return_false' );

		/**
		 * Uncomment to disable the Isotope licence purchase admin notice
		 */
		// add_filter( 'wmhook_wmamp_notice_isotope_licence', '__return_false' );



		/**
		 * Supported shortcodes version
		 *
		 * Use this to declare the plugin version that your theme supports.
		 * It is possible that in future versions of the plugin there will be more
		 * shortcodes added and your theme might not suppot them out of the box.
		 * Setting this version number will make sure only the shortcodes included
		 * with the specific plugin version will be available to your theme users.
		 *
		 * To use this function just uncomment the "add_filter" below
		 */
		function wma_supported_shortcode_until_version() {
			return '1.0.9'; //Set the plugin version your theme supports
		} // /wma_supported_shortcode_until_version
		// add_filter( 'wmhook_shortcode_supported_version', 'wma_supported_shortcode_until_version' );





/**
 * CUSTOM POST SETTINGS
 */
	/**
	 * Projects custom post
	 */
		/**
		 * Manipulate projects custom post metafields
		 *
		 * @param   array $fields Array of predefined metafields
		 *
		 * @return  array Modified $fields array
		 */
		function wma_additional_metafields( $fields = array() ) {
			//"Form fields test" tab
				$fields[3000] = array(
						'type'  => 'section-open',
						'id'    => 'project-heading-section',
						'title' => 'Form fields test',
					);

					$fields[3020] = array(
							'type'        => 'checkbox',
							'id'          => 'form-fields-checkbox',
							'label'       => 'Checkbox test',
							'description' => 'Description text goes here',
						);

					$fields[3040] = array(
							'type'        => 'image',
							'id'          => 'form-fields-image',
							'label'       => 'Image test',
							'description' => 'Description text goes here',
						);

					$fields[3060] = array(
							'type'        => 'gallery',
							'id'          => 'form-fields-gallery',
							'label'       => 'Gallery test',
							'description' => 'Description text goes here',
						);

					$fields[3080] = array(
							'type'        => 'radio',
							'id'          => 'form-fields-radio',
							'label'       => 'Radio inline test',
							'description' => 'Description text goes here',
							'inline'      => true,
							'options'     => array(
									1 => '01',
									2 => '02',
									3 => '03',
									4 => '04',
								),
						);

					$fields[3081] = array(
							'type'        => 'radio',
							'id'          => 'form-fields-radio2',
							'label'       => 'Radio test',
							'description' => 'Description text goes here',
							'options'     => array(
									1 => '01',
									2 => '02',
									3 => '03',
									4 => '04',
								),
						);

					$fields[3100] = array(
							'type'        => 'select',
							'id'          => 'form-fields-select',
							'label'       => 'Select test',
							'description' => 'Description text goes here',
							'options'     => array(
									1 => '01',
									2 => '02',
									3 => '03',
									4 => '04',
								),
						);

					$fields[3120] = array(
							'type'        => 'slider',
							'id'          => 'form-fields-slider',
							'label'       => 'Slider test',
							'description' => 'Description text goes here',
							'default'     => 3,
							'max'         => 12,
							'min'         => -9,
							'step'        => 3,
							'zero'        => true,
						);

					$fields[3140] = array(
							'type'        => 'text',
							'id'          => 'form-fields-text',
							'label'       => 'Text test',
							'description' => 'Description text goes here',
						);

					$fields[3160] = array(
							'type'        => 'color',
							'id'          => 'form-fields-color',
							'label'       => 'Color test',
							'description' => 'Description text goes here',
						);

					$fields[3180] = array(
							'type'        => 'password',
							'id'          => 'form-fields-password',
							'label'       => 'Password test',
							'description' => 'Description text goes here',
						);

					$fields[3200] = array(
							'type'        => 'textarea',
							'id'          => 'form-fields-textarea',
							'label'       => 'Textarea test',
							'description' => 'Description text goes here',
						);

					$fields[3220] = array(
							'type'        => 'textarea',
							'id'          => 'form-fields-textarea-editor',
							'label'       => 'Textarea editor test',
							'description' => 'Description text goes here',
							'editor'      => true,
						);

				$fields[3980] = array(
						'type' => 'section-close',
					);
			// /"Form fields test" tab

			/**
			 * For more form fields options please check the PHP files inside
			 * the "wm-amplifier/includes/metabox/fields/" folder.
			 */

			return $fields;
		} // /wma_additional_metafields

		/**
		 * Uncomment to add your custom post meta fields
		 */
		// add_filter( 'wmhook_wmamp_cp_metafields_wm_projects', 'wma_additional_metafields' );





/**
 * VISUAL COMPOSER PLUGIN SUPPORT
 *
 * Please note that this is 3rd party plugin. The WebMan Amplifier plugin
 * just integrates its shortcodes feature with the Visual Composer plugin
 * to make it easier to create content. If you have any difficulties
 * with Visual Composer plugin, please contact its developers.
 *
 * @since    1.0
 * @version  1.0.8
 *
 * @link     http://codecanyon.net/item/visual-composer-for-wordpress/242431
 */
	if ( function_exists( 'wma_is_active_vc' ) && wma_is_active_vc() ) {

		/**
		 * Enable Visual Composer for custom post types
		 */
			//Set post types, where Visual Composer should be always enabled
				$vc_post_types = array(
						'page',
						'wm_projects',
					);
			//Comparing and altering the Visual Composer settings
				$vc_post_types_diff = array_diff( $vc_post_types, (array) get_option( 'wpb_js_content_types' ) );

				if ( ! empty( $vc_post_types_diff ) ) {
					$vc_post_types_new = array_filter( array_merge( (array) get_option( 'wpb_js_content_types' ), $vc_post_types_diff ) );
					update_option( 'wpb_js_content_types', $vc_post_types_new );
				}



		/**
		 * Disable Visual Composer "VC: Custom Teaser" metabox
		 */
			function wma_remove_vc_metabox() {
				$vc_post_types = (array) get_option( 'wpb_js_content_types' );

				foreach ( $vc_post_types as $post_type ) {
					remove_meta_box( 'vc_teaser', $post_type, 'side' );
				}
			} // /wma_remove_vc_metabox

			add_action( 'admin_init', 'wma_remove_vc_metabox', 10 );

	} // /wma_is_active_vc() check



	/**
	 * Add custom Visual Composer templates
	 *
	 * Please note that this procedure works with Visual Composer version 4.3 and above.
	 * Uncomment the code below to set a custom Visual Composer predefined templates.
	 */
		/*
		if ( function_exists( 'vc_add_default_templates' ) ) {
			$wm_custom_vc_templates = array(
				'my_custom_template' => array(
						'name'    => 'Custom template name',
						'content' => '...your custom content goes here...',
					),
				);

			foreach ( $wm_custom_vc_templates as $template ) {
				vc_add_default_templates( (array) $template );
			}
		} // check if vc_add_default_templates() exists
		*/





/**
 * ADDING YOUR OWN METABOXES
 */
	/**
	 * Uncomment to add your custom post metabox
	 */
	/*
	if ( function_exists( 'wma_add_meta_box' ) ) {
		wma_add_meta_box( array(
				// Where the meta box appear: normal (default), advanced, side.
				'context' => 'normal',

				// Meta fields function callback (should return array of fields).
				// The function callback is used for to use a WordPress globals
				// available during the metabox rendering, such as $post.
				'fields' => 'wma_additional_metafields', //In this example we use the function defined previously in this file. Feel free to create your own similar function depending on post settings.

				// Meta box id, unique per meta box.
				'id' => 'posts' . '-metabox',

				// Post types.
				'pages' => array( 'post' ), //Display this metabox only on Posts. You can add any post type in the array and the metabox will be displayed for all those post types.

				// Order of meta box: high (default), low.
				'priority' => 'high',

				// Tabbed meta box interface?
				'tabs' => true,

				// Meta box title.
				'title' => 'Custom metabox title',

				// Wrap the meta form around visual editor (WebMan Advanced Metabox)? (This is always tabbed.)
				'visual-wrapper' => false,

				// Function callback of form fields displayed immediately after
				// visual editor on 1st tab.
				// Note that this is relevant to "visual-wrapper" setting only and is optional.
				'visual-wrapper-add' => ''
			) );
	}
	*/





/**
 * ICON FONT SETUP
 *
 * You can use these functions to set the custom iconfont CSS
 * stylesheet file URL and icons configuration array file path
 * (or the actual configuration array) if you want to use
 * a font bundled with your theme.
 */
	/**
	 * Changing the default icon font CSS file URL
	 */
	function wma_iconfont_css_url() {
		return get_stylesheet_directory_uri() . '/font/fontello.css'; //Change the URL to your needs
	} // /wma_iconfont_css_url

	/**
	 * Uncomment to set the custom default iconfont CSS file URL
	 */
	// add_filter( 'wmhook_icons_default_iconfont_css_url', 'wma_iconfont_css_url' );



	/**
	 * Changing the default icons config array file path
	 *
	 * The default config file should contain an $icons array.
	 * Please see the "wm-amplifier/font/config.php" file for the structure.
	 */
	function wma_iconfont_config_path() {
		return get_stylesheet_directory() . '/font/config.php'; //Change the file path to your needs
	} // /wma_iconfont_config_path

	/**
	 * Uncomment to set the custom default icons config array file path
	 */
	// add_filter( 'wmhook_icons_default_iconfont_config_path', 'wma_iconfont_config_path' );



	/**
	 * Changing the default icons config array
	 *
	 * Alternatively, instead of setting custom icons config array file path,
	 * you can actually change the array itself.
	 */
	function wma_iconfont_config_array() {
		$icons = array();

		$icons['icon_class'] = array( 'class' => 'icon_class', 'char' => 'character_used' );

		return $icons;
	} // /wma_iconfont_config_array

	/**
	 * Uncomment to set the custom default icons config array file path
	 */
	// add_filter( 'wmhook_icons_default_iconfont_config_array', 'wma_iconfont_config_array' );

?>