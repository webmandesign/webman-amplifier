<?php
/**
 * WebMan Shortcodes Definitions
 *
 * This file is being included into "../class-shortcodes.php" file's setup_globals() method.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.9.1
 */

/**
 * Helpers:
 *
 * SHORTCODES ARRAY STRUCTURE:
 *   'shortcode-name' => array(
 *     //Plugin version since when the shortcode is available.
 *       'since' => '1.0',
 *
 *     //Simple shortcode generator settings (array( 'name'=>'', 'code'=>'' )).
 *       'generator' => ARRAY,
 *
 *     //Does shortcode need preprocessing?
 *       'preprocess' => BOOLEAN,
 *
 *     //Post type name. The shortcode will be available only if this post type is enabled.
 *       'post_type_required' => STRING,
 *
 *     //Overrides the default shortcode prefix when registering shortcode with WordPress. IMPORTANT: Set this only when required!
 *       'custom_prefix' => FALSE/STRING,
 *
 *     //Renderer overrides (can be used for shortcode aliases).
 *       'renderer' => ARRAY(
 *           'alias' => 'shortcode',
 *           'path'  => 'custom_renderer_file_path'
 *         ),
 *
 *     //Add the shortcode definitions into Visual Composer plugin.
 *     //See http://kb.wpbakery.com/index.php?title=Vc_map
 *       'vc_plugin' => ARRAY( ARRAY )
 *     )
 */



// Helper variables

	// Empty value array for Visual Composer dropdown default value (fix for VC4.6+)

		$empty = array( '' => '' );

	// Social icons array

		$wm_social_icons_array = self::$codes_globals['social_icons'];
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



