<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Shortcodes definitions array
 *
 * Example structure of a shortcode definition array:
 * @example
 * 	'shortcode-name' => array(
 *
 * 		// Plugin version when the shortcode was added
 * 		'since' => '1.0.0',
 *
 * 		// Shortcode generator setup
 * 		'generator' => array(
 * 			'name'  => (string),
 * 			'code'  => (string),
 * 			'short' => (boolean), // Available in simplified, short Shortcode Generator?
 * 		),
 *
 * 		// Preprocessing needed?
 * 		'preprocess' => (boolean),
 *
 * 		// Post type required for the shortcode
 * 		'post_type_required' => (string),
 *
 * 		// Overrides the default shortcode prefix when registering shortcode with WordPress.
 * 		// IMPORTANT: Set this only when really required!
 * 		'custom_prefix' => (mixed: boolean/string),
 *
 * 		// Alias: overrides shortcode default rendering functionality
 *   	'renderer' => array(
 * 			'alias' => (string),
 * 			'path'  => (string), // Custom render functionality file path
 * 		),
 *
 * 		// Plugin compatibility: Beaver Builder
 * 		'bb_plugin' => array(), // @todo  Documentation needed.
 *
 * 		// Plugin compatibility: Visual Composer
 * 		'vc_plugin' => array(), // @todo  Documentation needed.
 *
 *   ),
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.0
 */





// Helper variables

	$codes_globals = WM_Shortcodes::get_codes_globals();

	// Empty value array for Visual Composer dropdown default value (fix for VC4.6+)

		$empty = array( '' => '' );

	// HTML heading tags

		$heading_tags = array(
			''   => esc_html_x( 'Default', 'Default HTML heading tag value.', 'webman-amplifier' ),
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);

	// Social icons array

		$wm_social_icons_array = $codes_globals['social_icons'];
		array_push( $wm_social_icons_array, '', 'background-light', 'background-dark' );
		asort( $wm_social_icons_array );
		$wm_social_icons_array = array_combine( $wm_social_icons_array, $wm_social_icons_array );

	// Taxonomies

		$wm_taxonomies = get_taxonomies( '', 'names' );
		unset( $wm_taxonomies['nav_menu'] );
		unset( $wm_taxonomies['link_category'] );
		asort( $wm_taxonomies );

	// Slugs

		$wm_modules_slugs = wma_posts_array( 'post_name', 'wm_modules' );
		$wm_modules_tags  = wma_taxonomy_array( array(
			'all_post_type' => '',
			'all_text'      => '-',
			'hierarchical'  => '0',
			'tax_name'      => 'module_tag'
		) );
		$wm_testimonials_slugs      = wma_posts_array( 'post_name', 'wm_testimonials' );
		$wm_testimonials_categories = wma_taxonomy_array( array(
			'all_post_type' => '',
			'all_text'      => '-',
			'hierarchical'  => '0',
			'tax_name'      => 'testimonial_category'
		) );

	// Prefixes

		$prefix = array(
			'code' => WM_Shortcodes::$prefix_shortcode,
			'name' => WM_Shortcodes::$prefix_shortcode_name,
		);


