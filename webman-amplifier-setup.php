<?php
/**
 * WebMan Amplifier plugin setup
 *
 * THEME IMPLEMENTATION:
 * ---------------------
 * 1. Copy this file into your theme's folder.
 * 2. Inlude it in your theme's `functions.php` file with
 *    `locate_template( 'webman-amplifier-setup.php', true );`
 * 3. Edit the file to your needs.
 *
 * @package    WebMan Amplifier
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @link  https://wordpress.org/plugins/webman-amplifier/
 *
 * @since    1.0
 * @version  1.3.3
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'WM_Amplifier' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	// Uncomment to enable the Schema.org function

		// add_filter( 'wmhook_wmamp_disable_schema_org', '__return_false' );

	// Uncomment to enable WebMan Advanced Metaboxes

		// add_filter( 'wmhook_metabox_visual_wrapper_toggle', '__return_true' );



	/**
	 * Plugin setup
	 */
	function wmamp_setup() {

		// Processing

			// Plugin features

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
					// 'disable-shortcodes',
					// 'disable-visual-composer-support',
				) );

			// Deactivate plugin when theme changed

				// if ( ! get_transient( 'wmamp-deactivate' ) ) {
				// 	set_transient( 'wmamp-deactivate', true );
				// }

	} // /wmamp_setup

	add_action( 'after_setup_theme', 'wmamp_setup' );





	/**
	 * CUSTOM POSTS
	 */

		/**
		 * Projects
		 */

			/**
			 * Manipulate projects custom post metafields
			 *
			 * @param  array $fields Array of predefined metafields
			 *
			 * @return  array Modified $fields array
			 */
			function wmamp_additional_metafields( $fields = array() ) {

				// Processing

					// "Form fields test" tab

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

					/**
					 * For more form fields options please check the PHP files inside
					 * the "wm-amplifier/includes/metabox/fields/" folder.
					 */


				// Output

					return $fields;

			} // /wmamp_additional_metafields

			// add_filter( 'wmhook_wmamp_cp_metafields_wm_projects', 'wmamp_additional_metafields' );





	/**
	 * SHORTCODES
	 */

		/**
		 * Supported shortcodes version
		 *
		 * Use this to declare the plugin version that your theme supports.
		 * It is possible that in future versions of the plugin there will be more
		 * shortcodes added and your theme might not suppot them out of the box.
		 * Setting this version number will make sure only the shortcodes included
		 * with the specific plugin version will be available to your theme users.
		 */
		function wmamp_supported_shortcode_until_version() {

			// Output

				return '1.1'; //Set the plugin version your theme supports

		} // /wmamp_supported_shortcode_until_version

		add_filter( 'wmhook_shortcode_supported_version', 'wmamp_supported_shortcode_until_version' );





	/**
	 * METABOXES
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

						'fields' => 'wmamp_additional_metafields',

						// In this example we use the function defined previously in this file.
						// Feel free to create your own similar function depending on post settings.

					// Meta box id, unique per meta box.

						'id' => 'my-metabox-id',

					// Post types.

						'pages' => array( 'post' ),

						// Display this metabox only on Posts.
						// You can add any post type in the array and the metabox
						// will be displayed for all of those post types.

					// Order of meta box: high (default), low.

						'priority' => 'high',

					// Tabbed meta box interface?

						'tabs' => true,

					// Meta box title.

						'title' => 'Custom metabox title',

					// Wrap the meta form around visual editor (WebMan Advanced Metabox)?
					// This is always tabbed.

						'visual-wrapper' => false,

					// Function callback of form fields displayed immediately after visual editor on 1st tab.
					// Note that this is relevant to "visual-wrapper" setting only and is optional.

						'visual-wrapper-add' => ''

				) );

		}
		*/





	/**
	 * ICON FONT
	 */

		/**
		 * Icons font setup
		 *
		 * You can use these functions to set the custom iconfont CSS
		 * stylesheet file URL and icons configuration array file path
		 * (or the actual configuration array) if you want to use
		 * a font bundled with your theme.
		 */

		/**
		 * Changing the default icon font CSS file URL
		 */
		function wmamp_iconfont_css_url() {

			// Output

				return get_stylesheet_directory_uri() . '/font/fontello.css';

		} // /wmamp_iconfont_css_url

		// add_filter( 'wmhook_icons_default_iconfont_css_url', 'wmamp_iconfont_css_url' );



		/**
		 * Changing the default icons config array file path
		 *
		 * The default config file should contain an $icons array.
		 * Please see the "wm-amplifier/font/config.php" file for the structure.
		 */
		function wmamp_iconfont_config_path() {

			// Output

				return get_stylesheet_directory() . '/font/config.php';

		} // /wmamp_iconfont_config_path

		// add_filter( 'wmhook_icons_default_iconfont_config_path', 'wmamp_iconfont_config_path' );



		/**
		 * Changing the default icons config array
		 *
		 * Alternatively, instead of setting custom icons config array file path,
		 * you can actually change the array itself.
		 */
		function wmamp_iconfont_config_array() {

			// Helper variables

				$icons = array();


			// Processing

				$icons['icon_class'] = array(
						'class' => 'icon_class',
						'char'  => 'character_used'
					);

				$icons['another_icon_class'] = array(
						'class' => 'another_icon_class',
						'char'  => 'another_character_used'
					);

				// ...


			// Output

				return $icons;

		} // /wmamp_iconfont_config_array

		// add_filter( 'wmhook_icons_default_iconfont_config_array', 'wmamp_iconfont_config_array' );