$shortcode_definitions = array(



	/**
   * Accordions / toggles + Tabs + Item
   */

		/**
		 * Accordion / toggles wrapper
		 *
		 * @since  1.0
		 */
		'accordion' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'generator'  => array(
						'name'  => __( 'Accordion / Toggle', 'webman-amplifier' ),
						'code'  => '[PREFIX_accordion active="0" mode="accordion/toggle" filter="0/1" class=""]<br />[PREFIX_item title="' . __( 'Section 1', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . __( 'Section 2', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""][/PREFIX_item]<br />[/PREFIX_accordion]',
						'short' => false,
					),
				'bb_plugin'  => array(
						'name'            => __( 'Accordion', 'webman-amplifier' ),
						'output'          => '[PREFIX_accordion{{active}}{{mode}}{{filter}}{{class}}]{{children}}[/PREFIX_accordion]',
						'output_children' => '[PREFIX_item{{title}}{{icon}}{{tags}}{{heading_tag}}]{{content}}[/PREFIX_item]',
						'params'          => array( 'active', 'mode', 'filter', 'class' ),
						'params_children' => array( 'title', 'content', 'icon', 'tags', 'heading_tag' ),
						'form'            => array(

								//Tab
								'general' => array(
									//Title
									'title'       => __( 'General', 'webman-amplifier' ),
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
													'label' => __( 'Mode', 'webman-amplifier' ),
													//type specific
													'options' => array(
														'accordion' => __( 'Accordion (only one section open)', 'webman-amplifier' ),
														'toggle'    => __( 'Toggle (multiple sections open)', 'webman-amplifier' ),
													),
													//preview
													'preview' => array( 'type' => 'none' ),
												), // /mode

											), // /fields
										), // /section

										//Section
										'sections' => array(
											'title'  => __( 'Sections', 'webman-amplifier' ),
											'fields' => array(

												'children' => array(
													'type' => 'form',
													//description
													'label'       => '',
													'description' => '',
													'help'        => '',
													//default
													'default' => array( 'title' => __( 'Section', 'webman-amplifier' ) ), //This will be converted automatically
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
									'title'       => __( 'Others', 'webman-amplifier' ),
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
													'label' => __( 'Filtering', 'webman-amplifier' ),
													'help'  => __( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
													//type specific
													'options' => array(
														'' => __( 'No', 'webman-amplifier' ),
														1  => __( 'Yes', 'webman-amplifier' ),
													),
													//preview
													'preview' => array( 'type' => 'none' ),
												), // /filter

												'active' => array(
													'type' => 'text',
													//description
													'label' => __( 'Active section', 'webman-amplifier' ),
													'help'  => __( 'Set section order number, "0" for all sections closed', 'webman-amplifier' ),
													//default
													'default' => 1,
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
								'title' => __( 'Section', 'webman-amplifier' ),
								//Tabs
								'tabs' => array(

									//Tab
									'general' => array(
										//Title
										'title'       => __( 'General', 'webman-amplifier' ),
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
														'label' => __( 'Title', 'webman-amplifier' ),
														//default
														'default' => __( 'Section', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'none' ),
													), // /title

												), // /fields
											), // /section

											//Section
											'content' => array(
												'title'  => __( 'Content', 'webman-amplifier' ),
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
										'title'       => __( 'Others', 'webman-amplifier' ),
										'description' => '',
										//Sections
										'sections' => array(

											//Section
											'icon' => array(
												'title'  => __( 'Icon', 'webman-amplifier' ),
												'fields' => array(

													'icon' => array(
														'type' => 'wm_radio',
														//description
														'label' => '',
														//type specific
														'options'    => self::$codes_globals['font_icons'],
														'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
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
												'title'  => __( 'Other parameters', 'webman-amplifier' ),
												'fields' => array(

													'tags' => array(
														'type' => 'text',
														//description
														'label' => __( 'Tags', 'webman-amplifier' ),
														'help'  => __( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'none' ),
													), // /tags

													'heading_tag' => array(
														'type' => 'text',
														//description
														'label' => __( 'Heading HTML tag', 'webman-amplifier' ),
														//type specific
														'placeholder' => 'h3',
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
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Accordion', 'webman-amplifier' ),
						'base'                    => $this->prefix_shortcode . 'accordion',
						'class'                   => 'wm-shortcode-vc-accordion wm-sections-mode',
						'icon'                    => 'icon-wpb-ui-accordion',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'webman-amplifier' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-separator-label"></i> ' . __( 'Accordion', 'webman-amplifier' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'item" data-item-title="' . __( 'Section', 'webman-amplifier' ) . '" class="add_tab" title="' . __( 'Accordion: Add new section', 'webman-amplifier' ) . '">' . __( 'Accordion: Add new section', 'webman-amplifier' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'item title="' . __( 'Section 1', 'webman-amplifier' ).'"][/' . $this->prefix_shortcode . 'item]
								[' . $this->prefix_shortcode . 'item title="' . __( 'Section 2', 'webman-amplifier' ).'"][/' . $this->prefix_shortcode . 'item]
							',
						'js_view'                 => 'VcCustomAccordionView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Active section', 'webman-amplifier' ),
									'description' => __( 'Set section order number, "0" for all sections closed', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'active',
									'value'       => 0,
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Mode', 'webman-amplifier' ),
									'type'        => 'dropdown',
									'param_name'  => 'mode',
									'value'       => array(
											__( 'Accordion (only one section open)', 'webman-amplifier' ) => 'accordion', // default
											__( 'Toggle (multiple sections open)', 'webman-amplifier' )   => 'toggle',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Filtering', 'webman-amplifier' ),
									'description' => __( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
									'type'        => 'dropdown',
									'param_name'  => 'filter',
									'value'       => array(
											__( 'No', 'webman-amplifier' )  => '',
											__( 'Yes', 'webman-amplifier' ) => 1,
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'webman-amplifier' ),
									'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),



		/**
		 * Tabs wrapper
		 *
		 * @since  1.0
		 */
		'tabs' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'generator'  => array(
						'name'  => __( 'Tabs', 'webman-amplifier' ),
						'code'  => '[PREFIX_tabs active="0" layout="top/left/right" tour="0/1" class=""]<br />[PREFIX_item title="' . __( 'Tab 1', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . __( 'Tab 2', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""][/PREFIX_item]<br />[/PREFIX_tabs]',
						'short' => false,
					),
				'bb_plugin'  => array(
						'name'            => __( 'Tabs', 'webman-amplifier' ),
						'output'          => '[PREFIX_tabs{{layout}}{{tour}}{{active}}{{class}}]{{children}}[/PREFIX_tabs]',
						'output_children' => '[PREFIX_item{{title}}{{icon}}{{tags}}{{heading_tag}}]{{content}}[/PREFIX_item]',
						'params'          => array( 'layout', 'tour', 'active', 'class' ),
						'params_children' => array( 'title', 'content', 'icon', 'tags', 'heading_tag' ),
						'form'            => array(

								//Tab
								'general' => array(
									//Title
									'title'       => __( 'General', 'webman-amplifier' ),
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
													'label' => __( 'Layout', 'webman-amplifier' ),
													//type specific
													'options' => array(
														'top'   => __( 'Tabs on top', 'webman-amplifier' ),
														'left'  => __( 'Tabs on left', 'webman-amplifier' ),
														'right' => __( 'Tabs on right', 'webman-amplifier' ),
													),
													//preview
													'preview' => array( 'type' => 'none' ),
												), // /layout

											), // /fields
										), // /section

										//Section
										'sections' => array(
											'title'  => __( 'Sections', 'webman-amplifier' ),
											'fields' => array(

												'children' => array(
													'type' => 'form',
													//description
													'label'       => '',
													'description' => '',
													'help'        => '',
													//default
													'default' => array( 'title' => __( 'Section', 'webman-amplifier' ) ), //This will be converted automatically
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
									'title'       => __( 'Others', 'webman-amplifier' ),
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
													'label' => __( 'Enable tour mode?', 'webman-amplifier' ),
													//type specific
													'options' => array(
														'' => __( 'No', 'webman-amplifier' ),
														1  => __( 'Yes', 'webman-amplifier' ),
													),
													//preview
													'preview' => array( 'type' => 'none' ),
												), // /tour

												'active' => array(
													'type' => 'text',
													//description
													'label' => __( 'Active section', 'webman-amplifier' ),
													'help'  => __( 'Enter the order number of the tab which should be open by default', 'webman-amplifier' ),
													//default
													'default' => 1,
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
								'title' => __( 'Section', 'webman-amplifier' ),
								//Tabs
								'tabs' => array(

									//Tab
									'general' => array(
										//Title
										'title'       => __( 'General', 'webman-amplifier' ),
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
														'label' => __( 'Title', 'webman-amplifier' ),
														//default
														'default' => __( 'Section', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'none' ),
													), // /title

												), // /fields
											), // /section

											//Section
											'content' => array(
												'title'  => __( 'Content', 'webman-amplifier' ),
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
										'title'       => __( 'Others', 'webman-amplifier' ),
										'description' => '',
										//Sections
										'sections' => array(

											//Section
											'icon' => array(
												'title'  => __( 'Icon', 'webman-amplifier' ),
												'fields' => array(

													'icon' => array(
														'type' => 'wm_radio',
														//description
														'label' => '',
														//type specific
														'options'    => self::$codes_globals['font_icons'],
														'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
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

								), // /tabs

							),
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Tabs', 'webman-amplifier' ),
						'base'                    => $this->prefix_shortcode . 'tabs',
						'class'                   => 'wm-shortcode-vc-tabs wm-sections-mode',
						'icon'                    => 'icon-wpb-ui-tab-content',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'webman-amplifier' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-tab-content"></i> ' . __( 'Tabs', 'webman-amplifier' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'item" data-item-title="' . __( 'Tab', 'webman-amplifier' ) . '" class="add_tab" title="' . __( 'Tabs: Add new tab', 'webman-amplifier' ) . '">' . __( 'Tabs: Add new tab', 'webman-amplifier' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'item title="' . __( 'Tab 1', 'webman-amplifier' ).'"][/' . $this->prefix_shortcode . 'item]
								[' . $this->prefix_shortcode . 'item title="' . __( 'Tab 2', 'webman-amplifier' ).'"][/' . $this->prefix_shortcode . 'item]
							',
						'js_view'                 => 'VcCustomAccordionView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Active tab', 'webman-amplifier' ),
									'description' => __( 'Enter the order number of the tab which should be open by default', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'active',
									'value'       => 1,
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Layout', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'layout',
									'value'       => array(
											__( 'Tabs on top', 'webman-amplifier' )   => 'top', // default
											__( 'Tabs on left', 'webman-amplifier' )  => 'left',
											__( 'Tabs on right', 'webman-amplifier' ) => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Enable tour mode?', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'tour',
									'value'       => array(
											__( 'No', 'webman-amplifier' )  => '',
											__( 'Yes', 'webman-amplifier' ) => 1,
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'webman-amplifier' ),
									'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),



		/**
		 * Item (can be accordion / toggles or tab item)
		 *
		 * @since  1.0
		 */
		'item' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'generator'  => array(
						'name'  => __( 'Item (accordion or tab section)', 'webman-amplifier' ),
						'code'  => '[PREFIX_item title="' . __( 'Title', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]',
						'short' => false,
					),
				'vc_plugin'  => array(
						'name'                      => $this->prefix_shortcode_name . __( 'Item (Accordion / Tab)', 'webman-amplifier' ),
						'base'                      => $this->prefix_shortcode . 'item',
						'class'                     => 'wm-shortcode-vc-item wm-sections-mode-section wpb_vc_accordion_tab',
						'allowed_container_element' => 'vc_row',
						'is_container'              => true,
						'content_element'           => false,
						'category'                  => __( 'Content', 'webman-amplifier' ),
						'js_view'                   => 'VcCustomAccordionTabView',
						'params'                    => array(
								10 => array(
									'heading'    => __( 'Title', 'webman-amplifier' ),
									'type'       => 'textfield',
									'param_name' => 'title',
									'value'      => '',
									'holder'     => 'hidden',
									'class'      => '',
								),
								20 => array(
									'heading'     => __( 'Icon', 'webman-amplifier' ),
									'type'        => 'wm_radio',
									'param_name'  => 'icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'filter'      => true,
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Tags', 'webman-amplifier' ),
									'description' => __( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'tags',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'Heading HTML tag', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'heading_tag',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),



  /**
	 * Audio
	 *
	 * @since  1.0
	 */
	'audio' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Audio', 'webman-amplifier' ),
					'code'  => '[PREFIX_audio src="" autoplay="0/1" loop="0/1" class="" /]',
					'short' => false,
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Audio', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'audio',
					'class'    => 'wm-shortcode-vc-audio',
					'category' => __( 'Media', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Audio source', 'webman-amplifier' ),
								'description' => __( 'Set the audio URL', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'src',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Autoplay the audio?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'autoplay',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 'on',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Loop the audio?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'loop',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 'on',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							40 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



  /**
	 * Button
	 *
	 * @since  1.0
	 */
	'button' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Button', 'webman-amplifier' ),
					'code'  => '[PREFIX_button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_button]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Button', 'webman-amplifier' ),
					'output' => '[PREFIX_button{{url}}{{target}}{{color}}{{size}}{{icon}}{{id}}{{class}}]{{content}}[/PREFIX_button]',
					'params' => array( 'url', 'target', 'color', 'size', 'icon', 'id', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Button text', 'webman-amplifier' ),
												//default
												'default' => __( 'Button Text', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /content

											'url' => array(
												'type' => 'text',
												//description
												'label' => __( 'Button link URL', 'webman-amplifier' ),
												//default
												'default' => '#',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /url

											'target' => array(
												'type' => 'select',
												//description
												'label' => __( 'Target', 'webman-amplifier' ),
												'help'  => __( 'Button link target', 'webman-amplifier' ),
												//type specific
												'options' => array(
													''       => __( 'Open in same window', 'webman-amplifier' ),
													'_blank' => __( 'Open in new window / tab', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /target

											'color' => array(
												'type' => 'select',
												//description
												'label' => __( 'Color', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['colors'],
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /color

											'size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Size', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['sizes']['options'],
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /size

											'id' => array(
												'type' => 'text',
												//description
												'label' => __( 'Optional HTML ID', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /id

										), // /fields
									), // /section

								), // /sections
							), // /tab

							//Tab
							'icon' => array(
								//Title
								'title'       => __( 'Icon', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'icon' => array(
										'title'  => __( 'Icon', 'webman-amplifier' ),
										'fields' => array(

											'icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => self::$codes_globals['font_icons'],
												'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
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
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Button', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'button',
					'class'    => 'wm-shortcode-vc-button',
					'icon'     => 'icon-wpb-ui-button',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'    => __( 'Button text', 'webman-amplifier' ),
								'type'       => 'textfield',
								'param_name' => 'content',
								'value'      => __( 'Button Text', 'webman-amplifier' ),
								'holder'     => 'div',
								'class'      => '',
							),
							20 => array(
								'heading'     => __( 'Button URL', 'webman-amplifier' ),
								'description' => __( 'Set the button link URL', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'url',
								'value'       => '#',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Target', 'webman-amplifier' ),
								'description' => __( 'Button link target', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'target',
								'value'       => array(
										__( 'Open in same window', 'webman-amplifier' )      => '',
										__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
									),
								'holder'      => 'hidden',
								'class'       => '',
								'dependency'  => array(
										'element'   => 'url',
										'not_empty' => true
									),
							),
							40 => array(
								'heading'    => __( 'Color', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'color',
								'value'      => $empty + array_flip( self::$codes_globals['colors'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							50 => array(
								'heading'    => __( 'Size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'size',
								'value'      => $empty + array_flip( self::$codes_globals['sizes']['options'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							60 => array(
								'heading'     => __( 'Icon', 'webman-amplifier' ),
								'type'        => 'wm_radio',
								'param_name'  => 'icon',
								'value'       => self::$codes_globals['font_icons'],
								'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
								'filter'      => true,
								'hide_radio'  => true,
								'inline'      => true,
								'holder'      => 'hidden',
								'class'       => '',
							),
							70 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							80 => array(
								'heading'     => __( 'Optional HTML ID', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'id',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



  /**
	 * Call to action
	 *
	 * @since  1.0
	 */
	'call_to_action' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Call to action', 'webman-amplifier' ),
					'code'  => '[PREFIX_call_to_action caption="" button_text="" button_url="#" button_color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" button_size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" button_icon="" class=""]{{content}}[/PREFIX_call_to_action]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Call to action', 'webman-amplifier' ),
					'output' => '[PREFIX_call_to_action{{caption}}{{heading_tag}}{{button_text}}{{button_url}}{{target}}{{button_color}}{{button_size}}{{button_icon}}{{class}}]{{content}}[/PREFIX_call_to_action]',
					'params' => array( 'caption', 'heading_tag', 'button_text', 'button_url', 'target', 'button_color', 'button_size', 'button_icon', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Caption', 'webman-amplifier' ),
												//default
												'default' => '',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /caption

											'heading_tag' => array(
												'type' => 'text',
												//description
												'label' => __( 'Caption HTML tag', 'webman-amplifier' ),
												//type specific
												'placeholder' => 'h2',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

											), // /fields
										), // /section

										//Section
										'content' => array(
											'title'  => __( 'Content', 'webman-amplifier' ),
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
								'title'       => __( 'Button', 'webman-amplifier' ),
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
												'label' => __( 'Button text', 'webman-amplifier' ),
												//default
												'default' => '',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /button_text

											'button_url' => array(
												'type' => 'text',
												//description
												'label' => __( 'Button link URL', 'webman-amplifier' ),
												//default
												'default' => '',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /button_url

											'target' => array(
												'type' => 'select',
												//description
												'label' => __( 'Target', 'webman-amplifier' ),
												'help'  => __( 'Button link target', 'webman-amplifier' ),
												//type specific
												'options' => array(
													''       => __( 'Open in same window', 'webman-amplifier' ),
													'_blank' => __( 'Open in new window / tab', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /target

											'button_color' => array(
												'type' => 'select',
												//description
												'label' => __( 'Button color', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['colors'],
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /button_color

											'button_size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Button size', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['sizes']['options'],
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /button_size

										), // /fields
									), // /section

									//Section
									'icon' => array(
										'title'  => __( 'Button icon', 'webman-amplifier' ),
										'fields' => array(

											'button_icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => self::$codes_globals['font_icons'],
												'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
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
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Call to action', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'call_to_action',
					'class'    => 'wm-shortcode-vc-call_to_action',
					'icon'     => 'icon-wpb-call-to-action',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Caption', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textfield',
								'param_name'  => 'caption',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Content text', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea_html',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Button text', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textfield',
								'param_name'  => 'button_text',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
								40 => array(
									'heading'    => __( 'Button link URL', 'webman-amplifier' ),
									'type'       => 'textfield',
									'param_name' => 'button_url',
									'value'      => '',
									'holder'     => 'hidden',
									'class'      => '',
								),
								50 => array(
									'heading'     => __( 'Button link target', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'target',
									'value'       => array(
											__( 'Open in same window', 'webman-amplifier' )      => '',
											__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								60 => array(
									'heading'     => __( 'Button color', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'button_color',
									'value'       => $empty + array_flip( self::$codes_globals['colors'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								70 => array(
									'heading'     => __( 'Button size', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'button_size',
									'value'       => $empty + array_flip( self::$codes_globals['sizes']['options'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								80 => array(
									'heading'     => __( 'Button icon', 'webman-amplifier' ),
									'description' => __( 'Choose one of available icons', 'webman-amplifier' ),
									'type'        => 'wm_radio',
									'param_name'  => 'button_icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'filter'      => true,
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'hidden',
									'class'       => '',
								),
							90 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Collumn
	 *
	 * @since  1.0
	 */
	'column' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Column', 'webman-amplifier' ),
					'code'  => ( wma_is_active_vc() ) ? ( '[vc_column width="1/1,1/2,1/3,2/3,1/4,3/4,1/6,5/6" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/vc_column]' ) : ( '[PREFIX_column width="' . implode( ',', self::$codes_globals['column_widths'] ) . '" last="0/1" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/PREFIX_column]' ),
					'short' => false,
				),
		),



	/**
	 * Countdown timer
	 *
	 * @since  1.0
	 */
	'countdown_timer' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Countdown timer', 'webman-amplifier' ),
					'code'  => '[PREFIX_countdown_timer time="' . date( get_option( 'date_format' ), strtotime( 'now' ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" class="" /]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Countdown timer', 'webman-amplifier' ),
					'output' => '[PREFIX_countdown_timer{{time}}{{size}}{{class}} /]',
					'params' => array( 'time', 'size', 'class' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'time' => array(
												'type' => 'text',
												//description
												'label' => __( 'Time', 'webman-amplifier' ),
												//default
												'default' => date( get_option( 'date_format' ), strtotime( 'now' ) ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /content

											'size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Size', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['sizes']['options'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /size

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Countdown timer', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'countdown_timer',
					'class'    => 'wm-shortcode-vc-countdown_timer',
					'icon'     => 'vc_icon-vc-gitem-post-date',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'    => __( 'Time', 'webman-amplifier' ),
								'type'       => 'textfield',
								'param_name' => 'time',
								'value'      => date( get_option( 'date_format' ), strtotime( 'now' ) ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							20 => array(
								'heading'    => __( 'Size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'size',
								'value'      => $empty + array_flip( self::$codes_globals['sizes']['options'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							30 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Content Module
	 *
	 * @since  1.0
	 */
	'content_module' => array(
			'since'      => '1.0',
			'post_type_required' => 'wm_modules',
			'preprocess'         => false,
			'generator'          => array(
					'name'  => __( 'Content Module', 'webman-amplifier' ),
					'code'  => '[PREFIX_content_module module="module-slug" align="left/right" columns="4" count="-1" order="new/old/name/random" tag="" image_size="" filter="0/1" scroll="0" pagination="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_content_module]',
					'short' => false,
				),
			'bb_plugin'          => array(
					'name'   => __( 'Content Module', 'webman-amplifier' ),
					'output' => '[PREFIX_content_module{{module}}{{align}}{{columns}}{{count}}{{order}}{{tag}}{{image_size}}{{filter}}{{scroll}}{{pagination}}{{no_margin}}{{heading_tag}}{{layout}}{{class}}]{{content}}[/PREFIX_content_module]',
					'params' => array( 'module', 'align', 'columns', 'count', 'order', 'tag', 'image_size', 'filter', 'scroll', 'pagination', 'no_margin', 'heading_tag', 'layout', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'single' => array(
										'title'  => __( 'Single module display', 'webman-amplifier' ),
										'fields' => array(

											'module' => array(
												'type' => 'select',
												//description
												'label' => __( 'Single module', 'webman-amplifier' ),
												'help'  => __( 'Leave empty to display multiple modules', 'webman-amplifier' ),
												//type specific
												'options' => $wm_modules_slugs,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /module

										), // /fields
									), // /section

									//Section
									'multiple' => array(
										'title'  => __( 'Multiple modules display', 'webman-amplifier' ),
										'fields' => array(

											'count' => array(
												'type' => 'text',
												//description
												'label' => __( 'Count', 'webman-amplifier' ),
												'help'  => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
												//default
												'default' => 3,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /count

											'columns' => array(
												'type' => 'select',
												//description
												'label' => __( 'Columns', 'webman-amplifier' ),
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
												'label' => __( 'Order', 'webman-amplifier' ),
												//type specific
												'options' => array(
														'new'    => __( 'Newest first', 'webman-amplifier' ),
														'old'    => __( 'Oldest first', 'webman-amplifier' ),
														'name'   => __( 'By name', 'webman-amplifier' ),
														'random' => __( 'Randomly', 'webman-amplifier' ),
													),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /order

											'filter' => array(
												'type' => 'select',
												//description
												'label' => __( 'Filtering', 'webman-amplifier' ),
												'help'  => __( 'Display the modules filter from module tags?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /filter

											'scroll' => array(
												'type' => 'text',
												//description
												'label' => __( 'Scrolling', 'webman-amplifier' ),
												'help'  => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /scroll

											'tag' => array(
												'type' => 'select',
												//description
												'label' => __( 'Tagged as', 'webman-amplifier' ),
												'help'  => __( 'Display specifically tagged items only', 'webman-amplifier' ),
												//type specific
												'options' => $wm_modules_tags,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /tag

											'pagination' => array(
												'type' => 'select',
												//description
												'label' => __( 'Display pagination?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
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
								'title'       => __( 'Description', 'webman-amplifier' ),
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
												'label' => __( 'Description alignment', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'left'  => __( 'Left', 'webman-amplifier' ),
													'right' => __( 'Right', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /align

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => __( 'Content', 'webman-amplifier' ),
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
								'title'       => __( 'Others', 'webman-amplifier' ),
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
												'label' => __( 'Remove gap between items?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /no_margin

											'image_size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Image size', 'webman-amplifier' ),
												//type specific
												'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /image_size

											'heading_tag' => array(
												'type' => 'text',
												//description
												'label' => __( 'Heading HTML tag', 'webman-amplifier' ),
												//type specific
												'placeholder' => 'h3',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

											'layout' => array(
												'type' => 'text',
												//description
												'label'       => __( 'Custom layout', 'webman-amplifier' ),
												'description' => '<br />' . sprintf( __( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /layout

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'          => array(
					'name'     => $this->prefix_shortcode_name . __( 'Content Module', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'content_module',
					'class'    => 'wm-shortcode-vc-content_module',
					'icon'     => 'icon-wpb-toggle-small-expand',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Single module', 'webman-amplifier' ),
								'description' => __( 'Leave empty to display multiple modules', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'module',
								'value'       => array_flip( $wm_modules_slugs ), // 1st value is empty
								'holder'      => 'div',
								'class'       => '',
							),

							20 => array(
								'heading'     => __( 'Count', 'webman-amplifier' ),
								'description' => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'count',
								'value'       => 3,
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							30 => array(
								'heading'    => __( 'Columns', 'webman-amplifier' ),
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
								'group'      => __( 'Multiple display', 'webman-amplifier' ),
							),
							40 => array(
								'heading'    => __( 'Order', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'order',
								'value'      => array(
										__( 'Newest first', 'webman-amplifier' ) => 'new', // default
										__( 'Oldest first', 'webman-amplifier' ) => 'old',
										__( 'By name', 'webman-amplifier' )      => 'name',
										__( 'Randomly', 'webman-amplifier' )     => 'random',
									),
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Multiple display', 'webman-amplifier' ),
							),
							50 => array(
								'heading'     => __( 'Filter', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'filter',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							60 => array(
								'heading'     => __( 'Scrolling', 'webman-amplifier' ),
								'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'scroll',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							70 => array(
								'heading'     => __( 'Tag', 'webman-amplifier' ),
								'description' => __( 'Display specifically tagged items only', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'tag',
								'value'       => array_flip( $wm_modules_tags ), // 1st value is empty
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							80 => array(
								'heading'     => __( 'Display pagination?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'pagination',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							90 => array(
								'heading'     => __( 'Description text (HTML)', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							100 => array(
								'heading'     => __( 'Description alignment', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'align',
								'value'       => array(
										__( 'Left', 'webman-amplifier' )  => 'left', // default
										__( 'Right', 'webman-amplifier' ) => 'right',
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							110 => array(
								'heading'     => __( 'Remove gap between items?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'no_margin',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),

							120 => array(
								'heading'    => __( 'Image size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'image_size',
								'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Layout', 'webman-amplifier' ),
							),
							130 => array(
								'heading'     => __( 'Custom layout', 'webman-amplifier' ),
								'description' => sprintf( __( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
								'type'        => 'textfield',
								'param_name'  => 'layout',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Layout', 'webman-amplifier' ),
							),

							140 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Divider
	 *
	 * @since  1.0
	 */
	'divider' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name' => __( 'Divider / Gap', 'webman-amplifier' ),
					'code' => '[PREFIX_divider appearance="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['divider_appearance'] ) ) ) . '" space_before="" space_after="" class="" /]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Divider / Gap', 'webman-amplifier' ),
					'output' => '[PREFIX_divider{{appearance}}{{class}} /]',
					'params' => array( 'appearance', 'class' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Appearance', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['divider_appearance'],
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
					'name'                    => $this->prefix_shortcode_name . __( 'Divider / Gap', 'webman-amplifier' ),
					'base'                    => $this->prefix_shortcode . 'divider',
					'class'                   => 'wm-shortcode-vc-divider',
					'icon'                    => 'icon-wpb-ui-separator',
					'show_settings_on_create' => false,
					'category'                => __( 'Content', 'webman-amplifier' ),
					'params'                  => array(
							10 => array(
								'heading'     => __( 'Appearance', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'appearance',
								'value'       => array_flip( self::$codes_globals['divider_appearance'] ),
								'holder'      => 'div',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Space before divider', 'webman-amplifier' ),
								'description' => __( 'Insert a number (of pixels)', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'space_before',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Space after divider', 'webman-amplifier' ),
								'description' => __( 'Insert a number (of pixels)', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'space_after',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							40 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							50 => array(
								'heading'     => __( 'CSS styles', 'webman-amplifier' ),
								'description' => __( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'style',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Dropcap
	 *
	 * @since  1.0
	 */
	'dropcap' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name' => __( 'Dropcap', 'webman-amplifier' ),
					'code' => '[PREFIX_dropcap color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" shape="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['dropcap_shapes'] ) ) ) . '" class=""]{{content}}[/PREFIX_dropcap]',
					'short' => true,
				),
		),



	/**
	 * Icon
	 *
	 * @since  1.0
	 */
	'icon' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Icon (social icon)', 'webman-amplifier' ),
					'code'  => '[PREFIX_icon class="icon-class" social="' . implode( '/', $wm_social_icons_array ) . '" url="" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" /]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Icon (social icon)', 'webman-amplifier' ),
					'output' => '[PREFIX_icon{{url}}{{target}}{{social}}{{size}}{{icon}}{{title}}{{rel}}{{id}}{{class}} /]',
					'params' => array( 'url', 'target', 'social', 'size', 'icon', 'title', 'rel', 'id', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Size', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['sizes']['options'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /size

										), // /fields
									), // /section

									//Section
									'icon' => array(
										'title'  => __( 'Icon', 'webman-amplifier' ),
										'fields' => array(

											'icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => self::$codes_globals['font_icons'],
												'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
												'filter'     => true,
												'hide_radio' => true,
												'inline'     => true,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /icon

										), // /fields
									), // /section

									//Section
									'advanced' => array(
										'title'  => __( 'Advanced', 'webman-amplifier' ),
										'fields' => array(

											'id' => array(
												'type' => 'text',
												//description
												'label' => __( 'Optional HTML ID', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /id

										), // /fields
									), // /section

								), // /sections
							), // /tab

							//Tab
							'social' => array(
								//Title
								'title'       => __( 'Social icon', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'social' => array(
												'type' => 'select',
												//description
												'label' => __( 'Social icon?', 'webman-amplifier' ),
												//type specific
												'options' => $wm_social_icons_array,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /social

											'url' => array(
												'type' => 'text',
												//description
												'label' => __( 'Social icon link URL', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /url

											'target' => array(
												'type' => 'select',
												//description
												'label' => __( 'Target', 'webman-amplifier' ),
												'help'  => __( 'Button link target', 'webman-amplifier' ),
												//type specific
												'options' => array(
													''       => __( 'Open in same window', 'webman-amplifier' ),
													'_blank' => __( 'Open in new window / tab', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /target

											'title' => array(
												'type' => 'text',
												//description
												'label' => __( 'Social icon title', 'webman-amplifier' ),
												'help'  => __( 'Will be displayed when mouse hovers over the icon', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /title

											'rel' => array(
												'type' => 'text',
												//description
												'label' => __( 'Social icon relation', 'webman-amplifier' ),
												'help'  => __( 'The HTML "rel" attribute', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /rel

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Icon (social icon)', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'icon',
					'class'    => 'wm-shortcode-vc-icon',
					'icon'     => 'icon-wpb-vc_icon',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'    => __( 'Icon', 'webman-amplifier' ),
								'type'       => 'wm_radio',
								'param_name' => 'icon',
								'value'      => self::$codes_globals['font_icons'],
								'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
								'filter'     => true,
								'hide_radio' => true,
								'inline'     => true,
								'holder'     => 'div',
								'class'      => '',
							),
							20 => array(
								'heading'    => __( 'Size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'size',
								'value'      => $empty + array_flip( self::$codes_globals['sizes']['options'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),

							30 => array(
								'heading'    => __( 'Social icon?', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'social',
								'value'      => $wm_social_icons_array, // 1st value is empty
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Social icon', 'webman-amplifier' ),
							),
							40 => array(
								'heading'    => __( 'Social icon link URL', 'webman-amplifier' ),
								'type'       => 'textfield',
								'param_name' => 'url',
								'value'      => '',
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Social icon', 'webman-amplifier' ),
							),
							50 => array(
								'heading'     => __( 'Target', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'target',
								'value'       => array(
										__( 'Open in same window', 'webman-amplifier' )      => '',
										__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Social icon', 'webman-amplifier' ),
							),
							60 => array(
								'heading'     => __( 'Social icon title', 'webman-amplifier' ),
								'description' => __( 'Will be displayed when mouse hovers over the icon', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'title',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Social icon', 'webman-amplifier' ),
							),
							70 => array(
								'heading'     => __( 'Social icon relation', 'webman-amplifier' ),
								'description' => __( 'The HTML "rel" attribute', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'rel',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Social icon', 'webman-amplifier' ),
							),

							80 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							90 => array(
								'heading'     => __( 'CSS styles', 'webman-amplifier' ),
								'description' => __( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'style',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Icon list
	 *
	 * @since  1.0
	 */
	'list' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Icons list', 'webman-amplifier' ),
					'code'  => '[PREFIX_list bullet="icon-class" class=""]<ul><li>{{content}}</li><li>' . __( 'List item', 'webman-amplifier' ) . '</li></ul>[/PREFIX_list]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Icons list', 'webman-amplifier' ),
					'output' => '[PREFIX_list{{bullet}}{{class}}]{{content}}[/PREFIX_list]',
					'params' => array( 'bullet', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'content' => array(
										'title'       => __( 'List items', 'webman-amplifier' ),
										'description' => __( 'Insert unordered list only', 'webman-amplifier' ),
										'fields'      => array(

											'content' => array(
												'type' => 'editor',
												//description
												'label' => '',
												//description
												'default' => '<ul><li>TEXT</li><li>TEXT</li></ul>',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /content

										), // /fields
									), // /section

								), // /sections
							), // /tab

							//Tab
							'icon' => array(
								//Title
								'title'       => __( 'Icon', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'icon' => array(
										'title'  => __( 'Bullet icon', 'webman-amplifier' ),
										'fields' => array(

											'bullet' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => self::$codes_globals['font_icons'],
												'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
												'filter'     => true,
												'hide_radio' => true,
												'inline'     => true,
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /bullet

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Icons list', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'list',
					'class'    => 'wm-shortcode-vc-list',
					'icon'     => 'icon-wpb-vc_icon',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'List items (insert unordered list only)', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea_html',
								'param_name'  => 'content',
								'value'       => '<ul><li>TEXT</li><li>TEXT</li></ul>',
								'holder'      => 'hidden',
								'class'       => '',
							),
							20 => array(
								'heading'    => __( 'Bullet icon', 'webman-amplifier' ),
								'type'       => 'wm_radio',
								'param_name' => 'bullet',
								'value'      => self::$codes_globals['font_icons'],
								'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
								'filter'     => true,
								'hide_radio' => true,
								'inline'     => true,
								'holder'     => 'div',
								'class'      => '',
							),
							30 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Last update time
	 *
	 * @since  1.0
	 */
	'last_update' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Last update time', 'webman-amplifier' ),
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
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Marker', 'webman-amplifier' ),
					'code'  => '[PREFIX_marker color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" class=""]{{content}}[/PREFIX_marker]',
					'short' => true,
				),
		),



	/**
	 * Message
	 *
	 * @since  1.0
	 */
	'message' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name' => __( 'Message', 'webman-amplifier' ),
					'code' => '[PREFIX_message title="" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_message]',
				),
			'bb_plugin'  => array(
					'name'   => __( 'Message', 'webman-amplifier' ),
					'output' => '[PREFIX_message{{title}}{{heading_tag}}{{color}}{{size}}{{icon}}{{class}}]{{content}}[/PREFIX_message]',
					'params' => array( 'title', 'heading_tag', 'color', 'size', 'icon', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Caption', 'webman-amplifier' ),
												//default
												'default' => '',
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /title

											'heading_tag' => array(
												'type' => 'text',
												//description
												'label' => __( 'Caption HTML tag', 'webman-amplifier' ),
												//type specific
												'placeholder' => 'h3',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

											), // /fields
										), // /section

										//Section
										'content' => array(
											'title'  => __( 'Content', 'webman-amplifier' ),
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
								'title'       => __( 'Icon', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'icon' => array(
										'title'  => __( 'Icon', 'webman-amplifier' ),
										'fields' => array(

											'icon' => array(
												'type' => 'wm_radio',
												//description
												'label' => '',
												//type specific
												'options'    => self::$codes_globals['font_icons'],
												'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
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
								'title'       => __( 'Others', 'webman-amplifier' ),
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
												'label' => __( 'Color', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['colors'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /color

											'size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Size', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['sizes']['options'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /size

											), // /fields
										), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Message', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'message',
					'class'    => 'wm-shortcode-vc-message',
					'icon'     => 'icon-wpb-information-white',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'    => __( 'Caption', 'webman-amplifier' ),
								'type'       => 'textfield',
								'param_name' => 'title',
								'value'      => '',
								'holder'     => 'hidden',
								'class'      => '',
							),
							20 => array(
								'heading'     => __( 'Content', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea_html',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'    => __( 'Color', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'color',
								'value'      => $empty + array_flip( self::$codes_globals['colors'] ),
								'holder'     => 'div',
								'class'      => '',
							),
							40 => array(
								'heading'    => __( 'Size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'size',
								'value'      => $empty + array_flip( self::$codes_globals['sizes']['options'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							50 => array(
								'heading'    => __( 'Icon', 'webman-amplifier' ),
								'type'       => 'wm_radio',
								'param_name' => 'icon',
								'value'      => self::$codes_globals['font_icons'],
								'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
								'filter'     => true,
								'hide_radio' => true,
								'inline'     => true,
								'holder'     => 'hidden',
								'class'      => '',
							),
							60 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Meta
	 *
	 * @since  1.0.9
	 */
	'meta' => array(
			'since'      => '1.0.9',
			'preprocess' => false,
			'generator'  => array(),
		),



	/**
	 * Posts
	 *
	 * @since  1.0
	 */
	'posts' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Posts (custom posts)', 'webman-amplifier' ),
					'code'  => '[PREFIX_posts post_type="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['post_types'] ) ) ) . '" align="left/right" columns="4" count="-1" image_size="" order="new/old/name/random" taxonomy="taxonomy_name:taxonomy_slug" filter="taxonomy_name" scroll="0" pagination="0/1" related="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_posts]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Posts (custom posts)', 'webman-amplifier' ),
					'output' => '[PREFIX_posts{{post_type}}{{align}}{{columns}}{{count}}{{order}}{{taxonomy}}{{image_size}}{{filter}}{{scroll}}{{pagination}}{{related}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_posts]',
					'params' => array( 'post_type', 'align', 'columns', 'count', 'order', 'taxonomy', 'image_size', 'filter', 'scroll', 'pagination', 'related', 'no_margin', 'heading_tag', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Post type', 'webman-amplifier' ),
												'help'  => __( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['post_types'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /post_type

											'count' => array(
												'type' => 'text',
												//description
												'label' => __( 'Count', 'webman-amplifier' ),
												'help'  => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
												//default
												'default' => 3,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /count

											'columns' => array(
												'type' => 'select',
												//description
												'label' => __( 'Columns', 'webman-amplifier' ),
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
												'label' => __( 'Order', 'webman-amplifier' ),
												//type specific
												'options' => array(
														'new'    => __( 'Newest first', 'webman-amplifier' ),
														'old'    => __( 'Oldest first', 'webman-amplifier' ),
														'name'   => __( 'By name', 'webman-amplifier' ),
														'random' => __( 'Randomly', 'webman-amplifier' ),
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
								'title'       => __( 'Description', 'webman-amplifier' ),
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
												'label' => __( 'Description alignment', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'left'  => __( 'Left', 'webman-amplifier' ),
													'right' => __( 'Right', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /align

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => __( 'Content', 'webman-amplifier' ),
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
								'title'       => __( 'Others', 'webman-amplifier' ),
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
												'label' => __( 'Remove gap between items?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /no_margin

											'taxonomy' => array(
												'type' => 'text',
												//description
												'label'       => __( 'From taxonomy', 'webman-amplifier' ),
												'description' => '<br />' . __( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . __( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $wm_taxonomies ) . '</code>',
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /taxonomy

											'filter' => array(
												'type' => 'text',
												//description
												'label'       => __( 'Filter by', 'webman-amplifier' ),
												'description' => '<br />' . __( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . __( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $wm_taxonomies ) . '</code>',
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /filter

											'filter_layout' => array(
												'type' => 'text',
												//description
												'label'       => __( 'Filter layout', 'webman-amplifier' ),
												'description' => sprintf( __( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . __( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /filter_layout

											'scroll' => array(
												'type' => 'text',
												//description
												'label' => __( 'Scrolling', 'webman-amplifier' ),
												'help'  => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /scroll

											'related' => array(
												'type' => 'select',
												//description
												'label' => __( 'Related by', 'webman-amplifier' ),
												'help'  => __( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ),
												//type specific
												'options' => wma_asort( array_merge( array( '' => '' ), $wm_taxonomies ) ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /related

											'pagination' => array(
												'type' => 'select',
												//description
												'label' => __( 'Display pagination?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /pagination

											'image_size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Image size', 'webman-amplifier' ),
												//type specific
												'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /image_size

											'heading_tag' => array(
												'type' => 'text',
												//description
												'label' => __( 'Heading HTML tag', 'webman-amplifier' ),
												//type specific
												'placeholder' => 'h2',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Posts (custom posts)', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'posts',
					'class'    => 'wm-shortcode-vc-posts',
					'icon'     => 'icon-wpb-vc_carousel',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Post type', 'webman-amplifier' ),
								'description' => __( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'post_type',
								'value'       => $empty + array_flip( self::$codes_globals['post_types'] ),
								'holder'      => 'div',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Count', 'webman-amplifier' ),
								'description' => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'count',
								'value'       => 3,
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'    => __( 'Columns', 'webman-amplifier' ),
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
								'heading'    => __( 'Order', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'order',
								'value'      => array(
										__( 'Newest first', 'webman-amplifier' ) => 'new', // default
										__( 'Oldest first', 'webman-amplifier' ) => 'old',
										__( 'By name', 'webman-amplifier' )      => 'name',
										__( 'Randomly', 'webman-amplifier' )     => 'random',
									),
								'holder'     => 'hidden',
								'class'      => '',
							),

							50 => array(
								'heading'     => __( 'Taxonomy', 'webman-amplifier' ),
								'description' => __( 'Displays items only from a specific taxonomy. Set a taxonomy name and taxonomy slug separated with colon.', 'webman-amplifier' ) . '<br />' . __( 'For example: "category:category-slug".', 'webman-amplifier' ) . '<br />' . __( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
								'type'        => 'textfield',
								'param_name'  => 'taxonomy',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Taxonomy', 'webman-amplifier' ),
							),
							60 => array(
								'heading'     => __( 'Relation', 'webman-amplifier' ),
								'description' => __( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ) . ' ' . __( 'For example: "category".', 'webman-amplifier' ) . '<br />' . __( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
								'type'        => 'textfield',
								'param_name'  => 'related',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Taxonomy', 'webman-amplifier' ),
							),

							70 => array(
								'heading'     => __( 'Filter', 'webman-amplifier' ),
								'description' => __( 'If set, the items will be filtered. Set a taxonomy name (and optional parent taxonomy slug separated with colon - filter will be created from sub-taxonomies) which will be used to filter the items.', 'webman-amplifier' ) . '<br />' . __( 'For example: "category" or "category:parent-category-slug".', 'webman-amplifier' ) . '<br />' . __( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
								'type'        => 'textfield',
								'param_name'  => 'filter',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Filter / Scroll', 'webman-amplifier' ),
							),
							80 => array(
								'heading'     => __( 'Filter layout', 'webman-amplifier' ),
								'description' => sprintf( __( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . __( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'filter_layout',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Filter / Scroll', 'webman-amplifier' ),
							),
							90 => array(
								'heading'     => __( 'Scrolling', 'webman-amplifier' ),
								'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'scroll',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Filter / Scroll', 'webman-amplifier' ),
							),

							100 => array(
								'heading'     => __( 'Display pagination?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'pagination',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
							),

							110 => array(
								'heading'     => __( 'Description text', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea_html',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Description', 'webman-amplifier' ),
							),
							120 => array(
								'heading'     => __( 'Description alignment', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'align',
								'value'       => array(
										__( 'Left', 'webman-amplifier' )  => 'left', // default
										__( 'Right', 'webman-amplifier' ) => 'right',
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Description', 'webman-amplifier' ),
							),

							130 => array(
								'heading'     => __( 'Remove gap between items?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'no_margin',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Layout', 'webman-amplifier' ),
							),
							140 => array(
								'heading'    => __( 'Image size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'image_size',
								'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Layout', 'webman-amplifier' ),
							),

							150 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Pre
	 *
	 * @since  1.0
	 */
	'pre' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Preformatted text', 'webman-amplifier' ),
					'code'  => '[PREFIX_pre]{{content}}[/PREFIX_pre]',
					'short' => true,
				),
		),



	/**
   * Pricing table + Price
   */

		/**
		 * Pricing table
		 *
		 * @since  1.0
		 */
		'pricing_table' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'generator'  => array(
						'name'  => __( 'Pricing table', 'webman-amplifier' ),
						'code'  => '[PREFIX_pricing_table no_margin="0/1" class=""]<br />[PREFIX_price caption="' . __( 'Price 1', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]{{content}}[/PREFIX_price]<br />[PREFIX_price caption="' . __( 'Price 2', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]' . __( 'Price 2 content goes here', 'webman-amplifier' ) . '[/PREFIX_price]<br />[/PREFIX_pricing_table]',
						'short' => false,
					),
				'bb_plugin'  => array(
						'name'            => __( 'Pricing table', 'webman-amplifier' ),
						'output'          => '[PREFIX_pricing_table{{no_margin}}{{class}}]{{children}}[/PREFIX_pricing_table]',
						'output_children' => '[PREFIX_price{{caption}}{{heading_tag}}{{cost}}{{color}}{{color_text}}{{appearance}}{{class}}]{{content}}[/PREFIX_price]',
						'params'          => array( 'no_margin', 'class' ),
						'params_children' => array( 'caption', 'heading_tag', 'cost', 'color', 'color_text', 'appearance', 'class', 'content' ),
						'form'            => array(

								//Tab
								'general' => array(
									//Title
									'title'       => __( 'General', 'webman-amplifier' ),
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
													'label' => __( 'Remove margins between price columns?', 'webman-amplifier' ),
													//type specific
													'options' => array(
														'' => __( 'No', 'webman-amplifier' ),
														1  => __( 'Yes', 'webman-amplifier' ),
													),
													//preview
													'preview' => array( 'type' => 'refresh' ),
												), // /no_margin

											), // /fields
										), // /section

										//Section
										'sections' => array(
											'title'  => __( 'Price columns', 'webman-amplifier' ),
											'fields' => array(

												'children' => array(
													'type' => 'form',
													//description
													'label'       => '',
													'description' => '',
													'help'        => '',
													//default
													'default' => array( 'caption' => __( 'Caption', 'webman-amplifier' ) ), //This will be converted automatically
													//type specific
													'form'         => 'wm_children_form_' . 'pricing_table',
													'preview_text' => 'caption', //DO NOT FORGET TO SET!
													//multiple
													'multiple' => true,
													//preview
													'preview' => array( 'type' => 'refresh' ),
												), // /children

											), // /fields
										), // /section

									), // /sections
								), // /tab

							),
						'form_children'   => array(

								//Title
								'title' => __( 'Price', 'webman-amplifier' ),
								//Tabs
								'tabs' => array(

									//Tab
									'general' => array(
										//Title
										'title'       => __( 'General', 'webman-amplifier' ),
										'description' => '',
										//Sections
										'sections' => array(

											//Section
											'title' => array(
												'title'  => '',
												'fields' => array(

													'caption' => array(
														'type' => 'text',
														//description
														'label' => __( 'Caption', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'refresh' ),
													), // /caption

													'heading_tag' => array(
														'type' => 'text',
														//description
														'label' => __( 'Caption HTML tag', 'webman-amplifier' ),
														//type specific
														'placeholder' => 'h3',
														//preview
														'preview' => array( 'type' => 'none' ),
													), // /heading_tag

													'cost' => array(
														'type' => 'text',
														//description
														'label' => __( 'Cost', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'refresh' ),
													), // /cost

												), // /fields
											), // /section

											//Section
											'content' => array(
												'title'       => __( 'Features list', 'webman-amplifier' ),
												'description' => __( 'Insert an unordered list of features', 'webman-amplifier' ),
												'fields'      => array(

													'content' => array(
														'type' => 'editor',
														//description
														'label' => '',
														//default
														'default' => '<ul><li>TEXT</li><li>TEXT</li></ul>',
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
										'title'       => __( 'Others', 'webman-amplifier' ),
										'description' => '',
										//Sections
										'sections' => array(

											//Section
											'general' => array(
												'title'  => __( 'Colors', 'webman-amplifier' ),
												'fields' => array(

													'color' => array(
														'type' => 'color',
														//description
														'label' => __( 'Column color', 'webman-amplifier' ),
														//type specific
														'show_reset' => true,
														//preview
														'preview' => array( 'type' => 'refresh' ),
													), // /color

													'color_text' => array(
														'type' => 'color',
														//description
														'label' => __( 'Column text color', 'webman-amplifier' ),
														//type specific
														'show_reset' => true,
														//preview
														'preview' => array( 'type' => 'refresh' ),
													), // /color_text

												), // /fields
											), // /section

											//Section
											'styling' => array(
												'title'  => __( 'Column style', 'webman-amplifier' ),
												'fields' => array(

													'appearance' => array(
														'type' => 'select',
														//description
														'label' => __( 'Appearance', 'webman-amplifier' ),
														//type specific
														'options' => array(
																''         => __( 'Default price column', 'webman-amplifier' ),
																'featured' => __( 'Featured price column', 'webman-amplifier' ),
																'legend'   => __( 'Pricing table legend', 'webman-amplifier' ),
															),
														//preview
														'preview' => array( 'type' => 'refresh' ),
													), // /appearance

													'class' => array(
														'type' => 'text',
														//description
														'label' => __( 'CSS class', 'webman-amplifier' ),
														//preview
														'preview' => array( 'type' => 'none' ),
													), // /class

												), // /fields
											), // /section

										), // /sections
									), // /tab

								), // /tabs

							),
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Pricing table', 'webman-amplifier' ),
						'base'                    => $this->prefix_shortcode . 'pricing_table',
						'class'                   => 'wm-shortcode-vc-pricing_table wm-sections-mode',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'webman-amplifier' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon" data-is-container="true"></i> ' . __( 'Pricing table', 'webman-amplifier' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'price" data-item-title="' . __( 'Price', 'webman-amplifier' ) . '" class="add_tab" title="' . __( 'Pricing table: Add new price', 'webman-amplifier' ) . '">' . __( 'Pricing table: Add new price', 'webman-amplifier' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'price caption="' . __( 'Price 1', 'webman-amplifier' ).'"]' . __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'webman-amplifier' ) .'[/' . $this->prefix_shortcode . 'button][/' . $this->prefix_shortcode . 'price]
								[' . $this->prefix_shortcode . 'price caption="' . __( 'Price 2', 'webman-amplifier' ).'"]' . __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'webman-amplifier' ) .'[/' . $this->prefix_shortcode . 'button][/' . $this->prefix_shortcode . 'price]
							',
						'js_view'                 => 'VcCustomPricingTableView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Remove margins between price columns?', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'no_margin',
									'value'       => array(
											__( 'No', 'webman-amplifier' )  => '',
											__( 'Yes', 'webman-amplifier' ) => 1,
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'CSS class', 'webman-amplifier' ),
									'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),



		/**
		 * Price (Prising table item)
		 *
		 * @since  1.0
		 */
		'price' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'generator'  => array(
						'name'  => __( 'Price (pricing table item)', 'webman-amplifier' ),
						'code'  => '[PREFIX_price caption="' . __( 'Title', 'webman-amplifier' ) . '" cost="99$" color="" color_text="" appearance="default/featured/legend" class=""]{{content}}[/PREFIX_price]',
						'short' => false,
					),
				'vc_plugin'  => array(
						'name'            => $this->prefix_shortcode_name . __( 'Price', 'webman-amplifier' ),
						'base'            => $this->prefix_shortcode . 'price',
						'class'           => 'wm-shortcode-vc-price',
						'content_element' => false,
						'category'        => __( 'Content', 'webman-amplifier' ),
						'params'          => array(
								array(
									'heading'     => __( 'Caption', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'caption',
									'value'       => '',
									'holder'      => 'div',
									'class'       => '',
								),
								array(
									'heading'    => __( 'Cost', 'webman-amplifier' ),
									'type'       => 'textarea',
									'param_name' => 'cost',
									'value'      => '',
									'holder'     => 'hidden',
									'class'      => '',
								),
								array(
									'heading'     => __( 'Features list', 'webman-amplifier' ),
									'description' => __( 'Insert an unordered list of features', 'webman-amplifier' ),
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes']['options'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'webman-amplifier' ) .'[/' . $this->prefix_shortcode . 'button]',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Column color', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'colorpicker',
									'param_name'  => 'color',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Column text color', 'webman-amplifier' ),
									'type'        => 'colorpicker',
									'param_name'  => 'color_text',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Appearance', 'webman-amplifier' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'appearance',
									'value'       => array(
											__( 'Default price column', 'webman-amplifier' )  => '',
											__( 'Featured price column', 'webman-amplifier' ) => 'featured',
											__( 'Pricing table legend', 'webman-amplifier' )  => 'legend',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'CSS class', 'webman-amplifier' ),
									'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),



	/**
	 * Progress bar
	 *
	 * @since  1.0
	 */
	'progress' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Progress bar', 'webman-amplifier' ),
					'code'  => '[PREFIX_progress color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" progress="75" class=""]{{content}}[/PREFIX_progress]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Progress bar', 'webman-amplifier' ),
					'output' => '[PREFIX_progress{{color}}{{progress}}{{class}}]{{content}}[/PREFIX_progress]',
					'params' => array( 'color', 'progress', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'progress' => array(
												'type' => 'text',
												//description
												'label' => __( 'Progress in %', 'webman-amplifier' ),
												'help'  => __( 'Insert a number between 0 and 100', 'webman-amplifier' ),
												//default
												'default' => 75,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /progress

											'color' => array(
												'type' => 'select',
												//description
												'label' => __( 'Color', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['colors'],
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /color

											), // /fields
										), // /section

										//Section
										'content' => array(
											'title'  => __( 'Caption', 'webman-amplifier' ),
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

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Progress bar', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'progress',
					'class'    => 'wm-shortcode-vc-progress',
					'icon'     => 'icon-wpb-graph',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Caption', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea_html',
								'param_name'  => 'content',
								'value'       => __( 'Progress bar caption', 'webman-amplifier' ),
								'holder'      => 'div',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Progress in %', 'webman-amplifier' ),
								'description' => __( 'Insert a number between 0 and 100', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'progress',
								'value'       => '75',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'    => __( 'Color', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'color',
								'value'      => $empty + array_flip( self::$codes_globals['colors'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							40 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Row
	 *
	 * @since  1.0
	 */
	'row' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Row', 'webman-amplifier' ),
					'code'  => ( wma_is_active_vc() ) ? ( '[vc_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/vc_row]' ) : ( '[PREFIX_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/PREFIX_row]' ),
					'short' => false,
				),
		),



	/**
	 * Search form
	 *
	 * @since  1.0
	 */
	'search_form' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Search form', 'webman-amplifier' ),
					'code'  => '[PREFIX_search_form /]',
					'short' => true,
				),
		),



	/**
	 * Separator heading
	 *
	 * @since  1.0
	 */
	'separator_heading' => array(
			'since'      => '1.0',
			'preprocess' => true,
			'generator'  => array(
					'name'  => __( 'Separator heading', 'webman-amplifier' ),
					'code'  => '[PREFIX_separator_heading align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '" tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '" class="" id=""]{{content}}[/PREFIX_separator_heading]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Separator heading', 'webman-amplifier' ),
					'output' => '[PREFIX_separator_heading{{align}}{{tag}}{{id}}{{class}}]{{content}}[/PREFIX_separator_heading]',
					'params' => array( 'align', 'tag', 'id', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Heading text', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /content

											'tag' => array(
												'type' => 'select',
												//description
												'label' => __( 'Heading size', 'webman-amplifier' ),
												//default
												'default' => 'h2',
												//type specific
												'options' => array(
														'h1' => 'H1',
														'h2' => 'H2',
														'h3' => 'H3',
														'h4' => 'H4',
														'h5' => 'H5',
														'h6' => 'H6',
													),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /tag

											'align' => array(
												'type' => 'select',
												//description
												'label' => __( 'Text align', 'webman-amplifier' ),
												//type specific
												'options' => array(
														'left'   => __( 'Left', 'webman-amplifier' ),
														'center' => __( 'Center', 'webman-amplifier' ),
														'right'  => __( 'Right', 'webman-amplifier' ),
													),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /align

											'id' => array(
												'type' => 'text',
												//description
												'label' => __( 'Optional HTML ID', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /id

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Separator heading', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'separator_heading',
					'class'    => 'wm-shortcode-vc-separator_heading',
					'icon'     => 'icon-wpb-ui-separator-label',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Heading text', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textfield',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'div',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Heading size', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'tag',
								'value'       => array(
										''   => '', // prevent forcing h1 as default
										'H1' => 'h1',
										'H2' => 'h2',
										'H3' => 'h3',
										'H4' => 'h4',
										'H5' => 'h5',
										'H6' => 'h6',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Text align', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'align',
								'value'       => array(
										__( 'Left', 'webman-amplifier' )   => 'left', // default
										__( 'Center', 'webman-amplifier' ) => 'center',
										__( 'Right', 'webman-amplifier' )  => 'right',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							40 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							50 => array(
								'heading'     => __( 'Optional HTML ID', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'id',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Slideshow
	 *
	 * @since  1.0
	 */
	'slideshow' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Slideshow', 'webman-amplifier' ),
					'code'  => '[PREFIX_slideshow ids="" nav="none/thumbs/pagination" size="full/' . implode( '/', get_intermediate_image_sizes() ) . '" speed="3000" class="" /]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Slideshow', 'webman-amplifier' ),
					'output' => '[PREFIX_slideshow{{ids}}{{nav}}{{size}}{{speed}}{{class}} /]',
					'params' => array( 'ids', 'nav', 'size', 'speed', 'class' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'ids' => array(
												'type' => 'multiple-photos',
												//description
												'label' => __( 'Images', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /ids

											'nav' => array(
												'type' => 'select',
												//description
												'label' => __( 'Navigation', 'webman-amplifier' ),
												//type specific
												'options' => array(
														''           => __( 'Just Next/Prev button', 'webman-amplifier' ),
														'thumbs'     => __( 'Thumbnails', 'webman-amplifier' ),
														'pagination' => __( 'Pagination', 'webman-amplifier' ),
													),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /nav

											'image_size' => array(
												'type' => 'select',
												//description
												'label' => __( 'Image size', 'webman-amplifier' ),
												//type specific
												'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /image_size

											'speed' => array(
												'type' => 'text',
												//description
												'label' => __( 'Speed in miliseconds', 'webman-amplifier' ),
												//default
												'default' => apply_filters( 'wmhook_shortcode_' . 'slideshow_speed', 3000 ),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /speed

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Slideshow', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'slideshow',
					'class'    => 'wm-shortcode-vc-slideshow',
					'icon'     => 'icon-wpb-images-carousel',
					'category' => __( 'Media', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Images', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'attach_images',
								'param_name'  => 'ids',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							20 => array(
								'heading'    => __( 'Navigation', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'nav',
								'value'      => array(
										__( 'Just Next/Prev button', 'webman-amplifier' ) => '',
										__( 'Thumbnails', 'webman-amplifier' )            => 'thumbs',
										__( 'Pagination', 'webman-amplifier' )            => 'pagination',
									),
								'holder'     => 'hidden',
								'class'      => '',
							),
							30 => array(
								'heading'    => __( 'Image size', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'image_size',
								'value'      => wma_asort( $empty + array_flip( wma_get_image_sizes() ) ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							40 => array(
								'heading'     => __( 'Speed in miliseconds', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textfield',
								'param_name'  => 'speed',
								'value'       => apply_filters( 'wmhook_shortcode_' . 'slideshow_speed', 3000 ),
								'holder'      => 'hidden',
								'class'       => '',
							),
							50 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Table (CSV data)
	 *
	 * @since  1.0
	 */
	'table' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Table (CSV data)', 'webman-amplifier' ),
					'code'  => '[PREFIX_table appearance="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['table_appearance'] ) ) ) . '" separator="," class=""]{{content}}[/PREFIX_table]',
					'short' => false,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Table', 'webman-amplifier' ),
					'output' => '[PREFIX_table{{appearance}}{{separator}}{{class}}]{{content}}[/PREFIX_table]',
					'params' => array( 'appearance', 'separator', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
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
												'label' => __( 'Appearance', 'webman-amplifier' ),
												//type specific
												'options' => self::$codes_globals['table_appearance'],
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /appearance

											'separator' => array(
												'type' => 'text',
												//description
												'label' => __( 'CSV data separator', 'webman-amplifier' ),
												//default
												'default' => ',',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /separator

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => __( 'CSV data', 'webman-amplifier' ),
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
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Table (CSV data)', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'table',
					'class'    => 'wm-shortcode-vc-table',
					'icon'     => 'vc_icon-vc-media-grid',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'    => __( 'CSV data', 'webman-amplifier' ),
								'type'       => 'textarea_html',
								'param_name' => 'content',
								'value'      => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
								'holder'     => 'hidden',
								'class'      => '',
							),
							20 => array(
								'heading'    => __( 'CSV data separator', 'webman-amplifier' ),
								'type'       => 'textfield',
								'param_name' => 'separator',
								'value'      => ',',
								'holder'     => 'hidden',
								'class'      => '',
							),
							30 => array(
								'heading'    => __( 'Appearance', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'appearance',
								'value'      => $empty + array_flip( self::$codes_globals['table_appearance'] ),
								'holder'     => 'hidden',
								'class'      => '',
							),
							40 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Testimonials
	 *
	 * @since  1.0
	 */
	'testimonials' => array(
			'since'              => '1.0',
			'post_type_required' => 'wm_testimonials',
			'preprocess'         => false,
			'generator'          => array(
					'name'  => __( 'Testimonials', 'webman-amplifier' ),
					'code'  => '[PREFIX_testimonials testimonial="testimonial-slug" align="left/right" columns="4" count="-1" order="new/old/name/random" category="optional-category-slug" scroll="0" pagination="0/1" no_margin="0/1" class=""]{{content}}[/PREFIX_testimonials]',
					'short' => false,
				),
			'bb_plugin'          => array(
					'name'   => __( 'Testimonials', 'webman-amplifier' ),
					'output' => '[PREFIX_testimonials{{testimonial}}{{align}}{{columns}}{{count}}{{order}}{{category}}{{scroll}}{{pagination}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_testimonials]',
					'params' => array( 'testimonial', 'align', 'columns', 'count', 'order', 'category', 'scroll', 'pagination', 'no_margin', 'heading_tag', 'class', 'content' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'single' => array(
										'title'  => __( 'Single testimonial display', 'webman-amplifier' ),
										'fields' => array(

											'testimonial' => array(
												'type' => 'select',
												//description
												'label' => __( 'Single testimonial', 'webman-amplifier' ),
												'help'  => __( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
												//type specific
												'options' => $wm_testimonials_slugs,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /testimonial

										), // /fields
									), // /section

									//Section
									'multiple' => array(
										'title'  => __( 'Multiple modules display', 'webman-amplifier' ),
										'fields' => array(

											'count' => array(
												'type' => 'text',
												//description
												'label' => __( 'Count', 'webman-amplifier' ),
												'help'  => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
												//default
												'default' => 3,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /count

											'columns' => array(
												'type' => 'select',
												//description
												'label' => __( 'Columns', 'webman-amplifier' ),
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
												'label' => __( 'Order', 'webman-amplifier' ),
												//type specific
												'options' => array(
														'new'    => __( 'Newest first', 'webman-amplifier' ),
														'old'    => __( 'Oldest first', 'webman-amplifier' ),
														'name'   => __( 'By name', 'webman-amplifier' ),
														'random' => __( 'Randomly', 'webman-amplifier' ),
													),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /order

											'scroll' => array(
												'type' => 'text',
												//description
												'label' => __( 'Scrolling', 'webman-amplifier' ),
												'help'  => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /scroll

											'category' => array(
												'type' => 'select',
												//description
												'label' => __( 'From category', 'webman-amplifier' ),
												'help'  => __( 'Displays items only from a specific category', 'webman-amplifier' ),
												//type specific
												'options' => $wm_testimonials_categories,
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /category

											'pagination' => array(
												'type' => 'select',
												//description
												'label' => __( 'Display pagination?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
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
								'title'       => __( 'Description', 'webman-amplifier' ),
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
												'label' => __( 'Description alignment', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'left'  => __( 'Left', 'webman-amplifier' ),
													'right' => __( 'Right', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /align

										), // /fields
									), // /section

									//Section
									'content' => array(
										'title'  => __( 'Content', 'webman-amplifier' ),
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
								'title'       => __( 'Others', 'webman-amplifier' ),
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
												'label' => __( 'Remove gap between items?', 'webman-amplifier' ),
												//type specific
												'options' => array(
													'' => __( 'No', 'webman-amplifier' ),
													1  => __( 'Yes', 'webman-amplifier' ),
												),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /no_margin

											'heading_tag' => array(
												'type' => 'text',
												//description
												'label' => __( 'Heading HTML tag', 'webman-amplifier' ),
												//type specific
												'placeholder' => 'h2',
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /heading_tag

										), // /fields
									), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'          => array(
					'name'     => $this->prefix_shortcode_name . __( 'Testimonials', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'testimonials',
					'class'    => 'wm-shortcode-vc-testimonials',
					'icon'     => 'vc_icon-vc-gitem-post-title',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Single testimonial', 'webman-amplifier' ),
								'description' => __( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'testimonial',
								'value'       => array_flip( $wm_testimonials_slugs ), // 1st value is empty
								'holder'      => 'div',
								'class'       => '',
							),

							20 => array(
								'heading'     => __( 'Count', 'webman-amplifier' ),
								'description' => __( 'Number of items to display (use "-1" to display all)', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'count',
								'value'       => 3,
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							30 => array(
								'heading'    => __( 'Columns', 'webman-amplifier' ),
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
								'group'      => __( 'Multiple display', 'webman-amplifier' ),
							),
							40 => array(
								'heading'    => __( 'Order', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'order',
								'value'      => array(
										__( 'Newest first', 'webman-amplifier' ) => 'new', // default
										__( 'Oldest first', 'webman-amplifier' ) => 'old',
										__( 'By name', 'webman-amplifier' )      => 'name',
										__( 'Randomly', 'webman-amplifier' )     => 'random',
									),
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Multiple display', 'webman-amplifier' ),
							),
							50 => array(
								'heading'     => __( 'Scrolling', 'webman-amplifier' ),
								'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'scroll',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							60 => array(
								'heading'     => __( 'Category', 'webman-amplifier' ),
								'description' => __( 'Displays items only from a specific category', 'webman-amplifier' ),
								'type'        => 'dropdown',
								'param_name'  => 'category',
								'value'       => array_flip( $wm_testimonials_categories ), // 1st value is empty
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							70 => array(
								'heading'     => __( 'Display pagination?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'pagination',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							80 => array(
								'heading'     => __( 'Description text (HTML)', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'textarea',
								'param_name'  => 'content',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),
							90 => array(
								'heading'    => __( 'Description alignment', 'webman-amplifier' ),
								'type'       => 'dropdown',
								'param_name' => 'align',
								'value'      => array(
										__( 'Left', 'webman-amplifier' )  => 'left', // default
										__( 'Right', 'webman-amplifier' ) => 'right',
									),
								'holder'     => 'hidden',
								'class'      => '',
								'group'      => __( 'Multiple display', 'webman-amplifier' ),
							),
							100 => array(
								'heading'     => __( 'Remove gap between items?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'no_margin',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Multiple display', 'webman-amplifier' ),
							),

							110 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Video
	 *
	 * @since  1.0
	 */
	'video' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Video', 'webman-amplifier' ),
					'code'  => '[PREFIX_video src="" poster="" autoplay="0/1" loop="0/1" class="" /]',
					'short' => false,
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Video', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'video',
					'class'    => 'wm-shortcode-vc-video',
					'icon'     => 'icon-wpb-film-youtube',
					'category' => __( 'Media', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Video source', 'webman-amplifier' ),
								'description' => __( 'Set the video URL', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'src',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Poster', 'webman-amplifier' ),
								'description' => __( 'Optional placeholder image', 'webman-amplifier' ),
								'type'        => 'attach_image',
								'param_name'  => 'poster',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
							30 => array(
								'heading'     => __( 'Autoplay the video?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'autoplay',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 'on',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							40 => array(
								'heading'     => __( 'Loop the video?', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'loop',
								'value'       => array(
										__( 'No', 'webman-amplifier' )  => '',
										__( 'Yes', 'webman-amplifier' ) => 'on',
									),
								'holder'      => 'hidden',
								'class'       => '',
							),
							50 => array(
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				),
		),



	/**
	 * Widgets area
	 *
	 * @since  1.0
	 */
	'widget_area' => array(
			'since'      => '1.0',
			'preprocess' => false,
			'generator'  => array(
					'name'  => __( 'Widgets area', 'webman-amplifier' ),
					'code'  => '[PREFIX_widget_area area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '" class="" max_widgets_count="0" /]',
					'short' => true,
				),
			'bb_plugin'  => array(
					'name'   => __( 'Widgets area', 'webman-amplifier' ),
					'output' => '[PREFIX_widget_area{{area}}{{max_widgets_count}}{{class}} /]',
					'params' => array( 'area', 'max_widgets_count', 'class' ),
					'form'   => array(

							//Tab
							'general' => array(
								//Title
								'title'       => __( 'General', 'webman-amplifier' ),
								'description' => '',
								//Sections
								'sections' => array(

									//Section
									'general' => array(
										'title'  => '',
										'fields' => array(

											'area' => array(
												'type' => 'select',
												//description
												'label' => __( 'Widgets area', 'webman-amplifier' ),
												//type specific
												'options' => wma_widget_areas_array(),
												//preview
												'preview' => array( 'type' => 'refresh' ),
											), // /area

											'max_widgets_count' => array(
												'type' => 'select',
												//description
												'label' => __( 'Maximum widgets count', 'webman-amplifier' ),
												'help'  => __( 'Area will not be displayed when the number of widgets inserted in it is greater', 'webman-amplifier' ),
												//type specific
												'options' => array(
														'-' => '',
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
														11  => 11,
														12  => 12,
													),
												//preview
												'preview' => array( 'type' => 'none' ),
											), // /max_widgets_count

											), // /fields
										), // /section

								), // /sections
							), // /tab

						),
				),
			'vc_plugin'  => array(
					'name'     => $this->prefix_shortcode_name . __( 'Widgets area', 'webman-amplifier' ),
					'base'     => $this->prefix_shortcode . 'widget_area',
					'class'    => 'wm-shortcode-vc-widget_area',
					'icon'     => 'icon-wpb-layout_sidebar',
					'category' => __( 'Content', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Widgets area', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'area',
								'value'       => array_flip( wma_widget_areas_array() ), // 1st value is empty
								'holder'      => 'div',
								'class'       => '',
							),
							20 => array(
								'heading'     => __( 'Maximum widgets count', 'webman-amplifier' ),
								'description' => __( 'Area will not be displayed when the number of widgets inserted in it is greater', 'webman-amplifier' ),
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
								'heading'     => __( 'CSS class', 'webman-amplifier' ),
								'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
								'type'        => 'textfield',
								'param_name'  => 'class',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
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
				'name'                    => __( 'Row / Section', 'webman-amplifier' ),
				'base'                    => 'vc_row',
				'class'                   => 'wm-shortcode-vc-row',
				'icon'                    => 'icon-wpb-row',
				'category'                => __( 'Structure', 'webman-amplifier' ),
				'is_container'            => true,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
						10 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'    => __( 'Optional HTML ID', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'id',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						60 => array(
							'heading'     => __( 'Parallax scroll speed', 'webman-amplifier' ),
							'description' => __( 'Set the inertia of parallax background moving. For example, value of <code>0.1</code> equals to tenth of normal scroll speed.', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'parallax',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'dependency'  => array(
									'element'   => 'bg_image',
									'not_empty' => true
								),
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						70 => array(
							'heading'     => __( 'Padding', 'webman-amplifier' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						80 => array(
							'heading'     => __( 'Margin', 'webman-amplifier' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'margin',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
					)
			)
		);



	/**
	 * Redefine the vc_row_inner shortcode
	 *
	 * @since  1.0
	 */
	$shortcode_definitions['vc_row_inner'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'                    => __( 'Row', 'webman-amplifier' ),
				'base'                    => 'vc_row_inner',
				'class'                   => 'wm-shortcode-vc-row-inner',
				'icon'                    => 'icon-wpb-row',
				'category'                => __( 'Structure', 'webman-amplifier' ),
				'content_element'         => false,
				'is_container'            => true,
				'weight'                  => 1000,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
						10 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					)
			)
		);



	/**
	 * Redefine the vc_column shortcode
	 *
	 * @since  1.0
	 */
	$shortcode_definitions['vc_column'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'            => __( 'Column', 'webman-amplifier' ),
				'base'            => 'vc_column',
				'class'           => 'wm-shortcode-vc-column',
				'category'        => __( 'Structure', 'webman-amplifier' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
						10 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'    => __( 'Optional HTML ID', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'id',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						60 => array(
							'heading'     => __( 'Padding', 'webman-amplifier' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
					)
			)
		);



	/**
	 * Redefine the vc_column_inner shortcode
	 *
	 * @since  1.0.9
	 */
	$shortcode_definitions['vc_column_inner'] = array(
			'since'     => '1.0.9',
			'vc_plugin' => array(
				'name'            => __( 'Column', 'webman-amplifier' ),
				'base'            => 'vc_column_inner',
				'class'           => 'wm-shortcode-vc-inner-column',
				'category'        => __( 'Structure', 'webman-amplifier' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
						10 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'    => __( 'Optional HTML ID', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'id',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						60 => array(
							'heading'     => __( 'Padding', 'webman-amplifier' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
					)
			)
		);



	/**
	 * Text block
	 *
	 * @since  1.0
	 */
	$shortcode_definitions['text_block'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $this->prefix_shortcode_name . __( 'Text block', 'webman-amplifier' ),
				'base'     => $this->prefix_shortcode . 'text_block',
				'class'    => 'wm-shortcode-vc-text_block',
				'icon'     => 'icon-wpb-layer-shape-text',
				'category' => __( 'Content', 'webman-amplifier' ),
				'params'   => array(
						10 => array(
							'heading'     => __( 'Content', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'textarea_html',
							'param_name'  => 'content',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
					)
			)
		);



	/**
	 * Image
	 *
	 * @since  1.0
	 */
	$shortcode_definitions['image'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $this->prefix_shortcode_name . __( 'Image', 'webman-amplifier' ),
				'base'     => $this->prefix_shortcode . 'image',
				'class'    => 'wm-shortcode-vc-image',
				'icon'     => 'icon-wpb-single-image',
				'category' => __( 'Media', 'webman-amplifier' ),
				'params'   => array(
						10 => array(
							'heading'     => __( 'Image to display', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'src',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'    => __( 'Image link URL', 'webman-amplifier' ),
							'type'       => 'textfield',
							'param_name' => 'link',
							'value'      => '',
							'holder'     => 'hidden',
							'class'      => '',
						),
						30 => array(
							'heading'     => __( 'Target', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'target',
							'value'       => array(
									__( 'Open in same window', 'webman-amplifier' )      => '',
									__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
								),
							'holder'      => 'hidden',
							'class'       => '',
							'dependency'  => array(
									'element'   => 'link',
									'not_empty' => true
								),
						),
						40 => array(
							'heading'     => __( 'CSS class', 'webman-amplifier' ),
							'description' => __( 'Optional CSS additional classes', 'webman-amplifier' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),

						50 => array(
							'heading'     => __( 'Image width HTML attribute', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'textfield',
							'param_name'  => 'width',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						60 => array(
							'heading'     => __( 'Image height HTML attribute', 'webman-amplifier' ),
							'description' => '',
							'type'        => 'textfield',
							'param_name'  => 'height',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
						70 => array(
							'heading'     => __( 'Margin', 'webman-amplifier' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'margin',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'webman-amplifier' ),
						),
					)
			)
		);



	/**
	 * Soliloquy
	 *
	 * @since  1.0
	 */
	if ( post_type_exists( 'soliloquy' ) ) {
		$shortcode_definitions['soliloquy'] = array(
				'since'      => '1.0',
				'vc_plugin'  => array(
					'name'     => __( 'Soliloquy Slider', 'webman-amplifier' ),
					'base'     => 'soliloquy',
					'class'    => 'wm-shortcode-vc-soliloquy',
					'icon'     => 'icon-wpb-images-carousel',
					'category' => __( 'Media', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Choose a Soliloquy slider', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'id',
								'value'       => array_flip( wma_posts_array( 'post_name', 'soliloquy' ) ), // 1st value is empty
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				)
			);
	}



	/**
	 * Master Slider
	 *
	 * @since  1.0.9
	 */
	if ( function_exists( 'get_masterslider_names' ) ) {
		$shortcode_definitions['masterslider'] = array(
				'since'      => '1.0.9',
				'vc_plugin'  => array(
					'name'     => __( 'Master Slider', 'webman-amplifier' ),
					'base'     => 'masterslider',
					'class'    => 'wm-shortcode-vc-masterslider',
					'icon'     => 'icon-wpb-images-carousel',
					'category' => __( 'Media', 'webman-amplifier' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Choose a slider', 'webman-amplifier' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'id',
								'value'       => $empty + get_masterslider_names( false ),
								'holder'      => 'hidden',
								'class'       => '',
							),
						)
				)
			);
	}



	/**
	 * Render certain VC shortcodes even when the plugin is disabled
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