// Processing

	/**
	 * This variable is passed into `WM_Shortcodes::get_definitions_from_file()` via `include_once()`
	 */
	$shortcode_definitions = array(





		/**
	   * Accordions + Tabs + Item
	   */

			/**
			 * Accordion
			 *
			 * @since  1.0
			 */
			'accordion' => array(
				'since' => '1.0',
				'preprocess' => false,
				'generator' => array(
					'name'  => esc_html__( 'Accordion', 'webman-amplifier' ),
					'code'  => '[PREFIX_accordion active="0" mode="accordion/toggle" filter="0/1" class=""]<br />[PREFIX_item title="' . esc_html__( 'Section 1', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . esc_html__( 'Section 2', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""][/PREFIX_item]<br />[/PREFIX_accordion]',
					'short' => false,
				),
				'bb_plugin' => array(
					'name' => esc_html__( 'Accordion', 'webman-amplifier' ),
					'output' => '[PREFIX_accordion{{active}}{{mode}}{{filter}}{{class}}]{{children}}[/PREFIX_accordion]',
					'output_children' => '[PREFIX_item{{title}}{{icon}}{{tags}}{{heading_tag}}]{{content}}[/PREFIX_item]',
					'params' => array( 'active', 'mode', 'filter', 'class' ),
					'params_children' => array( 'title', 'content', 'icon', 'tags', 'heading_tag' ),
					'form' => array(

						//Tab
						'general' => array(
							//Title
							'title'       => esc_html__( 'General', 'webman-amplifier' ),
							'description' => '',
							//Sections
							'sections' => array(

								//Section
								'general' => array(
									'title'  => '',
									'fields' => array(

										'mode' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Mode', 'webman-amplifier' ),
											//type specific
											'options' => array(
												'accordion' => esc_html__( 'Accordion (only one section open)', 'webman-amplifier' ),
												'toggle'    => esc_html__( 'Toggle (multiple sections open)', 'webman-amplifier' ),
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /mode

									), // /fields
								), // /section

								//Section
								'sections' => array(
									'title'  => esc_html__( 'Sections', 'webman-amplifier' ),
									'fields' => array(

										'children' => array(
											'type' => 'form',
											//description
											'label'       => '',
											'description' => '',
											'help'        => '',
											//default
											'default' => array( 'title' => esc_html__( 'Section', 'webman-amplifier' ) ), //This will be converted automatically
											//type specific
											'form'         => 'wm_children_form_' . 'accordion',
											'preview_text' => 'title', //DO NOT FORGET TO SET!
											//multiple
											'multiple' => true,
											//preview
											'preview' => array( 'type' => 'refresh' ),
										), // /children

									), // /fields
								), // /section

							), // /sections
						), // /tab

						//Tab
						'others' => array(
							//Title
							'title'       => esc_html__( 'Others', 'webman-amplifier' ),
							'description' => '',
							//Sections
							'sections' => array(

								//Section
								'general' => array(
									'title'  => '',
									'fields' => array(

										'filter' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Filtering', 'webman-amplifier' ),
											'help'  => esc_html__( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
											//type specific
											'options' => array(
												'' => esc_html__( 'No', 'webman-amplifier' ),
												1  => esc_html__( 'Yes', 'webman-amplifier' ),
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /filter

										'active' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Active section number', 'webman-amplifier' ),
											//default
											'default' => 1,
											//type specific
											'options' => array(
												'0' => esc_html__( 'All accordion sections closed', 'webman-amplifier' ),
												1   => 1,
												2   => 2,
												3   => 3,
												4   => 4,
												5   => 5,
												6   => 6,
												7   => 7,
												8   => 8,
												9   => 9,
												10  => 10,
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /active

									), // /fields
								), // /section

							), // /sections
						), // /tab

					),
					'form_children'   => array(

						//Title
						'title' => esc_html__( 'Section', 'webman-amplifier' ),
						//Tabs
						'tabs' => array(

							//Tab
							'general' => array(
								//Title
								'title'       => esc_html__( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'title' => array(
										'title'  => '',
										'fields' => array(

											'title' => array(
												'type' => 'text',
												//description
												'label' => esc_html__( 'Title', 'webman-amplifier' ),
												//default
												'default' => esc_html__( 'Section', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /title

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => esc_html__( 'Content', 'webman-amplifier' ),
										'fields' => array(

											'content' => array(
												'type' => 'editor',
												//description
												'label' => '',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /content

										), // /fields
									), // /section

								), // /sections
							), // /tab

							//Tab
							'others' => array(
								//Title
								'title'       => esc_html__( 'Others', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'icon' => array(
										'title'  => esc_html__( 'Icon', 'webman-amplifier' ),
										'fields' => array(

											'icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => $codes_globals['font_icons'],
												'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
												'filter'     => true,
												'hide_radio' => true,
												'inline'     => true,
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /icon

										), // /fields
									), // /section

									//Section
									'other' => array(
										'title'  => esc_html__( 'Other parameters', 'webman-amplifier' ),
										'fields' => array(

											'tags' => array(
												'type' => 'text',
												//description
												'label' => esc_html__( 'Tags', 'webman-amplifier' ),
												'help'  => esc_html__( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /tags

											'heading_tag' => array(
												'type' => 'select',
												//description
												'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
												'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
												//type specific
												'options' => $heading_tags,
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

										), // /fields
									), // /section

								), // /sections
							), // /tab

						), // /tabs

					),
				),
				'vc_plugin' => array(
					'name'                    => $prefix['name'] . esc_html__( 'Accordion', 'webman-amplifier' ),
					'base'                    => $prefix['code'] . 'accordion',
					'class'                   => 'wm-shortcode-vc-accordion wm-sections-mode',
					'icon'                    => 'icon-wpb-ui-accordion',
					'show_settings_on_create' => false,
					'is_container'            => true,
					'category'                => esc_html__( 'Content', 'webman-amplifier' ),
					'custom_markup'           => '
						<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-separator-label"></i> ' . esc_html__( 'Accordion', 'webman-amplifier' ) . '</h4>
						<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
							%content%
						</div>
						<div class="tab_controls">
							<button data-item="' . $prefix['code'] . 'item" data-item-title="' . esc_html__( 'Section', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Accordion: Add new section', 'webman-amplifier' ) . '">' . esc_html__( 'Accordion: Add new section', 'webman-amplifier' ) . '</button>
						</div>
					',
					'default_content'         => '
						[' . $prefix['code'] . 'item title="' . esc_html__( 'Section 1', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
						[' . $prefix['code'] . 'item title="' . esc_html__( 'Section 2', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
					',
					'js_view'                 => 'VcCustomAccordionView',
					'params'                  => array(
						10 => array(
							'heading'     => esc_html__( 'Active section', 'webman-amplifier' ),
							'description' => esc_html__( 'Set section order number, "0" for all sections closed', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'active',
							'value'       => 0,
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => esc_html__( 'Mode', 'webman-amplifier' ),
							'type'        => 'dropdown',
							'param_name'  => 'mode',
							'value'       => array(
								esc_html__( 'Accordion (only one section open)', 'webman-amplifier' ) => 'accordion', // default
								esc_html__( 'Toggle (multiple sections open)', 'webman-amplifier' )   => 'toggle',
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						30 => array(
							'heading'     => esc_html__( 'Filtering', 'webman-amplifier' ),
							'description' => esc_html__( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
							'type'        => 'dropdown',
							'param_name'  => 'filter',
							'value'       => array(
								esc_html__( 'No', 'webman-amplifier' )  => '',
								esc_html__( 'Yes', 'webman-amplifier' ) => 1,
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						40 => array(
							'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
							'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			),



			/**
			 * Tabs
			 *
			 * @since  1.0
			 */
			'tabs' => array(
				'since' => '1.0',
				'preprocess' => false,
				'generator' => array(
					'name'  => esc_html__( 'Tabs', 'webman-amplifier' ),
					'code'  => '[PREFIX_tabs active="0" layout="top/left/right" tour="0/1" class=""]<br />[PREFIX_item title="' . esc_html__( 'Tab 1', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . esc_html__( 'Tab 2', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""][/PREFIX_item]<br />[/PREFIX_tabs]',
					'short' => false,
				),
				'bb_plugin' => array(
					'name' => esc_html__( 'Tabs', 'webman-amplifier' ),
					'output' => '[PREFIX_tabs{{layout}}{{tour}}{{active}}{{class}}]{{children}}[/PREFIX_tabs]',
					'output_children' => '[PREFIX_item{{title}}{{icon}}{{tags}}{{heading_tag}}]{{content}}[/PREFIX_item]',
					'params' => array( 'layout', 'tour', 'active', 'class' ),
					'params_children' => array( 'title', 'content', 'icon', 'tags', 'heading_tag' ),
					'form' => array(

						//Tab
						'general' => array(
							//Title
							'title'       => esc_html__( 'General', 'webman-amplifier' ),
							'description' => '',
							//Sections
							'sections' => array(

								//Section
								'general' => array(
									'title'  => '',
									'fields' => array(

										'layout' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Layout', 'webman-amplifier' ),
											//type specific
											'options' => array(
												'top'   => esc_html__( 'Tabs on top', 'webman-amplifier' ),
												'left'  => esc_html__( 'Tabs on left', 'webman-amplifier' ),
												'right' => esc_html__( 'Tabs on right', 'webman-amplifier' ),
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /layout

									), // /fields
								), // /section

								//Section
								'sections' => array(
									'title'  => esc_html__( 'Sections', 'webman-amplifier' ),
									'fields' => array(

										'children' => array(
											'type' => 'form',
											//description
											'label'       => '',
											'description' => '',
											'help'        => '',
											//default
											'default' => array( 'title' => esc_html__( 'Section', 'webman-amplifier' ) ), //This will be converted automatically
											//type specific
											'form'         => 'wm_children_form_' . 'tabs',
											'preview_text' => 'title', //DO NOT FORGET TO SET!
											//multiple
											'multiple' => true,
											//preview
											'preview' => array( 'type' => 'refresh' ),
										), // /children

									), // /fields
								), // /section

							), // /sections
						), // /tab

						//Tab
						'others' => array(
							//Title
							'title'       => esc_html__( 'Others', 'webman-amplifier' ),
							'description' => '',
							//Sections
							'sections' => array(

								//Section
								'general' => array(
									'title'  => '',
									'fields' => array(

										'tour' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Enable tour mode?', 'webman-amplifier' ),
											//type specific
											'options' => array(
												'' => esc_html__( 'No', 'webman-amplifier' ),
												1  => esc_html__( 'Yes', 'webman-amplifier' ),
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /tour

										'active' => array(
											'type' => 'select',
											//description
											'label' => esc_html__( 'Active tab number', 'webman-amplifier' ),
											//default
											'default' => 1,
											//type specific
											'options' => array(
												1   => 1,
												2   => 2,
												3   => 3,
												4   => 4,
												5   => 5,
												6   => 6,
												7   => 7,
												8   => 8,
												9   => 9,
												10  => 10,
											),
											//preview
											'preview' => array( 'type' => 'none' ),
										), // /active

									), // /fields
								), // /section

							), // /sections
						), // /tab

					),
					'form_children' => array(

						//Title
						'title' => esc_html__( 'Section', 'webman-amplifier' ),
						//Tabs
						'tabs' => array(

							//Tab
							'general' => array(
								//Title
								'title'       => esc_html__( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'title' => array(
										'title'  => '',
										'fields' => array(

											'title' => array(
												'type' => 'text',
												//description
												'label' => esc_html__( 'Title', 'webman-amplifier' ),
												//default
												'default' => esc_html__( 'Section', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /title

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => esc_html__( 'Content', 'webman-amplifier' ),
										'fields' => array(

											'content' => array(
												'type' => 'editor',
												//description
												'label' => '',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /content

										), // /fields
									), // /section

								), // /sections
							), // /tab

							//Tab
							'others' => array(
								//Title
								'title'       => esc_html__( 'Others', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'icon' => array(
										'title'  => esc_html__( 'Icon', 'webman-amplifier' ),
										'fields' => array(

											'icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => $codes_globals['font_icons'],
												'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
												'filter'     => true,
												'hide_radio' => true,
												'inline'     => true,
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /icon

										), // /fields
									), // /section

									//Section
									'other' => array(
										'title'  => esc_html__( 'Other parameters', 'webman-amplifier' ),
										'fields' => array(

											'heading_tag' => array(
												'type' => 'select',
												//description
												'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
												'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
												//type specific
												'options' => $heading_tags,
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

										), // /fields
									), // /section

								), // /sections
							), // /tab

						), // /tabs

					),
				),
				'vc_plugin' => array(
					'name'                    => $prefix['name'] . esc_html__( 'Tabs', 'webman-amplifier' ),
					'base'                    => $prefix['code'] . 'tabs',
					'class'                   => 'wm-shortcode-vc-tabs wm-sections-mode',
					'icon'                    => 'icon-wpb-ui-tab-content',
					'show_settings_on_create' => false,
					'is_container'            => true,
					'category'                => esc_html__( 'Content', 'webman-amplifier' ),
					'custom_markup'           => '
						<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-tab-content"></i> ' . esc_html__( 'Tabs', 'webman-amplifier' ) . '</h4>
						<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
							%content%
						</div>
						<div class="tab_controls">
							<button data-item="' . $prefix['code'] . 'item" data-item-title="' . esc_html__( 'Tab', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Tabs: Add new tab', 'webman-amplifier' ) . '">' . esc_html__( 'Tabs: Add new tab', 'webman-amplifier' ) . '</button>
						</div>
					',
					'default_content'         => '
						[' . $prefix['code'] . 'item title="' . esc_html__( 'Tab 1', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
						[' . $prefix['code'] . 'item title="' . esc_html__( 'Tab 2', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
					',
					'js_view'                 => 'VcCustomAccordionView',
					'params'                  => array(
						10 => array(
							'heading'     => esc_html__( 'Active tab', 'webman-amplifier' ),
							'description' => esc_html__( 'Enter the order number of the tab which should be open by default', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'active',
							'value'       => 1,
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => esc_html__( 'Layout', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'layout',
							'value'       => array(
								esc_html__( 'Tabs on top', 'webman-amplifier' )   => 'top', // default
								esc_html__( 'Tabs on left', 'webman-amplifier' )  => 'left',
								esc_html__( 'Tabs on right', 'webman-amplifier' ) => 'right',
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						30 => array(
							'heading'     => esc_html__( 'Enable tour mode?', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'tour',
							'value'       => array(
								esc_html__( 'No', 'webman-amplifier' )  => '',
								esc_html__( 'Yes', 'webman-amplifier' ) => 1,
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						40 => array(
							'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
							'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			),



			/**
			 * Item
			 *
			 * @since  1.0
			 */
			'item' => array(
				'since' => '1.0',
				'preprocess' => false,
				'generator' => array(
					'name'  => esc_html__( 'Item (Accordion or Tab Section)', 'webman-amplifier' ),
					'code'  => '[PREFIX_item title="' . esc_html__( 'Title', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]',
					'short' => false,
				),
				'vc_plugin' => array(
					'name'                      => $prefix['name'] . esc_html__( 'Item (Accordion / Tab)', 'webman-amplifier' ),
					'base'                      => $prefix['code'] . 'item',
					'class'                     => 'wm-shortcode-vc-item wm-sections-mode-section wpb_vc_accordion_tab',
					'allowed_container_element' => 'vc_row',
					'is_container'              => true,
					'content_element'           => false,
					'category'                  => esc_html__( 'Content', 'webman-amplifier' ),
					'js_view'                   => 'VcCustomAccordionTabView',
					'params'                    => array(
						10 => array(
							'heading'    => esc_html__( 'Title', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'title',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),
						20 => array(
							'heading'     => esc_html__( 'Icon', 'webman-amplifier' ),
							'type'        => 'wm_radio',
							'param_name'  => 'icon',
							'value'       => $codes_globals['font_icons'],
							'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
							'filter'      => true,
							'hide_radio'  => true,
							'inline'      => true,
							'holder'      => 'hidden',
							'class'       => '',
						),
						30 => array(
							'heading'     => esc_html__( 'Tags', 'webman-amplifier' ),
							'description' => esc_html__( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'tags',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						40 => array(
							'heading'     => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'heading_tag',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			),



	  /**
		 * Audio
		 *
		 * @since  1.0
		 */
		'audio' => array(
			'since'  => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Audio', 'webman-amplifier' ),
				'code'  => '[PREFIX_audio src="" autoplay="0/1" loop="0/1" class="" /]',
				'short' => false,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Audio', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'audio',
				'class'    => 'wm-shortcode-vc-audio',
				'category' => esc_html__( 'Media', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Audio source', 'webman-amplifier' ),
						'description' => esc_html__( 'Set the audio URL', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'src',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Autoplay the audio?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'autoplay',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Loop the audio?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'loop',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



	  /**
		 * Button
		 *
		 * @since  1.0
		 */
		'button' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Button', 'webman-amplifier' ),
				'code'  => '[PREFIX_button url="#" color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_button]',
				'short' => true,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Button', 'webman-amplifier' ),
				'output' => '[PREFIX_button{{url}}{{target}}{{color}}{{size}}{{icon}}{{class}}]{{content}}[/PREFIX_button]',
				'params' => array( 'url', 'target', 'color', 'size', 'icon', 'class', 'content' ),
				'wpml_fields' => array(
					array(
						'field'       => 'content',
						'type'        => esc_html__( 'Button text', 'webman-amplifier' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'url',
						'type'        => esc_html__( 'Button link URL', 'webman-amplifier' ),
						'editor_type' => 'LINK',
					),
				),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'content' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Button text', 'webman-amplifier' ),
										//default
										'default' => esc_html__( 'Button Text', 'webman-amplifier' ),
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /content

									'url' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Button link URL', 'webman-amplifier' ),
										//default
										'default' => '#',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /url

									'target' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Target', 'webman-amplifier' ),
										'help'  => esc_html__( 'Button link target', 'webman-amplifier' ),
										//type specific
										'options' => array(
											''       => esc_html__( 'Open in same window', 'webman-amplifier' ),
											'_blank' => esc_html__( 'Open in new window / tab', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /target

									'color' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Color', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['colors'],
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /color

									'size' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Size', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['sizes']['options'],
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /size

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'icon' => array(
						//Title
						'title'       => esc_html__( 'Icon', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'icon' => array(
								'title'  => esc_html__( 'Icon', 'webman-amplifier' ),
								'fields' => array(

									'icon' => array(
										'type' => 'wm_radio',
										//description
										'label' => '',
										//type specific
										'options'    => $codes_globals['font_icons'],
										'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
										'filter'     => true,
										'hide_radio' => true,
										'inline'     => true,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /icon

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Button', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'button',
				'class'    => 'wm-shortcode-vc-button',
				'icon'     => 'icon-wpb-ui-button',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'    => esc_html__( 'Button text', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'content',
						'value'      => esc_html__( 'Button Text', 'webman-amplifier' ),
						'holder'     => 'div',
						'class'      => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Button URL', 'webman-amplifier' ),
						'description' => esc_html__( 'Set the button link URL', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'url',
						'value'       => '#',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
						'description' => esc_html__( 'Button link target', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'target',
						'value'       => array(
							esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
							esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
						),
						'holder'      => 'hidden',
						'class'       => '',
						'dependency'  => array(
							'element'   => 'url',
							'not_empty' => true
						),
					),
					40 => array(
						'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'color',
						'value'      => $empty + array_flip( $codes_globals['colors'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					50 => array(
						'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'size',
						'value'      => $empty + array_flip( $codes_globals['sizes']['options'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					60 => array(
						'heading'     => esc_html__( 'Icon', 'webman-amplifier' ),
						'type'        => 'wm_radio',
						'param_name'  => 'icon',
						'value'       => $codes_globals['font_icons'],
						'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
						'filter'      => true,
						'hide_radio'  => true,
						'inline'      => true,
						'holder'      => 'hidden',
						'class'       => '',
					),
					70 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					80 => array(
						'heading'     => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'id',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



	  /**
		 * Call to Action
		 *
		 * @since  1.0
		 */
		'call_to_action' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Call to Action', 'webman-amplifier' ),
				'code'  => '[PREFIX_call_to_action caption="" button_text="" button_url="#" button_color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" button_size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" button_icon="" class=""]{{content}}[/PREFIX_call_to_action]',
				'short' => false,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Call to Action', 'webman-amplifier' ),
				'output' => '[PREFIX_call_to_action{{caption}}{{heading_tag}}{{button_text}}{{button_url}}{{target}}{{button_color}}{{button_size}}{{button_icon}}{{class}}]{{content}}[/PREFIX_call_to_action]',
				'params' => array( 'caption', 'heading_tag', 'button_text', 'button_url', 'target', 'button_color', 'button_size', 'button_icon', 'class', 'content' ),
				'wpml_fields' => array(
					array(
						'field'       => 'caption',
						'type'        => esc_html__( 'Caption', 'webman-amplifier' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'content',
						'type'        => esc_html__( 'Content', 'webman-amplifier' ),
						'editor_type' => 'VISUAL',
					),
					array(
						'field'       => 'button_text',
						'type'        => esc_html__( 'Button text', 'webman-amplifier' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'button_url',
						'type'        => esc_html__( 'Button link URL', 'webman-amplifier' ),
						'editor_type' => 'LINK',
					),
				),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'caption' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Caption', 'webman-amplifier' ),
										//default
										'default' => '',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /caption

									'heading_tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Caption HTML tag', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
										//type specific
										'options' => $heading_tags,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /heading_tag

									), // /fields
								), // /section

							//Section
							'content' => array(
								'title'  => esc_html__( 'Content', 'webman-amplifier' ),
								'fields' => array(

									'content' => array(
										'type' => 'editor',
										//description
										'label' => '',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /content

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'button' => array(
						//Title
						'title'       => esc_html__( 'Button', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'button_text' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Button text', 'webman-amplifier' ),
										//default
										'default' => '',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /button_text

									'button_url' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Button link URL', 'webman-amplifier' ),
										//default
										'default' => '',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /button_url

									'target' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Target', 'webman-amplifier' ),
										'help'  => esc_html__( 'Button link target', 'webman-amplifier' ),
										//type specific
										'options' => array(
											''       => esc_html__( 'Open in same window', 'webman-amplifier' ),
											'_blank' => esc_html__( 'Open in new window / tab', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /target

									'button_color' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Button color', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['colors'],
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /button_color

									'button_size' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Button size', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['sizes']['options'],
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /button_size

								), // /fields
							), // /section

							//Section
							'icon' => array(
								'title'  => esc_html__( 'Button icon', 'webman-amplifier' ),
								'fields' => array(

									'button_icon' => array(
										'type' => 'wm_radio',
										//description
										'label' => '',
										//type specific
										'options'    => $codes_globals['font_icons'],
										'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
										'filter'     => true,
										'hide_radio' => true,
										'inline'     => true,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /button_icon

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Call to Action', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'call_to_action',
				'class'    => 'wm-shortcode-vc-call_to_action',
				'icon'     => 'icon-wpb-call-to-action',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'caption',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Content text', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Button text', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'button_text',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
						40 => array(
							'heading'    => esc_html__( 'Button link URL', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'button_url',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),
						50 => array(
							'heading'     => esc_html__( 'Button link target', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'target',
							'value'       => array(
								esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
								esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						60 => array(
							'heading'     => esc_html__( 'Button color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'button_color',
							'value'       => $empty + array_flip( $codes_globals['colors'] ),
							'holder'      => 'hidden',
							'class'       => '',
						),
						70 => array(
							'heading'     => esc_html__( 'Button size', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'button_size',
							'value'       => $empty + array_flip( $codes_globals['sizes']['options'] ),
							'holder'      => 'hidden',
							'class'       => '',
						),
						80 => array(
							'heading'     => esc_html__( 'Button icon', 'webman-amplifier' ),
							'description' => esc_html__( 'Choose one of available icons', 'webman-amplifier' ),
							'type'        => 'wm_radio',
							'param_name'  => 'button_icon',
							'value'       => $codes_globals['font_icons'],
							'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
							'filter'      => true,
							'hide_radio'  => true,
							'inline'      => true,
							'holder'      => 'hidden',
							'class'       => '',
						),
					90 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Collumn
		 *
		 * @since  1.0
		 */
		'column' => array(
			'since'  => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Column', 'webman-amplifier' ),
				'code'  => ( wma_is_active_vc() ) ? ( '[vc_column width="1/1,1/2,1/3,2/3,1/4,3/4,1/6,5/6" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/vc_column]' ) : ( '[PREFIX_column width="' . implode( ',', $codes_globals['column_widths'] ) . '" last="0/1" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/PREFIX_column]' ),
				'short' => false,
			),
		),



		/**
		 * Countdown Timer
		 *
		 * @since  1.0
		 */
		'countdown_timer' => array(
			'since'  => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Countdown Timer', 'webman-amplifier' ),
				'code'  => '[PREFIX_countdown_timer time="' . date( get_option( 'date_format' ), strtotime( 'now' ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" class="" /]',
				'short' => false,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Countdown Timer', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'countdown_timer',
				'class'    => 'wm-shortcode-vc-countdown_timer',
				'icon'     => 'vc_icon-vc-gitem-post-date',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'    => esc_html__( 'Time', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'time',
						'value'      => date( get_option( 'date_format' ), strtotime( 'now' ) ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'size',
						'value'      => $empty + array_flip( $codes_globals['sizes']['options'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					30 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Content Module
		 *
		 * @since  1.0
		 */
		'content_module' => array(
			'since' => '1.0',
			'post_type_required' => 'wm_modules',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Content Module', 'webman-amplifier' ),
				'code'  => '[PREFIX_content_module module="module-slug" align="left/right" columns="4" count="8" order="new/old/name/random" tag="" image_size="" filter="0/1" scroll="0" pagination="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_content_module]',
				'short' => false,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Content Module', 'webman-amplifier' ),
				'output' => '[PREFIX_content_module{{module}}{{align}}{{columns}}{{count}}{{order}}{{tag}}{{image_size}}{{filter}}{{scroll}}{{pagination}}{{no_margin}}{{heading_tag}}{{layout}}{{class}}]{{content}}[/PREFIX_content_module]',
				'params' => array( 'module', 'align', 'columns', 'count', 'order', 'tag', 'image_size', 'filter', 'scroll', 'pagination', 'no_margin', 'heading_tag', 'layout', 'class', 'content' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'single' => array(
								'title'  => esc_html__( 'Single module display', 'webman-amplifier' ),
								'fields' => array(

									'module' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Single module', 'webman-amplifier' ),
										'help'  => esc_html__( 'Leave empty to display multiple modules', 'webman-amplifier' ),
										//type specific
										'options' => $wm_modules_slugs,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /module

								), // /fields
							), // /section

							//Section
							'multiple' => array(
								'title'  => esc_html__( 'Multiple modules display', 'webman-amplifier' ),
								'fields' => array(

									'count' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Count', 'webman-amplifier' ),
										'help'  => esc_html__( 'Number of items to display', 'webman-amplifier' ),
										//default
										'default' => 3,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /count

									'columns' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Columns', 'webman-amplifier' ),
										//default
										'default' => 3,
										//type specific
										'options' => array(
												1 => 1,
												2 => 2,
												3 => 3,
												4 => 4,
												5 => 5,
												6 => 6,
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /columns

									'order' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Order', 'webman-amplifier' ),
										//type specific
										'options' => array(
												'new'      => esc_html__( 'Newest first', 'webman-amplifier' ),
												'old'      => esc_html__( 'Oldest first', 'webman-amplifier' ),
												'name'     => esc_html__( 'By name', 'webman-amplifier' ),
												'random'   => esc_html__( 'Randomly', 'webman-amplifier' ),
												'menuasc'  => esc_html__( 'Custom, ascending', 'webman-amplifier' ),
												'menudesc' => esc_html__( 'Custom, descending', 'webman-amplifier' ),
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /order

									'filter' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Filtering', 'webman-amplifier' ),
										'help'  => esc_html__( 'Display the modules filter from module tags?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /filter

									'scroll' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
										'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /scroll

									'tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Tagged as', 'webman-amplifier' ),
										'help'  => esc_html__( 'Display specifically tagged items only', 'webman-amplifier' ),
										//type specific
										'options' => $wm_modules_tags,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /tag

									'pagination' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Display pagination?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /pagination

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'description' => array(
						//Title
						'title'       => esc_html__( 'Description', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'description' => array(
								'title'  => '',
								'fields' => array(

									'align' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Description alignment', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'left'  => esc_html__( 'Left', 'webman-amplifier' ),
											'right' => esc_html__( 'Right', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /align

								), // /fields
							), // /section

							//Section
							'content' => array(
								'title'  => esc_html__( 'Content', 'webman-amplifier' ),
								'fields' => array(

									'content' => array(
										'type' => 'editor',
										//description
										'label' => '',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /content

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'others' => array(
						//Title
						'title'       => esc_html__( 'Others', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'no_margin' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /no_margin

									'image_size' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Image size', 'webman-amplifier' ),
										//type specific
										'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /image_size

									'heading_tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
										//type specific
										'options' => $heading_tags,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /heading_tag

									'layout' => array(
										'type' => 'text',
										//description
										'label'       => esc_html__( 'Custom layout', 'webman-amplifier' ),
										'description' => '<br />' . sprintf( esc_html__( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /layout

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Content Module', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'content_module',
				'class'    => 'wm-shortcode-vc-content_module',
				'icon'     => 'icon-wpb-toggle-small-expand',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Single module', 'webman-amplifier' ),
						'description' => esc_html__( 'Leave empty to display multiple modules', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'module',
						'value'       => array_flip( $wm_modules_slugs ), // 1st value is empty
						'holder'      => 'div',
						'class'       => '',
					),

					20 => array(
						'heading'     => esc_html__( 'Count', 'webman-amplifier' ),
						'description' => esc_html__( 'Number of items to display', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'count',
						'value'       => 3,
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					30 => array(
						'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'columns',
						'value'      => array(
							'' => '', // not forcing default to 1
							1  => 1,
							2  => 2,
							3  => 3,
							4  => 4,
							5  => 5,
							6  => 6,
						),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					40 => array(
						'heading'    => esc_html__( 'Order', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'order',
						'value'      => array(
							esc_html__( 'Newest first', 'webman-amplifier' )       => 'new', // default
							esc_html__( 'Oldest first', 'webman-amplifier' )       => 'old',
							esc_html__( 'By name', 'webman-amplifier' )            => 'name',
							esc_html__( 'Randomly', 'webman-amplifier' )           => 'random',
							esc_html__( 'Custom, ascending', 'webman-amplifier' )  => 'menuasc',
							esc_html__( 'Custom, descending', 'webman-amplifier' ) => 'menudesc',
						),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Filter', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'filter',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
						'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'scroll',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					70 => array(
						'heading'     => esc_html__( 'Tag', 'webman-amplifier' ),
						'description' => esc_html__( 'Display specifically tagged items only', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'tag',
						'value'       => array_flip( $wm_modules_tags ), // 1st value is empty
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					80 => array(
						'heading'     => esc_html__( 'Display pagination?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'pagination',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					90 => array(
						'heading'     => esc_html__( 'Description text (HTML)', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					100 => array(
						'heading'     => esc_html__( 'Description alignment', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'align',
						'value'       => array(
							esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
							esc_html__( 'Right', 'webman-amplifier' ) => 'right',
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					110 => array(
						'heading'     => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'no_margin',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),

					120 => array(
						'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'image_size',
						'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Layout', 'webman-amplifier' ),
					),
					130 => array(
						'heading'     => esc_html__( 'Custom layout', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
						'type'        => 'textfield',
						'param_name'  => 'layout',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Layout', 'webman-amplifier' ),
					),

					140 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Divider
		 *
		 * @since  1.0
		 */
		'divider' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
				'code' => '[PREFIX_divider appearance="' . implode( '/', array_keys( wma_ksort( $codes_globals['divider_appearance'] ) ) ) . '" space_before="" space_after="" class="" /]',
				'short' => true,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
				'output' => '[PREFIX_divider{{appearance}}{{class}} /]',
				'params' => array( 'appearance', 'class' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'appearance' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Appearance', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['divider_appearance'],
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /appearance

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin'  => array(
				'name'                    => $prefix['name'] . esc_html__( 'Divider / Gap', 'webman-amplifier' ),
				'base'                    => $prefix['code'] . 'divider',
				'class'                   => 'wm-shortcode-vc-divider',
				'icon'                    => 'icon-wpb-ui-separator',
				'show_settings_on_create' => false,
				'category'                => esc_html__( 'Content', 'webman-amplifier' ),
				'params'                  => array(
					10 => array(
						'heading'     => esc_html__( 'Appearance', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'appearance',
						'value'       => array_flip( $codes_globals['divider_appearance'] ),
						'holder'      => 'div',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Space before divider', 'webman-amplifier' ),
						'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'space_before',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Space after divider', 'webman-amplifier' ),
						'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'space_after',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					50 => array(
						'heading'     => esc_html__( 'CSS styles', 'webman-amplifier' ),
						'description' => esc_html__( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'style',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Dropcap
		 *
		 * @since  1.0
		 */
		'dropcap' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name' => esc_html__( 'Dropcap', 'webman-amplifier' ),
				'code' => '[PREFIX_dropcap color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" shape="' . implode( '/', array_keys( wma_ksort( $codes_globals['dropcap_shapes'] ) ) ) . '" class=""]{{content}}[/PREFIX_dropcap]',
				'short' => true,
			),
		),



		/**
		 * Icon
		 *
		 * @since  1.0
		 */
		'icon' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
				'code'  => '[PREFIX_icon class="icon-class" social="' . implode( '/', $wm_social_icons_array ) . '" url="" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" /]',
				'short' => true,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'icon',
				'class'    => 'wm-shortcode-vc-icon',
				'icon'     => 'icon-wpb-vc_icon',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'    => esc_html__( 'Icon', 'webman-amplifier' ),
						'type'       => 'wm_radio',
						'param_name' => 'icon',
						'value'      => $codes_globals['font_icons'],
						'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
						'filter'     => true,
						'hide_radio' => true,
						'inline'     => true,
						'holder'     => 'div',
						'class'      => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'size',
						'value'      => $empty + array_flip( $codes_globals['sizes']['options'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),

					30 => array(
						'heading'    => esc_html__( 'Social icon?', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'social',
						'value'      => $wm_social_icons_array, // 1st value is empty
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Social icon', 'webman-amplifier' ),
					),
					40 => array(
						'heading'    => esc_html__( 'Social icon link URL', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'url',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Social icon', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'target',
						'value'       => array(
							esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
							esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Social icon title', 'webman-amplifier' ),
						'description' => esc_html__( 'Will be displayed when mouse hovers over the icon', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'title',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
					),
					70 => array(
						'heading'     => esc_html__( 'Social icon relation', 'webman-amplifier' ),
						'description' => esc_html__( 'The HTML "rel" attribute', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'rel',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
					),

					80 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					90 => array(
						'heading'     => esc_html__( 'CSS styles', 'webman-amplifier' ),
						'description' => esc_html__( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'style',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Icon List
		 *
		 * @since  1.0
		 */
		'list' => array(
			'since'  => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Icon List', 'webman-amplifier' ),
				'code'  => '[PREFIX_list bullet="icon-class" class=""]<ul><li>{{content}}</li><li>' . esc_html__( 'List item', 'webman-amplifier' ) . '</li></ul>[/PREFIX_list]',
				'short' => true,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Icon List', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'list',
				'class'    => 'wm-shortcode-vc-list',
				'icon'     => 'icon-wpb-vc_icon',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'List items (insert unordered list only)', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => '<ul><li>TEXT</li><li>TEXT</li></ul>',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Bullet icon', 'webman-amplifier' ),
						'type'       => 'wm_radio',
						'param_name' => 'bullet',
						'value'      => $codes_globals['font_icons'],
						'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
						'filter'     => true,
						'hide_radio' => true,
						'inline'     => true,
						'holder'     => 'div',
						'class'      => '',
					),
					30 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Last Update Time
		 *
		 * @since  1.0
		 */
		'last_update' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Last Update Time', 'webman-amplifier' ),
				'code'  => '[PREFIX_last_update post_type="' . implode( '/', array_merge( array( 'post', 'page' ), get_post_types( array( '_builtin' => false ) ) ) ) . '" format="" class="" /]',
				'short' => true,
			),
		),



		/**
		 * Marker
		 *
		 * @since  1.0
		 */
		'marker' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Marker', 'webman-amplifier' ),
				'code'  => '[PREFIX_marker color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" class=""]{{content}}[/PREFIX_marker]',
				'short' => true,
			),
		),



		/**
		 * Message
		 *
		 * @since  1.0
		 */
		'message' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name' => esc_html__( 'Message', 'webman-amplifier' ),
				'code' => '[PREFIX_message title="" color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_message]',
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Message', 'webman-amplifier' ),
				'output' => '[PREFIX_message{{title}}{{heading_tag}}{{color}}{{size}}{{icon}}{{class}}]{{content}}[/PREFIX_message]',
				'params' => array( 'title', 'heading_tag', 'color', 'size', 'icon', 'class', 'content' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'title' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Caption', 'webman-amplifier' ),
										//default
										'default' => '',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /title

									'heading_tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Caption HTML tag', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
										//type specific
										'options' => $heading_tags,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /heading_tag

									), // /fields
								), // /section

								//Section
								'content' => array(
									'title'  => esc_html__( 'Content', 'webman-amplifier' ),
									'fields' => array(

										'content' => array(
											'type' => 'editor',
											//description
											'label' => '',
											//preview
											'preview' => array( 'type' => 'refresh' ),
										), // /content

									), // /fields
								), // /section

						), // /sections
					), // /tab

					//Tab
					'icon' => array(
						//Title
						'title'       => esc_html__( 'Icon', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'icon' => array(
								'title'  => esc_html__( 'Icon', 'webman-amplifier' ),
								'fields' => array(

									'icon' => array(
										'type' => 'wm_radio',
										//description
										'label' => '',
										//type specific
										'options'    => $codes_globals['font_icons'],
										'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
										'filter'     => true,
										'hide_radio' => true,
										'inline'     => true,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /icon

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'others' => array(
						//Title
						'title'       => esc_html__( 'Others', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'color' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Color', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['colors'],
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /color

									'size' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Size', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['sizes']['options'],
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /size

									), // /fields
								), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Message', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'message',
				'class'    => 'wm-shortcode-vc-message',
				'icon'     => 'icon-wpb-information-white',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'    => esc_html__( 'Caption', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'title',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Content', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'color',
						'value'      => $empty + array_flip( $codes_globals['colors'] ),
						'holder'     => 'div',
						'class'      => '',
					),
					40 => array(
						'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'size',
						'value'      => $empty + array_flip( $codes_globals['sizes']['options'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					50 => array(
						'heading'    => esc_html__( 'Icon', 'webman-amplifier' ),
						'type'       => 'wm_radio',
						'param_name' => 'icon',
						'value'      => $codes_globals['font_icons'],
						'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
						'filter'     => true,
						'hide_radio' => true,
						'inline'     => true,
						'holder'     => 'hidden',
						'class'      => '',
					),
					60 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Meta
		 *
		 * @since  1.0.9
		 */
		'meta' => array(
			'since' => '1.0.9',
			'preprocess' => false,
			'generator' => array(),
		),



		/**
		 * Posts
		 *
		 * @since  1.0
		 */
		'posts' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
				'code'  => '[PREFIX_posts post_type="' . implode( '/', array_keys( wma_ksort( $codes_globals['post_types'] ) ) ) . '" align="left/right" columns="4" count="8" image_size="" order="new/old/name/random" taxonomy="taxonomy_name:taxonomy_slug" filter="taxonomy_name" scroll="0" pagination="0/1" related="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_posts]',
				'short' => false,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
				'output' => '[PREFIX_posts{{post_type}}{{align}}{{columns}}{{count}}{{order}}{{taxonomy}}{{image_size}}{{filter}}{{scroll}}{{pagination}}{{related}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_posts]',
				'params' => array( 'post_type', 'align', 'columns', 'count', 'order', 'taxonomy', 'image_size', 'filter', 'scroll', 'pagination', 'related', 'no_margin', 'heading_tag', 'class', 'content' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'post_type' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Post type', 'webman-amplifier' ),
										'help'  => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['post_types'],
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /post_type

									'count' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Count', 'webman-amplifier' ),
										'help'  => esc_html__( 'Number of items to display', 'webman-amplifier' ),
										//default
										'default' => 3,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /count

									'columns' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Columns', 'webman-amplifier' ),
										//default
										'default' => 3,
										//type specific
										'options' => array(
												1 => 1,
												2 => 2,
												3 => 3,
												4 => 4,
												5 => 5,
												6 => 6,
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /columns

									'order' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Order', 'webman-amplifier' ),
										//type specific
										'options' => array(
												'new'      => esc_html__( 'Newest first', 'webman-amplifier' ),
												'old'      => esc_html__( 'Oldest first', 'webman-amplifier' ),
												'name'     => esc_html__( 'By name', 'webman-amplifier' ),
												'random'   => esc_html__( 'Randomly', 'webman-amplifier' ),
												'menuasc'  => esc_html__( 'Custom, ascending', 'webman-amplifier' ),
												'menudesc' => esc_html__( 'Custom, descending', 'webman-amplifier' ),
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /order

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'description' => array(
						//Title
						'title'       => esc_html__( 'Description', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'description' => array(
								'title'  => '',
								'fields' => array(

									'align' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Description alignment', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'left'  => esc_html__( 'Left', 'webman-amplifier' ),
											'right' => esc_html__( 'Right', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /align

								), // /fields
							), // /section

							//Section
							'content' => array(
								'title'  => esc_html__( 'Content', 'webman-amplifier' ),
								'fields' => array(

									'content' => array(
										'type' => 'editor',
										//description
										'label' => '',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /content

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'others' => array(
						//Title
						'title'       => esc_html__( 'Others', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'no_margin' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /no_margin

									'taxonomy' => array(
										'type' => 'text',
										//description
										'label'       => esc_html__( 'From taxonomy', 'webman-amplifier' ),
										'description' => '<br />' . esc_html__( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $wm_taxonomies ) . '</code>',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /taxonomy

									'filter' => array(
										'type' => 'text',
										//description
										'label'       => esc_html__( 'Filter by', 'webman-amplifier' ),
										'description' => '<br />' . esc_html__( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $wm_taxonomies ) . '</code>',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /filter

									'filter_layout' => array(
										'type' => 'text',
										//description
										'label'       => esc_html__( 'Filter layout', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /filter_layout

									'scroll' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
										'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /scroll

									'related' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Related by', 'webman-amplifier' ),
										'help'  => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ),
										//type specific
										'options' => wma_asort( array_merge( array( '' => '' ), $wm_taxonomies ) ),
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /related

									'pagination' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Display pagination?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /pagination

									'image_size' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Image size', 'webman-amplifier' ),
										//type specific
										'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /image_size

									'heading_tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
										//type specific
										'options' => $heading_tags,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /heading_tag

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'posts',
				'class'    => 'wm-shortcode-vc-posts',
				'icon'     => 'icon-wpb-vc_carousel',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Post type', 'webman-amplifier' ),
						'description' => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'post_type',
						'value'       => $empty + array_flip( $codes_globals['post_types'] ),
						'holder'      => 'div',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Count', 'webman-amplifier' ),
						'description' => esc_html__( 'Number of items to display', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'count',
						'value'       => 3,
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'columns',
						'value'      => array(
							'' => '', // prevent forcing 1 as default
							1  => 1,
							2  => 2,
							3  => 3,
							4  => 4,
							5  => 5,
							6  => 6,
						),
						'holder'     => 'hidden',
						'class'      => '',
					),
					40 => array(
						'heading'    => esc_html__( 'Order', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'order',
						'value'      => array(
							esc_html__( 'Newest first', 'webman-amplifier' )       => 'new', // default
							esc_html__( 'Oldest first', 'webman-amplifier' )       => 'old',
							esc_html__( 'By name', 'webman-amplifier' )            => 'name',
							esc_html__( 'Randomly', 'webman-amplifier' )           => 'random',
							esc_html__( 'Custom, ascending', 'webman-amplifier' )  => 'menuasc',
							esc_html__( 'Custom, descending', 'webman-amplifier' ) => 'menudesc',
						),
						'holder'     => 'hidden',
						'class'      => '',
					),

					50 => array(
						'heading'     => esc_html__( 'Taxonomy', 'webman-amplifier' ),
						'description' => esc_html__( 'Displays items only from a specific taxonomy. Set a taxonomy name and taxonomy slug separated with colon.', 'webman-amplifier' ) . '<br />' . esc_html__( 'For example: "category:category-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
						'type'        => 'textfield',
						'param_name'  => 'taxonomy',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Relation', 'webman-amplifier' ),
						'description' => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ) . ' ' . esc_html__( 'For example: "category".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
						'type'        => 'textfield',
						'param_name'  => 'related',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
					),

					70 => array(
						'heading'     => esc_html__( 'Filter', 'webman-amplifier' ),
						'description' => esc_html__( 'If set, the items will be filtered. Set a taxonomy name (and optional parent taxonomy slug separated with colon - filter will be created from sub-taxonomies) which will be used to filter the items.', 'webman-amplifier' ) . '<br />' . esc_html__( 'For example: "category" or "category:parent-category-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
						'type'        => 'textfield',
						'param_name'  => 'filter',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
					),
					80 => array(
						'heading'     => esc_html__( 'Filter layout', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'filter_layout',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
					),
					90 => array(
						'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
						'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'scroll',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
					),

					100 => array(
						'heading'     => esc_html__( 'Display pagination?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'pagination',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
					),

					110 => array(
						'heading'     => esc_html__( 'Description text', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Description', 'webman-amplifier' ),
					),
					120 => array(
						'heading'     => esc_html__( 'Description alignment', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'align',
						'value'       => array(
							esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
							esc_html__( 'Right', 'webman-amplifier' ) => 'right',
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Description', 'webman-amplifier' ),
					),

					130 => array(
						'heading'     => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'no_margin',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Layout', 'webman-amplifier' ),
					),
					140 => array(
						'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'image_size',
						'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Layout', 'webman-amplifier' ),
					),

					150 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Pre
		 *
		 * @since  1.0
		 */
		'pre' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Preformated Text', 'webman-amplifier' ),
				'code'  => '[PREFIX_pre]{{content}}[/PREFIX_pre]',
				'short' => true,
			),
		),



		/**
	   * Pricing Table + Price
	   */

			/**
			 * Pricing Table
			 *
			 * @since  1.0
			 */
			'pricing_table' => array(
				'since' => '1.0',
				'preprocess' => false,
				'generator' => array(
					'name'  => esc_html__( 'Pricing Table', 'webman-amplifier' ),
					'code'  => '[PREFIX_pricing_table no_margin="0/1" class=""]<br />[PREFIX_price caption="' . esc_html__( 'Price 1', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]{{content}}[/PREFIX_price]<br />[PREFIX_price caption="' . esc_html__( 'Price 2', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]' . esc_html__( 'Price 2 content goes here', 'webman-amplifier' ) . '[/PREFIX_price]<br />[/PREFIX_pricing_table]',
					'short' => false,
				),
				'vc_plugin' => array(
					'name'                    => $prefix['name'] . esc_html__( 'Pricing Table', 'webman-amplifier' ),
					'base'                    => $prefix['code'] . 'pricing_table',
					'class'                   => 'wm-shortcode-vc-pricing_table wm-sections-mode',
					'show_settings_on_create' => false,
					'is_container'            => true,
					'category'                => esc_html__( 'Content', 'webman-amplifier' ),
					'custom_markup'           => '
						<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon" data-is-container="true"></i> ' . esc_html__( 'Pricing table', 'webman-amplifier' ) . '</h4>
						<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
							%content%
						</div>
						<div class="tab_controls">
							<button data-item="' . $prefix['code'] . 'price" data-item-title="' . esc_html__( 'Price', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Pricing table: Add new price', 'webman-amplifier' ) . '">' . esc_html__( 'Pricing table: Add new price', 'webman-amplifier' ) . '</button>
						</div>
					',
					'default_content'         => '
						[' . $prefix['code'] . 'price caption="' . esc_html__( 'Price 1', 'webman-amplifier' ).'"]' . esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button][/' . $prefix['code'] . 'price]
						[' . $prefix['code'] . 'price caption="' . esc_html__( 'Price 2', 'webman-amplifier' ).'"]' . esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button][/' . $prefix['code'] . 'price]
					',
					'js_view'                 => 'VcCustomPricingTableView',
					'params'                  => array(
						10 => array(
							'heading'     => esc_html__( 'Remove margins between price columns?', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'no_margin',
							'value'       => array(
								esc_html__( 'No', 'webman-amplifier' )  => '',
								esc_html__( 'Yes', 'webman-amplifier' ) => 1,
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
							'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			),



			/**
			 * Price
			 *
			 * @since  1.0
			 */
			'price' => array(
				'since' => '1.0',
				'preprocess' => false,
				'generator' => array(
					'name'  => esc_html__( 'Price', 'webman-amplifier' ),
					'code'  => '[PREFIX_price caption="' . esc_html__( 'Title', 'webman-amplifier' ) . '" cost="99$" color="" color_text="" appearance="default/featured/legend" class=""]{{content}}[/PREFIX_price]',
					'short' => false,
				),
				'vc_plugin' => array(
					'name'            => $prefix['name'] . esc_html__( 'Price', 'webman-amplifier' ),
					'base'            => $prefix['code'] . 'price',
					'class'           => 'wm-shortcode-vc-price',
					'content_element' => false,
					'category'        => esc_html__( 'Content', 'webman-amplifier' ),
					'params'          => array(
						array(
							'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'textfield',
							'param_name'  => 'caption',
							'value'       => '',
							'holder'      => 'div',
							'class'       => '',
						),
						array(
							'heading'    => esc_html__( 'Cost', 'webman-amplifier' ),
							'type'       => 'textarea',
							'param_name' => 'cost',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),
						array(
							'heading'     => esc_html__( 'Features list', 'webman-amplifier' ),
							'description' => esc_html__( 'Insert an unordered list of features', 'webman-amplifier' ),
							'type'        => 'textarea_html',
							'param_name'  => 'content',
							'value'       => esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button]',
							'holder'      => 'hidden',
							'class'       => '',
						),
						array(
							'heading'     => esc_html__( 'Column color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						array(
							'heading'     => esc_html__( 'Column text color', 'webman-amplifier' ),
							'type'        => 'colorpicker',
							'param_name'  => 'color_text',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						array(
							'heading'     => esc_html__( 'Appearance', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'appearance',
							'value'       => array(
								esc_html__( 'Default price column', 'webman-amplifier' )  => '',
								esc_html__( 'Featured price column', 'webman-amplifier' ) => 'featured',
								esc_html__( 'Pricing table legend', 'webman-amplifier' )  => 'legend',
							),
							'holder'      => 'hidden',
							'class'       => '',
						),
						array(
							'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
							'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			),



		/**
		 * Progress Bar
		 *
		 * @since  1.0
		 */
		'progress' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Progress Bar', 'webman-amplifier' ),
				'code'  => '[PREFIX_progress color="' . implode( '/', array_keys( wma_ksort( $codes_globals['colors'] ) ) ) . '" progress="75" class=""]{{content}}[/PREFIX_progress]',
				'short' => false,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Progress Bar', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'progress',
				'class'    => 'wm-shortcode-vc-progress',
				'icon'     => 'icon-wpb-graph',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => esc_html__( 'Progress bar caption', 'webman-amplifier' ),
						'holder'      => 'div',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Progress in %', 'webman-amplifier' ),
						'description' => esc_html__( 'Insert a number between 0 and 100', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'progress',
						'value'       => '75',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'color',
						'value'      => $empty + array_flip( $codes_globals['colors'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Row
		 *
		 * @since  1.0
		 */
		'row' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Row', 'webman-amplifier' ),
				'code'  => ( wma_is_active_vc() ) ? ( '[vc_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/vc_row]' ) : ( '[PREFIX_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/PREFIX_row]' ),
				'short' => false,
			),
		),



		/**
		 * Search Form
		 *
		 * @since  1.0
		 */
		'search_form' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Search Form', 'webman-amplifier' ),
				'code'  => '[PREFIX_search_form /]',
				'short' => true,
			),
		),



		/**
		 * Separator Heading
		 *
		 * @since  1.0
		 */
		'separator_heading' => array(
			'since' => '1.0',
			'preprocess' => true,
			'generator' => array(
				'name'  => esc_html__( 'Separator Heading', 'webman-amplifier' ),
				'code'  => '[PREFIX_separator_heading align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '" tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '" class="" id=""]{{content}}[/PREFIX_separator_heading]',
				'short' => true,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Separator Heading', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'separator_heading',
				'class'    => 'wm-shortcode-vc-separator_heading',
				'icon'     => 'icon-wpb-ui-separator-label',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Heading text', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'div',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Heading size', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'tag',
						'value'       => array_flip( $heading_tags ),
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Text align', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'align',
						'value'       => array(
							esc_html__( 'Left', 'webman-amplifier' )   => 'left', // default
							esc_html__( 'Center', 'webman-amplifier' ) => 'center',
							esc_html__( 'Right', 'webman-amplifier' )  => 'right',
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					50 => array(
						'heading'     => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'id',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Slideshow
		 *
		 * @since  1.0
		 */
		'slideshow' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Slideshow', 'webman-amplifier' ),
				'code'  => '[PREFIX_slideshow ids="" nav="none/thumbs/pagination" size="full/' . implode( '/', get_intermediate_image_sizes() ) . '" speed="3000" class="" /]',
				'short' => false,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Slideshow', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'slideshow',
				'class'    => 'wm-shortcode-vc-slideshow',
				'icon'     => 'icon-wpb-images-carousel',
				'category' => esc_html__( 'Media', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Images', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'attach_images',
						'param_name'  => 'ids',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Navigation', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'nav',
						'value'      => array(
							esc_html__( 'Just Next/Prev button', 'webman-amplifier' ) => '',
							esc_html__( 'Thumbnails', 'webman-amplifier' )            => 'thumbs',
							esc_html__( 'Pagination', 'webman-amplifier' )            => 'pagination',
						),
						'holder'     => 'hidden',
						'class'      => '',
					),
					30 => array(
						'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'image_size',
						'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					40 => array(
						'heading'     => esc_html__( 'Speed in miliseconds', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'speed',
						'value'       => apply_filters( 'wmhook_shortcode_' . 'slideshow_speed', 3000 ),
						'holder'      => 'hidden',
						'class'       => '',
					),
					50 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Table
		 *
		 * @since  1.0
		 */
		'table' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Table', 'webman-amplifier' ),
				'code'  => '[PREFIX_table appearance="' . implode( '/', array_keys( wma_ksort( $codes_globals['table_appearance'] ) ) ) . '" separator="," class=""]{{content}}[/PREFIX_table]',
				'short' => false,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Table', 'webman-amplifier' ),
				'output' => '[PREFIX_table{{appearance}}{{separator}}{{class}}]{{content}}[/PREFIX_table]',
				'params' => array( 'appearance', 'separator', 'class', 'content' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'appearance' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Appearance', 'webman-amplifier' ),
										//type specific
										'options' => $codes_globals['table_appearance'],
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /appearance

									'separator' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'CSV data separator', 'webman-amplifier' ),
										//default
										'default' => ',',
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /separator

								), // /fields
							), // /section

							//Section
							'content' => array(
								'title'  => esc_html__( 'CSV data', 'webman-amplifier' ),
								'fields' => array(

									'content' => array(
										'type' => 'editor',
										//description
										'label' => '',
										//default
										'default' => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /content

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Table', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'table',
				'class'    => 'wm-shortcode-vc-table',
				'icon'     => 'vc_icon-vc-media-grid',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'    => esc_html__( 'CSV data', 'webman-amplifier' ),
						'type'       => 'textarea_html',
						'param_name' => 'content',
						'value'      => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
						'holder'     => 'hidden',
						'class'      => '',
					),
					20 => array(
						'heading'    => esc_html__( 'CSV data separator', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'separator',
						'value'      => ',',
						'holder'     => 'hidden',
						'class'      => '',
					),
					30 => array(
						'heading'    => esc_html__( 'Appearance', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'appearance',
						'value'      => $empty + array_flip( $codes_globals['table_appearance'] ),
						'holder'     => 'hidden',
						'class'      => '',
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Testimonials
		 *
		 * @since  1.0
		 */
		'testimonials' => array(
			'since' => '1.0',
			'post_type_required' => 'wm_testimonials',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Testimonials', 'webman-amplifier' ),
				'code'  => '[PREFIX_testimonials testimonial="testimonial-slug" align="left/right" columns="4" count="8" order="new/old/name/random" category="optional-category-slug" scroll="0" pagination="0/1" no_margin="0/1" class=""]{{content}}[/PREFIX_testimonials]',
				'short' => false,
			),
			'bb_plugin' => array(
				'name' => esc_html__( 'Testimonials', 'webman-amplifier' ),
				'output' => '[PREFIX_testimonials{{testimonial}}{{align}}{{columns}}{{count}}{{order}}{{category}}{{scroll}}{{pagination}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_testimonials]',
				'params' => array( 'testimonial', 'align', 'columns', 'count', 'order', 'category', 'scroll', 'pagination', 'no_margin', 'heading_tag', 'class', 'content' ),
				'form' => array(

					//Tab
					'general' => array(
						//Title
						'title'       => esc_html__( 'General', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'single' => array(
								'title'  => esc_html__( 'Single testimonial display', 'webman-amplifier' ),
								'fields' => array(

									'testimonial' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Single testimonial', 'webman-amplifier' ),
										'help'  => esc_html__( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
										//type specific
										'options' => $wm_testimonials_slugs,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /testimonial

								), // /fields
							), // /section

							//Section
							'multiple' => array(
								'title'  => esc_html__( 'Multiple modules display', 'webman-amplifier' ),
								'fields' => array(

									'count' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Count', 'webman-amplifier' ),
										'help'  => esc_html__( 'Number of items to display', 'webman-amplifier' ),
										//default
										'default' => 3,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /count

									'columns' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Columns', 'webman-amplifier' ),
										//default
										'default' => 3,
										//type specific
										'options' => array(
												1 => 1,
												2 => 2,
												3 => 3,
												4 => 4,
												5 => 5,
												6 => 6,
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /columns

									'order' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Order', 'webman-amplifier' ),
										//type specific
										'options' => array(
												'new'      => esc_html__( 'Newest first', 'webman-amplifier' ),
												'old'      => esc_html__( 'Oldest first', 'webman-amplifier' ),
												'name'     => esc_html__( 'By name', 'webman-amplifier' ),
												'random'   => esc_html__( 'Randomly', 'webman-amplifier' ),
												'menuasc'  => esc_html__( 'Custom, ascending', 'webman-amplifier' ),
												'menudesc' => esc_html__( 'Custom, descending', 'webman-amplifier' ),
											),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /order

									'scroll' => array(
										'type' => 'text',
										//description
										'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
										'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /scroll

									'category' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'From category', 'webman-amplifier' ),
										'help'  => esc_html__( 'Displays items only from a specific category', 'webman-amplifier' ),
										//type specific
										'options' => $wm_testimonials_categories,
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /category

									'pagination' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Display pagination?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /pagination

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'description' => array(
						//Title
						'title'       => esc_html__( 'Description', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'description' => array(
								'title'  => '',
								'fields' => array(

									'align' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Description alignment', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'left'  => esc_html__( 'Left', 'webman-amplifier' ),
											'right' => esc_html__( 'Right', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /align

								), // /fields
							), // /section

							//Section
							'content' => array(
								'title'  => esc_html__( 'Content', 'webman-amplifier' ),
								'fields' => array(

									'content' => array(
										'type' => 'editor',
										//description
										'label' => '',
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /content

								), // /fields
							), // /section

						), // /sections
					), // /tab

					//Tab
					'others' => array(
						//Title
						'title'       => esc_html__( 'Others', 'webman-amplifier' ),
						'description' => '',
						//Sections
						'sections' => array(

							//Section
							'general' => array(
								'title'  => '',
								'fields' => array(

									'no_margin' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
										//type specific
										'options' => array(
											'' => esc_html__( 'No', 'webman-amplifier' ),
											1  => esc_html__( 'Yes', 'webman-amplifier' ),
										),
										//preview
										'preview' => array( 'type' => 'refresh' ),
									), // /no_margin

									'heading_tag' => array(
										'type' => 'select',
										//description
										'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
										'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
										//type specific
										'options' => $heading_tags,
										//preview
										'preview' => array( 'type' => 'none' ),
									), // /heading_tag

								), // /fields
							), // /section

						), // /sections
					), // /tab

				),
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Testimonials', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'testimonials',
				'class'    => 'wm-shortcode-vc-testimonials',
				'icon'     => 'vc_icon-vc-gitem-post-title',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Single testimonial', 'webman-amplifier' ),
						'description' => esc_html__( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'testimonial',
						'value'       => array_flip( $wm_testimonials_slugs ), // 1st value is empty
						'holder'      => 'div',
						'class'       => '',
					),

					20 => array(
						'heading'     => esc_html__( 'Count', 'webman-amplifier' ),
						'description' => esc_html__( 'Number of items to display', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'count',
						'value'       => 3,
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					30 => array(
						'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'columns',
						'value'      => array(
							'' => '', // prevent forcing 1
							1  => 1,
							2  => 2,
							3  => 3,
							4  => 4,
							5  => 5,
							6  => 6,
						),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					40 => array(
						'heading'    => esc_html__( 'Order', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'order',
						'value'      => array(
							esc_html__( 'Newest first', 'webman-amplifier' )       => 'new', // default
							esc_html__( 'Oldest first', 'webman-amplifier' )       => 'old',
							esc_html__( 'By name', 'webman-amplifier' )            => 'name',
							esc_html__( 'Randomly', 'webman-amplifier' )           => 'random',
							esc_html__( 'Custom, ascending', 'webman-amplifier' )  => 'menuasc',
							esc_html__( 'Custom, descending', 'webman-amplifier' ) => 'menudesc',
						),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
						'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'scroll',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Category', 'webman-amplifier' ),
						'description' => esc_html__( 'Displays items only from a specific category', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'category',
						'value'       => array_flip( $wm_testimonials_categories ), // 1st value is empty
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					70 => array(
						'heading'     => esc_html__( 'Display pagination?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'pagination',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					80 => array(
						'heading'     => esc_html__( 'Description text (HTML)', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					90 => array(
						'heading'    => esc_html__( 'Description alignment', 'webman-amplifier' ),
						'type'       => 'dropdown',
						'param_name' => 'align',
						'value'      => array(
							esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
							esc_html__( 'Right', 'webman-amplifier' ) => 'right',
						),
						'holder'     => 'hidden',
						'class'      => '',
						'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),
					100 => array(
						'heading'     => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'no_margin',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 1,
						),
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
					),

					110 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Video
		 *
		 * @since  1.0
		 */
		'video' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Video', 'webman-amplifier' ),
				'code'  => '[PREFIX_video src="" poster="" autoplay="0/1" loop="0/1" class="" /]',
				'short' => false,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Video', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'video',
				'class'    => 'wm-shortcode-vc-video',
				'icon'     => 'icon-wpb-film-youtube',
				'category' => esc_html__( 'Media', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Video source', 'webman-amplifier' ),
						'description' => esc_html__( 'Set the video URL', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'src',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Poster', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional placeholder image', 'webman-amplifier' ),
						'type'        => 'attach_image',
						'param_name'  => 'poster',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Autoplay the video?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'autoplay',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					40 => array(
						'heading'     => esc_html__( 'Loop the video?', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'loop',
						'value'       => array(
							esc_html__( 'No', 'webman-amplifier' )  => '',
							esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					50 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),



		/**
		 * Widgets Area
		 *
		 * @since  1.0
		 */
		'widget_area' => array(
			'since' => '1.0',
			'preprocess' => false,
			'generator' => array(
				'name'  => esc_html__( 'Widgets Area', 'webman-amplifier' ),
				'code'  => '[PREFIX_widget_area area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '" class="" max_widgets_count="0" /]',
				'short' => true,
			),
			'vc_plugin' => array(
				'name'     => $prefix['name'] . esc_html__( 'Widgets Area', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'widget_area',
				'class'    => 'wm-shortcode-vc-widget_area',
				'icon'     => 'icon-wpb-layout_sidebar',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Widgets area', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'area',
						'value'       => array_flip( wma_widget_areas_array() ), // 1st value is empty
						'holder'      => 'div',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'Maximum widgets count', 'webman-amplifier' ),
						'description' => esc_html__( 'Area will not be displayed when the number of widgets inserted in it is greater', 'webman-amplifier' ),
						'type'        => 'dropdown',
						'param_name'  => 'max_widgets_count',
						'value'       => array(
							'' => '',
							1  => 1,
							2  => 2,
							3  => 3,
							4  => 4,
							5  => 5,
							6  => 6,
							7  => 7,
							8  => 8,
							9  => 9,
							10 => 10,
							11 => 11,
							12 => 12,
						),
						'holder'      => 'hidden',
						'class'       => '',
					),
					30 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		),





	);





	/**
	 * Visual Composer helper shortcodes
	 */

		/**
		 * Redefine (extend) the vc_row shortcode
		 *
		 * @since  1.0
		 */
		$shortcode_definitions['vc_row'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'                    => esc_html__( 'Row', 'webman-amplifier' ),
				'base'                    => 'vc_row',
				'class'                   => 'wm-shortcode-vc-row',
				'icon'                    => 'icon-wpb-row',
				'category'                => esc_html__( 'Structure', 'webman-amplifier' ),
				'is_container'            => true,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
					10 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'id',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
					),

					30 => array(
						'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'bg_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					40 => array(
						'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'font_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'attach_image',
						'param_name'  => 'bg_image',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Parallax scroll speed', 'webman-amplifier' ),
						'description' => esc_html__( 'Set the inertia of parallax background moving. For example, value of <code>0.1</code> equals to tenth of normal scroll speed.', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'parallax',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'dependency'  => array(
							'element'   => 'bg_image',
							'not_empty' => true
						),
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					70 => array(
						'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
						'type'        => 'textfield',
						'param_name'  => 'padding',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					80 => array(
						'heading'     => esc_html__( 'Margin', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
						'type'        => 'textfield',
						'param_name'  => 'margin',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
				),
			),
		);



		/**
		 * Redefine the vc_row_inner shortcode
		 *
		 * @since  1.0
		 */
		$shortcode_definitions['vc_row_inner'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'                    => esc_html__( 'Row', 'webman-amplifier' ),
				'base'                    => 'vc_row_inner',
				'class'                   => 'wm-shortcode-vc-row-inner',
				'icon'                    => 'icon-wpb-row',
				'category'                => esc_html__( 'Structure', 'webman-amplifier' ),
				'content_element'         => false,
				'is_container'            => true,
				'weight'                  => 1000,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
					10 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		);



		/**
		 * Redefine the vc_column shortcode
		 *
		 * @since  1.0
		 */
		$shortcode_definitions['vc_column'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'            => esc_html__( 'Column', 'webman-amplifier' ),
				'base'            => 'vc_column',
				'class'           => 'wm-shortcode-vc-column',
				'category'        => esc_html__( 'Structure', 'webman-amplifier' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
					10 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'id',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
					),

					30 => array(
						'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'bg_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					40 => array(
						'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'font_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'attach_image',
						'param_name'  => 'bg_image',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
						'type'        => 'textfield',
						'param_name'  => 'padding',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
				),
			),
		);



		/**
		 * Redefine the vc_column_inner shortcode
		 *
		 * @since  1.0.9
		 */
		$shortcode_definitions['vc_column_inner'] = array(
			'since'     => '1.0.9',
			'vc_plugin' => array(
				'name'            => esc_html__( 'Column', 'webman-amplifier' ),
				'base'            => 'vc_column_inner',
				'class'           => 'wm-shortcode-vc-inner-column',
				'category'        => esc_html__( 'Structure', 'webman-amplifier' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
					10 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'id',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
					),

					30 => array(
						'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'bg_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					40 => array(
						'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'colorpicker',
						'param_name'  => 'font_color',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					50 => array(
						'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'attach_image',
						'param_name'  => 'bg_image',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
						'type'        => 'textfield',
						'param_name'  => 'padding',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
				),
			),
		);



		/**
		 * Text block
		 *
		 * @since  1.0
		 */
		$shortcode_definitions['text_block'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $prefix['name'] . esc_html__( 'Text Block', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'text_block',
				'class'    => 'wm-shortcode-vc-text_block',
				'icon'     => 'icon-wpb-layer-shape-text',
				'category' => esc_html__( 'Content', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Content', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textarea_html',
						'param_name'  => 'content',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
				),
			),
		);



		/**
		 * Image
		 *
		 * @since  1.0
		 */
		$shortcode_definitions['image'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $prefix['name'] . esc_html__( 'Image', 'webman-amplifier' ),
				'base'     => $prefix['code'] . 'image',
				'class'    => 'wm-shortcode-vc-image',
				'icon'     => 'icon-wpb-single-image',
				'category' => esc_html__( 'Media', 'webman-amplifier' ),
				'params'   => array(
					10 => array(
						'heading'     => esc_html__( 'Image to display', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'attach_image',
						'param_name'  => 'src',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),
					20 => array(
						'heading'    => esc_html__( 'Image link URL', 'webman-amplifier' ),
						'type'       => 'textfield',
						'param_name' => 'link',
						'value'      => '',
						'holder'     => 'hidden',
						'class'      => '',
					),
					30 => array(
						'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'dropdown',
						'param_name'  => 'target',
						'value'       => array(
							esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
							esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
						),
						'holder'      => 'hidden',
						'class'       => '',
						'dependency'  => array(
							'element'   => 'link',
							'not_empty' => true
						),
					),
					40 => array(
						'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
						'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
						'type'        => 'textfield',
						'param_name'  => 'class',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
					),

					50 => array(
						'heading'     => esc_html__( 'Image width HTML attribute', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'width',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					60 => array(
						'heading'     => esc_html__( 'Image height HTML attribute', 'webman-amplifier' ),
						'description' => '',
						'type'        => 'textfield',
						'param_name'  => 'height',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
					70 => array(
						'heading'     => esc_html__( 'Margin', 'webman-amplifier' ),
						'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
						'type'        => 'textfield',
						'param_name'  => 'margin',
						'value'       => '',
						'holder'      => 'hidden',
						'class'       => '',
						'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
					),
				),
			),
		);



		/**
		 * Soliloquy
		 *
		 * @todo  Remove?
		 *
		 * @since  1.0
		 */
		if ( post_type_exists( 'soliloquy' ) ) {

			$shortcode_definitions['soliloquy'] = array(
				'since'      => '1.0',
				'vc_plugin'  => array(
					'name'     => esc_html__( 'Soliloquy Slider', 'webman-amplifier' ),
					'base'     => 'soliloquy',
					'class'    => 'wm-shortcode-vc-soliloquy',
					'icon'     => 'icon-wpb-images-carousel',
					'category' => esc_html__( 'Media', 'webman-amplifier' ),
					'params'   => array(
						10 => array(
							'heading'     => esc_html__( 'Choose a Soliloquy slider', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'id',
							'value'       => array_flip( wma_posts_array( 'post_name', 'soliloquy' ) ), // 1st value is empty
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			);

		}



		/**
		 * Master Slider
		 *
		 * @todo  Remove?
		 *
		 * @since  1.0.9
		 */
		if ( function_exists( 'get_masterslider_names' ) ) {

			$shortcode_definitions['masterslider'] = array(
				'since'      => '1.0.9',
				'vc_plugin'  => array(
					'name'     => esc_html__( 'Master Slider', 'webman-amplifier' ),
					'base'     => 'masterslider',
					'class'    => 'wm-shortcode-vc-masterslider',
					'icon'     => 'icon-wpb-images-carousel',
					'category' => esc_html__( 'Media', 'webman-amplifier' ),
					'params'   => array(
						10 => array(
							'heading'     => esc_html__( 'Choose a slider', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'id',
							'value'       => $empty + get_masterslider_names( false ),
							'holder'      => 'hidden',
							'class'       => '',
						),
					),
				),
			);

		}



		/**
		 * Aliases: Render certain VC shortcodes even when the plugin is disabled
		 *
		 * @since  1.0
		 */
		if ( ! wma_is_active_vc() ) {

			/**
			 * vc_row
			 */
			$shortcode_definitions['vc_row'] = array(
				'since'         => '1.0',
				'custom_prefix' => '',
				'renderer'      => array(
					'alias' => 'row',
				),
			);

				/**
				 * vc_row_inner
				 */
				$shortcode_definitions['vc_row_inner'] = array(
					'since'         => '1.0',
					'custom_prefix' => '',
					'renderer'      => array(
						'alias' => 'row',
					),
				);



			/**
			 * vc_column
			 */
			$shortcode_definitions['vc_column'] = array(
				'since'         => '1.0',
				'custom_prefix' => '',
				'renderer'      => array(
					'alias' => 'column',
				),
			);

				/**
				 * vc_column_inner
				 */
				$shortcode_definitions['vc_column_inner'] = array(
					'since'         => '1.0',
					'custom_prefix' => '',
					'renderer'      => array(
						'alias' => 'column',
					),
				);

		} // /! wma_is_active_vc()
