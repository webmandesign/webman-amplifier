<?php
/**
 * WebMan Shortcodes Definitions
 *
 * This file is being included into "../class-shortcodes.php" file's setup_globals() method.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @since       1.0
 * @version     1.0.9.10
 */

/**
 * Helpers:

	SHORTCODES ARRAY STRUCTURE:
		'shortcode-name' => array(
			//Plugin version since when the shortcode is available.
				'since' => '1.0',

			//Simple shortcode generator settings (array( 'name'=>'', 'code'=>'' )).
				'generator' => ARRAY,

			//Does shortcode need preprocessing?
				'preprocess' => BOOLEAN,

			//Post type name. The shortcode will be available only if this post type is enabled.
				'post_type_required' => STRING,

			//Overrides the default shortcode prefix when registering shortcode with WordPress. IMPORTANT: Set this only when required!
				'custom_prefix' => FALSE/STRING,

			//Style definition for visual editor [Styles] button.
				'style' => ARRAY( ARRAY ),

			//Renderer overrides (can be used for shortcode aliases).
				'renderer' => ARRAY(
						'alias' => 'shortcode',
						'path'  => 'custom_renderer_file_path'
					),

			//Add the shortcode definitions into Visual Composer plugin.
			//See http://kb.wpbakery.com/index.php?title=Vc_map
				'vc_plugin' => ARRAY( ARRAY )
			)

	TINYMCE EDITOR STYLE DEFINITION:
		title [required]
			= label for this style dropdown item
		selector | block | inline [required]
			= selector limits the style to a specific HTML tag, and will apply the style to an existing tag instead of creating one
			= block creates a new block-level element with the style applied, and WILL REPLACE the existing block element around the cursor
			= inline creates a new inline element with the style applied, and will wrap whatever is selected in the editor, not replacing any tags
		classes [optional]
			= space-separated list of classes to apply to the element
		styles [optional]
			= array of inline styles to apply to the element (two-word attributes, like font-weight, are written in Javascript-friendly camel case: fontWeight)
		attributes [optional]
			= assigns attributes to the element (same syntax as styles)
		wrapper [optional, default = false]
			= if set to true, creates a NEW BLOCK-LEVEL ELEMENT AROUND ANY SELECTED BLOCK-LEVEL ELEMENTS
		exact [optional, default = false]
			= disables the "merge similar styles" feature, needed for some CSS inheritance issues

		EXAMPLE:
			array(
				array(
					'title' => 'MESSAGE BOXES <span class="inline-help" title="Apply on selected text."></span>'
				),
				array(
					'title'   => 'Blue message',
					'block'   => 'div',
					'classes' => 'wm-message color-blue',
					'exact'   => true,
					'wrapper' => true
				),
			)
 */



//Helper variables
	$wm_social_icons_array = self::$codes_globals['social_icons'];
	array_push( $wm_social_icons_array, '', 'background-light', 'background-dark' );
	asort( $wm_social_icons_array );
	$wm_social_icons_array = array_combine( $wm_social_icons_array, $wm_social_icons_array );
	$wm_taxonomies = get_taxonomies( '', 'names' );
	unset( $wm_taxonomies['nav_menu'] );
	unset( $wm_taxonomies['link_category'] );
	asort( $wm_taxonomies );
	$wm_modules_slugs = wma_posts_array( 'post_name', 'wm_modules' );
	$wm_modules_tags  = wma_taxonomy_array( array(
			'all_post_type' => '',
			'all_text'      => '',
			'hierarchical'  => '0',
			'tax_name'      => 'module_tag'
		) );
	$wm_testimonials_slugs      = wma_posts_array( 'post_name', 'wm_testimonials' );
	$wm_testimonials_categories = wma_taxonomy_array( array(
			'all_post_type' => '',
			'all_text'      => '',
			'hierarchical'  => '0',
			'tax_name'      => 'testimonial_category'
		) );



$shortcode_definitions = array(

	//Accordions, tabs, toggles
		/**
		 * Accordion / toggles wrapper
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'accordion' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Accordion / Toggle', 'wm_domain' ),
						'code'       => '[PREFIX_accordion active="0" mode="accordion/toggle" filter="0/1" class=""]<br />[PREFIX_item title="' . __( 'Section 1', 'wm_domain' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . __( 'Section 2', 'wm_domain' ) . '" tags="" icon="" heading_tag=""]' . __( 'Section 2 content goes here', 'wm_domain' ) . '[/PREFIX_item]<br />[/PREFIX_accordion]',
						'vc_enabled' => false,
					),
				'bb_plugin'  => array(
						'name'            => __( 'Accordion', 'wm_domain' ),
						'output'          => '[PREFIX_accordion{{icon}}]{{children}}[/PREFIX_accordion]',
						'output_children' => '[PREFIX_item{{title}}{{icon}}{{tags}}{{heading_tag}}]{{content}}[/PREFIX_item]',
						'params'          => array( 'icon' ),
						'params_children' => array( 'title', 'icon', 'tags', 'content', 'heading_tag' ),
						'form'            => array(

								//Tab
								'general' => array(
									//Title
									'title'       => __( 'General', 'wm_domain' ),
									'description' => '',
									//Sections
									'sections' => array(

										//Section
										'general' => array(
											'title'  => '',
											'fields' => array(

												'children' => array(
													'type' => 'form',
													//description
													'label'       => __( 'Items', 'wm_domain' ),
													'description' => '',
													'help'        => '',
													//default
													'default' => '',
													//type specific
													'form'         => 'wm_children_form_' . 'accordion',
													'preview_text' => 'title', //DO NOT FORGET TO SET!
													//multiple
													'multiple' => true,
													//preview
													'preview' => array(
														'type' => 'refresh',
													),
												), // /children

											), // /fields
										), // /section

									), // /sections
								), // /tab

							),
						'form_children'   => array(

								//Title
								'title' => __( 'Add Image', 'wm_domain' ),
								//Tabs
								'tabs' => array(

									//Tab
									'general' => array(
										//Title
										'title'       => __( 'General', 'wm_domain' ),
										'description' => '',
										//Sections
										'sections' => array(

											//Section
											'label' => array(
												'title'  => '',
												'fields' => array(

													'title' => array(
														'type' => 'text',
														//description
														'label' => __( 'Section title', 'wm_domain' ),
														//default
														'default' => __( 'Section', 'wm_domain' ),
														//preview
														'preview' => array(
															'type' => 'none',
														),
													), // /title

													'icon' => array(
														'type' => 'wm_radio',
														//description
														'label' => __( 'Icon', 'wm_domain' ),
														//type specific
														'options'    => self::$codes_globals['font_icons'],
														'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
														'hide_radio' => true,
														'inline'     => true,
														//preview
														'preview' => array(
															'type' => 'none',
														),
													), // /icon

													'tags' => array(
														'type' => 'text',
														//description
														'label' => __( 'Tags', 'wm_domain' ),
														'help'  => __( 'Enter comma separated tags. These will be used to filter through items.', 'wm_domain' ),
														//preview
														'preview' => array(
															'type' => 'none',
														),
													), // /tags

												), // /fields
											), // /section

											//Section
											'content' => array(
												'title'  => __( 'Content', 'wm_domain' ),
												'fields' => array(

													'content' => array(
														'type' => 'editor',
														//description
														'label' => '',
														//preview
														'preview' => array(
															'type'     => 'text',
															'selector' => '.fl-wm-test',
														),
													), // /content

												), // /fields
											), // /section

											//Section
											'advanced' => array(
												'title'  => __( 'Advanced', 'wm_domain' ),
												'fields' => array(

													'heading_tag' => array(
														'type' => 'text',
														//description
														'label' => __( 'HTML heading tag', 'wm_domain' ),
														'help'  => __( 'Defaults to H3 heading. You can override it here if required.', 'wm_domain' ),
														//type specific
														'placeholder' => 'h3',
														//preview
														'preview' => array(
															'type' => 'none',
														),
													), // /heading_tag

												), // /fields
											), // /section

										), // /sections
									), // /tab

								), // /tabs

							),
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Accordion', 'wm_domain' ),
						'base'                    => $this->prefix_shortcode . 'accordion',
						'class'                   => 'wm-shortcode-vc-accordion wm-sections-mode',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'wm_domain' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title">' . __( 'Accordion', 'wm_domain' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'item" data-item-title="' . __( 'Section', 'wm_domain' ) . '" class="add_tab" title="' . __( 'Accordion: Add new section', 'wm_domain' ) . '">' . __( 'Accordion: Add new section', 'wm_domain' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'item title="' . __( 'Section 1', 'wm_domain' ).'"][/' . $this->prefix_shortcode . 'item]
								[' . $this->prefix_shortcode . 'item title="' . __( 'Section 2', 'wm_domain' ).'"][/' . $this->prefix_shortcode . 'item]
							',
						'js_view'                 => 'VcCustomAccordionView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Active section', 'wm_domain' ),
									'description' => __( 'Enter the order number of the section which should be open by default, set "0" for all sections closed', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'active',
									'value'       => 0,
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Mode', 'wm_domain' ),
									'description' => __( 'Should only one section be active at a time or multiple ones?', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'mode',
									'value'       => array(
											__( 'Accordion (allow only one section open)', 'wm_domain' ) => 'accordion',
											__( 'Toggle (allow multiple sections open)', 'wm_domain' )   => 'toggle',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Filtering', 'wm_domain' ),
									'description' => __( 'Display the sections filter?', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'filter',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
		 * @since    1.0
		 * @version  1.0.9.10
		 */
		'tabs' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Tabs', 'wm_domain' ),
						'code'       => '[PREFIX_tabs active="0" layout="top/left/right" tour="0/1" class=""]<br />[PREFIX_item title="' . __( 'Tab 1', 'wm_domain' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . __( 'Tab 2', 'wm_domain' ) . '" tags="" icon="" heading_tag=""]' . __( 'Tab 2 content goes here', 'wm_domain' ) . '[/PREFIX_item]<br />[/PREFIX_tabs]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Tabs', 'wm_domain' ),
						'base'                    => $this->prefix_shortcode . 'tabs',
						'class'                   => 'wm-shortcode-vc-tabs wm-sections-mode',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'wm_domain' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title">' . __( 'Tabs', 'wm_domain' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'item" data-item-title="' . __( 'Tab', 'wm_domain' ) . '" class="add_tab" title="' . __( 'Tabs: Add new tab', 'wm_domain' ) . '">' . __( 'Tabs: Add new tab', 'wm_domain' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'item title="' . __( 'Tab 1', 'wm_domain' ).'"][/' . $this->prefix_shortcode . 'item]
								[' . $this->prefix_shortcode . 'item title="' . __( 'Tab 2', 'wm_domain' ).'"][/' . $this->prefix_shortcode . 'item]
							',
						'js_view'                 => 'VcCustomAccordionView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Active tab', 'wm_domain' ),
									'description' => __( 'Enter the order number of the tab which should be open by default', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'active',
									'value'       => 1,
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Layout', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'layout',
									'value'       => array(
											__( 'Tabs on top', 'wm_domain' )   => 'top',
											__( 'Tabs on left', 'wm_domain' )  => 'left',
											__( 'Tabs on right', 'wm_domain' ) => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Enable tour mode?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'tour',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
		 * @since    1.0
		 * @version  1.1
		 */
		'item' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Item (accordion or tab section)', 'wm_domain' ),
						'code'       => '[PREFIX_item title="' . __( 'Title', 'wm_domain' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'                      => $this->prefix_shortcode_name . __( 'Item (Accordion / Tab)', 'wm_domain' ),
						'base'                      => $this->prefix_shortcode . 'item',
						'class'                     => 'wm-shortcode-vc-item wm-sections-mode-section wpb_vc_accordion_tab',
						'allowed_container_element' => 'vc_row',
						'is_container'              => true,
						'content_element'           => false,
						'category'                  => __( 'Content', 'wm_domain' ),
						'js_view'                   => 'VcCustomAccordionTabView',
						'params'                    => array(
								10 => array(
									'heading'     => __( 'Title', 'wm_domain' ),
									'description' => __( 'Set the section title', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'title',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Optional icon', 'wm_domain' ),
									'description' => __( 'Choose one of available icons', 'wm_domain' ),
									'type'        => 'wm_radio',
									'param_name'  => 'icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Tags', 'wm_domain' ),
									'description' => __( 'Enter comma separated tags. These will be used to filter through items.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'tags',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'HTML heading tag', 'wm_domain' ),
									'description' => __( 'Defaults to H3 heading. You can override it here if required.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'heading_tag',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Audio
		/**
		 * Audio
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'audio' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Audio', 'wm_domain' ),
						'code'       => '[PREFIX_audio src="" autoplay="0/1" loop="0/1" class="" /]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Audio', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'audio',
						'class'    => 'wm-shortcode-vc-audio',
						'category' => __( 'Media', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Audio source', 'wm_domain' ),
									'description' => __( 'Set the audio URL', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'src',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Autoplay the audio?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'autoplay',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => 'on',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Loop the audio?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'loop',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => 'on',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Buttons
		/**
		 * Button
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'button' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Button', 'wm_domain' ),
						'code'       => '[PREFIX_button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_button]',
						'vc_enabled' => true,
					),
				'bb_plugin'  => array(
						'name'   => __( 'Button', 'wm_domain' ),
						'output' => '[PREFIX_button{{url}}{{icon}}]{{content}}[/PREFIX_button]',
						'params' => array( 'icon', 'url', 'content' ),
						'form'   => array(

								//Tab
								'general' => array(
									//Title
									'title'       => __( 'General', 'wm_domain' ),
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
													'label' => __( 'Button text', 'wm_domain' ),
													//default
													'default' => __( 'Button Text', 'wm_domain' ),
													//preview
													'preview' => array(
														'type' => 'none',
													),
												), // /content

												'url' => array(
													'type' => 'text',
													//description
													'label' => __( 'Button link', 'wm_domain' ),
													//default
													'default' => '#',
													//preview
													'preview' => array(
														'type' => 'none',
													),
												), // /url

												'icon' => array(
													'type' => 'wm_radio',
													//description
													'label' => __( 'Icon', 'wm_domain' ),
													//type specific
													'options'    => self::$codes_globals['font_icons'],
													'custom'     => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
													'hide_radio' => true,
													'inline'     => true,
													//preview
													'preview' => array(
														'type' => 'none',
													),
												), // /icon

											), // /fields
										), // /section

									), // /sections
								), // /tab

							),
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Button', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'button',
						'class'    => 'wm-shortcode-vc-button',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Button text', 'wm_domain' ),
									'description' => __( 'Enter button text (you can use inline HTML and inline shortcodes)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'content',
									'value'       => __( 'Button Text', 'wm_domain' ),
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Button URL', 'wm_domain' ),
									'description' => __( 'Set the button link URL', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'url',
									'value'       => '#',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Target', 'wm_domain' ),
									'description' => __( 'Button link target', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'target',
									'value'       => array(
											__( 'Open in same window', 'wm_domain' )      => '',
											__( 'Open in new window / tab', 'wm_domain' ) => '_blank',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'dependency'  => array(
											'element'   => 'url',
											'not_empty' => true
										),
								),
								40 => array(
									'heading'     => __( 'Color', 'wm_domain' ),
									'description' => __( 'Choose predefined button color', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'color',
									'value'       => array_flip( self::$codes_globals['colors'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'Size', 'wm_domain' ),
									'description' => __( 'Choose predefined button size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'size',
									'value'       => array_flip( self::$codes_globals['sizes'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								60 => array(
									'heading'     => __( 'Button icon', 'wm_domain' ),
									'description' => __( 'Choose one of available icons', 'wm_domain' ),
									'type'        => 'wm_radio',
									'param_name'  => 'icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'hidden',
									'class'       => '',
								),
								70 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								80 => array(
									'heading'     => __( 'HTML ID', 'wm_domain' ),
									'description' => __( 'Optional HTML ID', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'id',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Call to action
		/**
		 * Call to action
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'call_to_action' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Call to action', 'wm_domain' ),
						'code'       => '[PREFIX_call_to_action caption="" button_text="" button_url="#" button_color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" button_size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" button_icon="" class=""]{{content}}[/PREFIX_call_to_action]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Call to action', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'call_to_action',
						'class'    => 'wm-shortcode-vc-call_to_action',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Optional caption', 'wm_domain' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'caption',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Content text', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Button text', 'wm_domain' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'button_text',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
									40 => array(
										'heading'     => __( 'Button URL', 'wm_domain' ),
										'description' => __( 'Set the button link URL', 'wm_domain' ),
										'type'        => 'textfield',
										'param_name'  => 'button_url',
										'value'       => '',
										'holder'      => 'hidden',
										'class'       => '',
									),
									50 => array(
										'heading'     => __( 'Button link target', 'wm_domain' ),
										'description' => '',
										'type'        => 'dropdown',
										'param_name'  => 'target',
										'value'       => array(
												__( 'Open in same window', 'wm_domain' )      => '',
												__( 'Open in new window / tab', 'wm_domain' ) => '_blank',
											),
										'holder'      => 'hidden',
										'class'       => '',
									),
									60 => array(
										'heading'     => __( 'Button color', 'wm_domain' ),
										'description' => '',
										'type'        => 'dropdown',
										'param_name'  => 'button_color',
										'value'       => array_flip( self::$codes_globals['colors'] ),
										'holder'      => 'hidden',
										'class'       => '',
									),
									70 => array(
										'heading'     => __( 'Button size', 'wm_domain' ),
										'description' => '',
										'type'        => 'dropdown',
										'param_name'  => 'button_size',
										'value'       => array_flip( self::$codes_globals['sizes'] ),
										'holder'      => 'hidden',
										'class'       => '',
									),
									80 => array(
										'heading'     => __( 'Button icon', 'wm_domain' ),
										'description' => __( 'Choose one of available icons', 'wm_domain' ),
										'type'        => 'wm_radio',
										'param_name'  => 'button_icon',
										'value'       => self::$codes_globals['font_icons'],
										'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
										'hide_radio'  => true,
										'inline'      => true,
										'holder'      => 'hidden',
										'class'       => '',
									),
								90 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Columns
		/**
		 * Collumn
		 *
		 * @since    1.0
		 * @version  1.0.9.8
		 */
		'column' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Column', 'wm_domain' ),
						'code'       => ( wma_is_active_vc() ) ? ( '[vc_column width="1/1,1/2,1/3,2/3,1/4,3/4,1/6,5/6" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/vc_column]' ) : ( '[PREFIX_column width="' . implode( ',', self::$codes_globals['column_widths'] ) . '" last="0/1" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/PREFIX_column]' ),
						'vc_enabled' => false,
					),
			),

	//Countdown timer
		/**
		 * Countdown timer
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'countdown_timer' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Countdown timer', 'wm_domain' ),
						'code'       => '[PREFIX_countdown_timer time="' . date( get_option( 'date_format' ), strtotime( 'now' ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" class="" /]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Countdown timer', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'countdown_timer',
						'class'    => 'wm-shortcode-vc-countdown_timer',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Time', 'wm_domain' ),
									'description' => __( 'Set the time for the timer', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'time',
									'value'       => date( get_option( 'date_format' ), strtotime( 'now' ) ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Size', 'wm_domain' ),
									'description' => __( 'Choose predefined size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'size',
									'value'       => array_flip( self::$codes_globals['sizes'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Content Module
		/**
		 * Content Module
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'content_module' => array(
				'since'      => '1.0',
				'post_type_required' => 'wm_modules',
				'preprocess'         => false,
				'style'              => array(),
				'generator'          => array(
						'name'       => __( 'Content Module', 'wm_domain' ),
						'code'       => '[PREFIX_content_module module="module-slug" align="left/right" columns="4" count="-1" order="new/old/name/random" tag="" image_size="" filter="0/1" scroll="0" pagination="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_content_module]',
						'vc_enabled' => false,
					),
				'vc_plugin'          => array(
						'name'     => $this->prefix_shortcode_name . __( 'Content Module', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'content_module',
						'class'    => 'wm-shortcode-vc-content_module',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Single module slug', 'wm_domain' ),
									'description' => __( 'Leave empty to display multiple modules', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'module',
									'value'       => array_flip( $wm_modules_slugs ),
									'holder'      => 'div',
									'class'       => '',
								),

								20 => array(
									'heading'     => __( 'Count', 'wm_domain' ),
									'description' => __( 'Number of items to display (use "-1" to display all)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'count',
									'value'       => 4,
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								30 => array(
									'heading'     => __( 'Columns', 'wm_domain' ),
									'description' => __( 'Number of columns', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'columns',
									'value'       => array(
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
											5 => 5,
											6 => 6,
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								40 => array(
									'heading'     => __( 'Order', 'wm_domain' ),
									'description' => __( 'Choose preferred items ordering', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'order',
									'value'       => array(
											__( 'Newest first', 'wm_domain' ) => 'new',
											__( 'Oldest first', 'wm_domain' ) => 'old',
											__( 'By name', 'wm_domain' )      => 'name',
											__( 'Randomly', 'wm_domain' )     => 'random',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								50 => array(
									'heading'     => __( 'Filter', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'filter',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								60 => array(
									'heading'     => __( 'Scrolling', 'wm_domain' ),
									'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represent the time of scroll in miliseconds. Leave empty not to use the scrolling.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'scroll',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								70 => array(
									'heading'     => __( 'Tag', 'wm_domain' ),
									'description' => __( 'Displays items only from specific tag', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'tag',
									'value'       => array_flip( $wm_modules_tags ),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								80 => array(
									'heading'     => __( 'Display pagination?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'pagination',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								90 => array(
									'heading'     => __( 'Description text (HTML)', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								100 => array(
									'heading'     => __( 'Description text alignment', 'wm_domain' ),
									'description' => __( 'You can control the alignment of the optional description text', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'align',
									'value'       => array(
											__( 'Left', 'wm_domain' )  => 'left',
											__( 'Right', 'wm_domain' ) => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								110 => array(
									'heading'     => __( 'Remove gap between items?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'no_margin',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),

								120 => array(
									'heading'     => __( 'Image size', 'wm_domain' ),
									'description' => __( 'Optional image size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'image_size',
									'value'       => wma_asort( array_merge( array( '' => '' ), array_flip( wma_get_image_sizes() ) ) ),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Layout', 'wm_domain' ),
								),
								130 => array(
									'heading'     => __( 'Custom layout', 'wm_domain' ),
									'description' => sprintf( __( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'wm_domain' ), '<code>content,image,morelink,tag,title</code>' ),
									'type'        => 'textfield',
									'param_name'  => 'layout',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Layout', 'wm_domain' ),
								),

								140 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Divider
		/**
		 * Divider
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'divider' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Divider / Gap', 'wm_domain' ),
						'code' => '[PREFIX_divider type="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['divider_types'] ) ) ) . '" space_before="" space_after="" class="" /]',
						'vc_enabled' => true,
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Divider / Gap', 'wm_domain' ),
						'base'                    => $this->prefix_shortcode . 'divider',
						'class'                   => 'wm-shortcode-vc-divider',
						'show_settings_on_create' => false,
						'category'                => __( 'Content', 'wm_domain' ),
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Divider type', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'type',
									'value'       => array_flip( self::$codes_globals['divider_types'] ),
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Space before divider', 'wm_domain' ),
									'description' => __( 'Insert a number (of pixels)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'space_before',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Space after divider', 'wm_domain' ),
									'description' => __( 'Insert a number (of pixels)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'space_after',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'CSS styles', 'wm_domain' ),
									'description' => __( 'Any custom CSS style inserted into style HTML attribute', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'style',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Dropcap
		/**
		 * Dropcap
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'dropcap' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Dropcap', 'wm_domain' ),
						'code' => '[PREFIX_dropcap color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" shape="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['dropcap_shapes'] ) ) ) . '" class=""]{{content}}[/PREFIX_dropcap]',
						'vc_enabled' => true,
					),
			),

	//Icons
		/**
		 * Icon
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'icon' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Icon (social icon)', 'wm_domain' ),
						'code'       => '[PREFIX_icon class="icon-class" social="' . implode( '/', $wm_social_icons_array ) . '" url="" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" /]',
						'vc_enabled' => true,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Icon (social icon)', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'icon',
						'class'    => 'wm-shortcode-vc-icon',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Icon', 'wm_domain' ),
									'description' => __( 'Choose one of available icons', 'wm_domain' ),
									'type'        => 'wm_radio',
									'param_name'  => 'icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Icon size', 'wm_domain' ),
									'description' => __( 'Choose predefined icon size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'size',
									'value'       => array_flip( self::$codes_globals['sizes'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),

								30 => array(
									'heading'     => __( 'Style this as a social icon?', 'wm_domain' ),
									'description' => __( 'Choose a social icon type', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'social',
									'value'       => $wm_social_icons_array,
									'holder'      => 'div',
									'class'       => '',
									'group'       => __( 'Social icon', 'wm_domain' ),
								),
								40 => array(
									'heading'     => __( 'Social icon URL', 'wm_domain' ),
									'description' => __( 'If set, the icon will be styled as social icon', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'url',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Social icon', 'wm_domain' ),
								),
								50 => array(
									'heading'     => __( 'Social link target', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'target',
									'value'       => array(
											__( 'Open in new window / tab', 'wm_domain' ) => '_blank',
											__( 'Open in same window', 'wm_domain' )      => '',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Social icon', 'wm_domain' ),
								),
								60 => array(
									'heading'     => __( 'Social icon title', 'wm_domain' ),
									'description' => __( 'Will be displayed when mouse hovers the icon', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'title',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Social icon', 'wm_domain' ),
								),
								70 => array(
									'heading'     => __( 'Social icon relation', 'wm_domain' ),
									'description' => __( 'The HTML "rel" attribute', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'rel',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Social icon', 'wm_domain' ),
								),

								80 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								90 => array(
									'heading'     => __( 'CSS styles', 'wm_domain' ),
									'description' => __( 'Any custom CSS style inserted into style HTML attribute', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'style',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Icon list
		/**
		 * Icon list
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'list' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'List (icon bullets)', 'wm_domain' ),
						'code'       => '[PREFIX_list bullet="icon-class" class=""]<ul><li>{{content}}</li><li>' . __( 'List item', 'wm_domain' ) . '</li></ul>[/PREFIX_list]',
						'vc_enabled' => true,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'List (icon bullets)', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'list',
						'class'    => 'wm-shortcode-vc-list',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'List items (insert unordered list only)', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => __( '<ul><li>List item</li><li>Another list item</li></ul>', 'wm_domain' ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Bullet icon', 'wm_domain' ),
									'description' => __( 'Choose one of available icons', 'wm_domain' ),
									'type'        => 'wm_radio',
									'param_name'  => 'bullet',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'div',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Last update time
		/**
		 * Last update time
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'last_update' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Last update time', 'wm_domain' ),
						'code' => '[PREFIX_last_update post_type="' . implode( '/', array_merge( array( 'post', 'page' ), get_post_types( array( '_builtin' => false ) ) ) ) . '" format="" class="" /]',
						'vc_enabled' => true,
					),
			),

	//Marker
		/**
		 * Marker
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'marker' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Marker', 'wm_domain' ),
						'code' => '[PREFIX_marker color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" class=""]{{content}}[/PREFIX_marker]',
						'vc_enabled' => true,
					),
			),

	//Messages
		/**
		 * Message box
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		'message' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Message box', 'wm_domain' ),
						'code' => '[PREFIX_message title="" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_message]',
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Message box', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'message',
						'class'    => 'wm-shortcode-vc-message',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Title', 'wm_domain' ),
									'description' => __( 'Enter optional box title', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'title',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Content', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Color', 'wm_domain' ),
									'description' => __( 'Choose predefined button color', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'color',
									'value'       => array_flip( self::$codes_globals['colors'] ),
									'holder'      => 'div',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'Box size', 'wm_domain' ),
									'description' => __( 'Choose preferred box size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'size',
									'value'       => array_flip( self::$codes_globals['sizes'] ),
									'holder'      => 'div',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'Optional icon', 'wm_domain' ),
									'description' => __( 'Choose one of available icons', 'wm_domain' ),
									'type'        => 'wm_radio',
									'param_name'  => 'icon',
									'value'       => self::$codes_globals['font_icons'],
									'custom'      => '<i class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></i>',
									'hide_radio'  => true,
									'inline'      => true,
									'holder'      => 'hidden',
									'class'       => '',
								),
								60 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Meta fields
		/**
		 * Meta
		 *
		 * @since  1.0.9
		 */
		'meta' => array(
				'since'      => '1.0.9',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(),
			),

	//Posts / custom posts
		/**
		 * Posts
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'posts' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Posts (custom posts)', 'wm_domain' ),
						'code'       => '[PREFIX_posts post_type="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['post_types'] ) ) ) . '" align="left/right" columns="4" count="-1" image_size="" order="new/old/name/random" taxonomy="taxonomy_name:taxonomy_slug" filter="taxonomy_name" scroll="0" pagination="0/1" related="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_posts]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Posts (custom posts)', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'posts',
						'class'    => 'wm-shortcode-vc-posts',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Choose the post type', 'wm_domain' ),
									'description' => __( 'This shortcode can display several post types. Choose the one you want to display.', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'post_type',
									'value'       => array_flip( self::$codes_globals['post_types'] ),
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Count', 'wm_domain' ),
									'description' => __( 'Number of items to display (use "-1" to display all)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'count',
									'value'       => 4,
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Columns', 'wm_domain' ),
									'description' => __( 'Number of columns', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'columns',
									'value'       => array(
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
											5 => 5,
											6 => 6,
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'Order', 'wm_domain' ),
									'description' => __( 'Choose preferred items ordering', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'order',
									'value'       => array(
											__( 'Newest first', 'wm_domain' ) => 'new',
											__( 'Oldest first', 'wm_domain' ) => 'old',
											__( 'By name', 'wm_domain' )      => 'name',
											__( 'Randomly', 'wm_domain' )     => 'random',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),

								50 => array(
									'heading'     => __( 'Taxonomy', 'wm_domain' ),
									'description' => __( 'Displays items only from specific taxonomy. Set the taxonomy name and taxonomy slug separated with colon.', 'wm_domain' ) . '<br />' . __( 'For example: "category:category-slug".', 'wm_domain' ) . '<br />' . __( 'Available taxonomy names:', 'wm_domain' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
									'type'        => 'textfield',
									'param_name'  => 'taxonomy',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Taxonomy', 'wm_domain' ),
								),
								60 => array(
									'heading'     => __( 'Related', 'wm_domain' ),
									'description' => __( 'Use only on single post/custom post pages. Displays items related to recently displayed item through the specific taxonomy. Set the taxonomy name only.', 'wm_domain' ) . ' ' . __( 'For example: "category".', 'wm_domain' ) . '<br />' . __( 'Available taxonomy names:', 'wm_domain' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
									'type'        => 'textfield',
									'param_name'  => 'related',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Taxonomy', 'wm_domain' ),
								),

								70 => array(
									'heading'     => __( 'Filter', 'wm_domain' ),
									'description' => __( 'If set, the items will be filtered. Set the taxonomy name (and optional parent taxonomy slug separated with colon - filter will be created from sub-taxonomies) which will be used to filter the items.', 'wm_domain' ) . '<br />' . __( 'For example: "category" or "category:parent-category-slug".', 'wm_domain' ) . '<br />' . __( 'Available taxonomy names:', 'wm_domain' ) . ' <code>' . implode( '</code>, <code>', $wm_taxonomies ) . '</code>',
									'type'        => 'textfield',
									'param_name'  => 'filter',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Filter / Scroll', 'wm_domain' ),
								),
								80 => array(
									'heading'     => __( 'Filter layout', 'wm_domain' ),
									'description' => sprintf( __( 'Use one of <a%s>Isotope</a> layouts.', 'wm_domain' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . __( 'Default is set to <code>fitRows</code>.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'filter_layout',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Filter / Scroll', 'wm_domain' ),
								),
								90 => array(
									'heading'     => __( 'Scrolling', 'wm_domain' ),
									'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represent the time of scroll in miliseconds. Leave empty not to use the scrolling.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'scroll',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Filter / Scroll', 'wm_domain' ),
								),

								100 => array(
									'heading'     => __( 'Display pagination?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'pagination',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),

								110 => array(
									'heading'     => __( 'Description text', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Description', 'wm_domain' ),
								),
								120 => array(
									'heading'     => __( 'Description text alignment', 'wm_domain' ),
									'description' => __( 'You can control the alignment of the optional description text', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'align',
									'value'       => array(
											__( 'Left', 'wm_domain' )  => 'left',
											__( 'Right', 'wm_domain' ) => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Description', 'wm_domain' ),
								),

								130 => array(
									'heading'     => __( 'Remove gap between items?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'no_margin',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Layout', 'wm_domain' ),
								),
								140 => array(
									'heading'     => __( 'Image size', 'wm_domain' ),
									'description' => __( 'Optional image size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'image_size',
									'value'       => wma_asort( array_merge( array( '' => '' ), array_flip( wma_get_image_sizes() ) ) ),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Layout', 'wm_domain' ),
								),

								150 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Pre
		/**
		 * Pre
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'pre' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Preformatted text', 'wm_domain' ),
						'code' => '[PREFIX_pre]{{content}}[/PREFIX_pre]',
						'vc_enabled' => true,
					),
			),

	//Pricing table
		/**
		 * Pricing table
		 *
		 * @since    1.0
		 * @version  1.0.9.10
		 */
		'pricing_table' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Pricing table', 'wm_domain' ),
						'code'       => '[PREFIX_pricing_table no_margin="0/1" class=""]<br />[PREFIX_price caption="' . __( 'Price 1', 'wm_domain' ) . '" color="" color_text="" cost="" heading_tag="" type="NONE/featured/legend" class=""]{{content}}[/PREFIX_price]<br />[PREFIX_price caption="' . __( 'Price 2', 'wm_domain' ) . '" color="" color_text="" cost="" heading_tag="" type="NONE/featured/legend" class=""]' . __( 'Price 2 content goes here', 'wm_domain' ) . '[/PREFIX_price]<br />[/PREFIX_pricing_table]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'                    => $this->prefix_shortcode_name . __( 'Pricing table', 'wm_domain' ),
						'base'                    => $this->prefix_shortcode . 'pricing_table',
						'class'                   => 'wm-shortcode-vc-pricing_table wm-sections-mode',
						'show_settings_on_create' => false,
						'is_container'            => true,
						'category'                => __( 'Content', 'wm_domain' ),
						'custom_markup'           => '
								<h4 class="wm-sections-mode-title">' . __( 'Pricing table', 'wm_domain' ) . '</h4>
								<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
									%content%
								</div>
								<div class="tab_controls">
									<button data-item="' . $this->prefix_shortcode . 'price" data-item-title="' . __( 'Price', 'wm_domain' ) . '" class="add_tab" title="' . __( 'Pricing table: Add new price', 'wm_domain' ) . '">' . __( 'Pricing table: Add new price', 'wm_domain' ) . '</button>
								</div>
							',
						'default_content'         => '
								[' . $this->prefix_shortcode . 'price caption="' . __( 'Price 1', 'wm_domain' ).'"]' . __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'wm_domain' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'wm_domain' ) .'[/' . $this->prefix_shortcode . 'button][/' . $this->prefix_shortcode . 'price]
								[' . $this->prefix_shortcode . 'price caption="' . __( 'Price 2', 'wm_domain' ).'"]' . __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'wm_domain' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'wm_domain' ) .'[/' . $this->prefix_shortcode . 'button][/' . $this->prefix_shortcode . 'price]
							',
						'js_view'                 => 'VcCustomPricingTableView',
						'params'                  => array(
								10 => array(
									'heading'     => __( 'Remove margins between price columns?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'no_margin',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
		 * @since    1.0
		 * @version  1.0.9
		 */
		'price' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Price (pricing table item)', 'wm_domain' ),
						'code'       => '[PREFIX_price caption="' . __( 'Title', 'wm_domain' ) . '" cost="99$" color="" color_text="" type="default/featured/legend" class=""]{{content}}[/PREFIX_price]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'            => $this->prefix_shortcode_name . __( 'Price', 'wm_domain' ),
						'base'            => $this->prefix_shortcode . 'price',
						'class'           => 'wm-shortcode-vc-price',
						'content_element' => false,
						'category'        => __( 'Content', 'wm_domain' ),
						'params'          => array(
								array(
									'heading'     => __( 'Price caption', 'wm_domain' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'caption',
									'value'       => '',
									'holder'      => 'div',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Price cost', 'wm_domain' ),
									'description' => __( 'You can use HTML and shortcodes here', 'wm_domain' ),
									'type'        => 'textarea',
									'param_name'  => 'cost',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Features list', 'wm_domain' ),
									'description' => __( 'Insert an unordered list of features', 'wm_domain' ),
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => __( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'wm_domain' ) . '[' . $this->prefix_shortcode . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['sizes'] ) ) ) . '" icon="" class=""]' . __( 'Button text', 'wm_domain' ) .'[/' . $this->prefix_shortcode . 'button]',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Price column color', 'wm_domain' ),
									'description' => '',
									'type'        => 'colorpicker',
									'param_name'  => 'color',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Optional price column text color', 'wm_domain' ),
									'description' => __( 'If not set, it will be calculated upon price column color', 'wm_domain' ),
									'type'        => 'colorpicker',
									'param_name'  => 'color_text',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'Styling', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'type',
									'value'       => array(
											__( 'Default price column', 'wm_domain' )  => '',
											__( 'Featured price column', 'wm_domain' ) => 'featured',
											__( 'Pricing table legend', 'wm_domain' )  => 'legend',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Progress bar
		/**
		 * Progress bar
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'progress' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Progress bar', 'wm_domain' ),
						'code'       => '[PREFIX_progress color="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['colors'] ) ) ) . '" progress="75" class=""]{{content}}[/PREFIX_progress]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Progress bar', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'progress',
						'class'    => 'wm-shortcode-vc-progress',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Caption', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => __( 'Progress bar caption', 'wm_domain' ),
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Progress in %', 'wm_domain' ),
									'description' => __( 'Insert number between 0 and 100', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'progress',
									'value'       => '75',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Color', 'wm_domain' ),
									'description' => __( 'Choose predefined color', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'color',
									'value'       => array_flip( self::$codes_globals['colors'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Row
		/**
		 * Row
		 *
		 * @since    1.0
		 * @version  1.0.9.8
		 */
		'row' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Row', 'wm_domain' ),
						'code' => ( wma_is_active_vc() ) ? ( '[vc_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/vc_row]' ) : ( '[PREFIX_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/PREFIX_row]' ),
						'vc_enabled' => false,
					),
			),

	//Search form
		/**
		 * Search form
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'search_form' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Search form', 'wm_domain' ),
						'code'       => '[PREFIX_search_form /]',
						'vc_enabled' => true,
					),
			),

	//Separator heading
		/**
		 * Separator heading
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'separator_heading' => array(
				'since'      => '1.0',
				'preprocess' => true,
				'style'      => array(),
				'generator'  => array(
						'name' => __( 'Separator heading', 'wm_domain' ),
						'code' => '[PREFIX_separator_heading align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '" tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '" class="" id=""]{{content}}[/PREFIX_separator_heading]',
						'vc_enabled' => true,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Separator heading', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'separator_heading',
						'class'    => 'wm-shortcode-vc-separator_heading',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Heading text', 'wm_domain' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'HTML tag (heading size)', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'tag',
									'value'       => array(
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
									'heading'     => __( 'Text align', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'align',
									'value'       => array(
											__( 'Left', 'wm_domain' )   => 'left',
											__( 'Center', 'wm_domain' ) => 'center',
											__( 'Right', 'wm_domain' )  => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'HTML ID', 'wm_domain' ),
									'description' => __( 'Optional HTML ID', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'id',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Slideshow
		/**
		 * Slideshow
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'slideshow' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Slideshow', 'wm_domain' ),
						'code'       => '[PREFIX_slideshow ids="" nav="none/thumbs/pagination" size="full/' . implode( '/', get_intermediate_image_sizes() ) . '" speed="3000" class="" /]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Slideshow', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'slideshow',
						'class'    => 'wm-shortcode-vc-slideshow',
						'category' => __( 'Media', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Images', 'wm_domain' ),
									'description' => '',
									'type'        => 'attach_images',
									'param_name'  => 'ids',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Navigation', 'wm_domain' ),
									'description' => __( 'Next/Prev buttons are always visible, use CSS to hide them if not needed.', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'nav',
									'value'       => array(
											__( 'Just Next/Prev button', 'wm_domain' ) => '',
											__( 'Thumbnails', 'wm_domain' )            => 'thumbs',
											__( 'Pagination', 'wm_domain' )            => 'pagination',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Image size', 'wm_domain' ),
									'description' => __( 'Slideshow images size', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'image_size',
									'value'       => wma_asort( array_merge( array( '' => '' ), array_flip( wma_get_image_sizes() ) ) ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'Speed in miliseconds', 'wm_domain' ),
									'description' => '',
									'type'        => 'textfield',
									'param_name'  => 'speed',
									'value'       => apply_filters( WM_SHORTCODES_HOOK_PREFIX . 'slideshow_speed', 3000 ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Table
		/**
		 * Table (CSV data)
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'table' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Table (CSV data)', 'wm_domain' ),
						'code'       => '[PREFIX_table type="' . implode( '/', array_keys( wma_ksort( self::$codes_globals['table_types'] ) ) ) . '" separator="," class=""]{{content}}[/PREFIX_table]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Table (CSV data)', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'table',
						'class'    => 'wm-shortcode-vc-table',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Table data', 'wm_domain' ),
									'description' => __( 'Please insert the contents of your CSV file here', 'wm_domain' ),
									'type'        => 'textarea_html',
									'param_name'  => 'content',
									'value'       => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'CSV data separator', 'wm_domain' ),
									'description' => __( 'Set the separator used in the above CSV data', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'separator',
									'value'       => ',',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Table type (styling)', 'wm_domain' ),
									'description' => __( 'Choose predefined table styling', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'type',
									'value'       => array_flip( self::$codes_globals['table_types'] ),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Testimonials
		/**
		 * Testimonials
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'testimonials' => array(
				'since'              => '1.0',
				'post_type_required' => 'wm_testimonials',
				'preprocess'         => false,
				'style'              => array(),
				'generator'          => array(
						'name'       => __( 'Testimonial', 'wm_domain' ),
						'code'       => '[PREFIX_testimonials testimonial="testimonial-slug" align="left/right" columns="4" count="-1" order="new/old/name/random" category="optional-category-slug" scroll="0" pagination="0/1" no_margin="0/1" class=""]{{content}}[/PREFIX_testimonials]',
						'vc_enabled' => false,
					),
				'vc_plugin'          => array(
						'name'     => $this->prefix_shortcode_name . __( 'Testimonial', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'testimonials',
						'class'    => 'wm-shortcode-vc-testimonials',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Single testimonial slug', 'wm_domain' ),
									'description' => __( 'Leave empty to display multiple testimonials', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'testimonial',
									'value'       => array_flip( $wm_testimonials_slugs ),
									'holder'      => 'div',
									'class'       => '',
								),

								20 => array(
									'heading'     => __( 'Count', 'wm_domain' ),
									'description' => __( 'Number of items to display (use "-1" to display all)', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'count',
									'value'       => 4,
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								30 => array(
									'heading'     => __( 'Columns', 'wm_domain' ),
									'description' => __( 'Number of columns', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'columns',
									'value'       => array(
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
											5 => 5,
											6 => 6,
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								40 => array(
									'heading'     => __( 'Order', 'wm_domain' ),
									'description' => __( 'Choose preferred items ordering', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'order',
									'value'       => array(
											__( 'Newest first', 'wm_domain' ) => 'new',
											__( 'Oldest first', 'wm_domain' ) => 'old',
											__( 'By name', 'wm_domain' )      => 'name',
											__( 'Randomly', 'wm_domain' )     => 'random',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								50 => array(
									'heading'     => __( 'Scrolling', 'wm_domain' ),
									'description' => __( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represent the time of scroll in miliseconds. Leave empty not to use the scrolling.', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'scroll',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								60 => array(
									'heading'     => __( 'Category', 'wm_domain' ),
									'description' => __( 'Displays items only from specific category', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'category',
									'value'       => array_flip( $wm_testimonials_categories ),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								70 => array(
									'heading'     => __( 'Display pagination?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'pagination',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								80 => array(
									'heading'     => __( 'Description text (HTML)', 'wm_domain' ),
									'description' => '',
									'type'        => 'textarea',
									'param_name'  => 'content',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								90 => array(
									'heading'     => __( 'Description text alignment', 'wm_domain' ),
									'description' => __( 'You can control the alignment of the optional description text', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'align',
									'value'       => array(
											__( 'Left', 'wm_domain' )  => 'left',
											__( 'Right', 'wm_domain' ) => 'right',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),
								100 => array(
									'heading'     => __( 'Remove gap between items?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'no_margin',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => '1',
										),
									'holder'      => 'hidden',
									'class'       => '',
									'group'       => __( 'Multiple display', 'wm_domain' ),
								),

								110 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Video
		/**
		 * Video
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'video' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Video', 'wm_domain' ),
						'code'       => '[PREFIX_video src="" poster="" autoplay="0/1" loop="0/1" class="" /]',
						'vc_enabled' => false,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Video', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'video',
						'class'    => 'wm-shortcode-vc-video',
						'category' => __( 'Media', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Video source', 'wm_domain' ),
									'description' => __( 'Set the video URL', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'src',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Poster', 'wm_domain' ),
									'description' => __( 'Optional placeholder image', 'wm_domain' ),
									'type'        => 'attach_image',
									'param_name'  => 'poster',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'Autoplay the video?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'autoplay',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => 'on',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								40 => array(
									'heading'     => __( 'Loop the video?', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'loop',
									'value'       => array(
											__( 'No', 'wm_domain' )  => '',
											__( 'Yes', 'wm_domain' ) => 'on',
										),
									'holder'      => 'hidden',
									'class'       => '',
								),
								50 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
									'type'        => 'textfield',
									'param_name'  => 'class',
									'value'       => '',
									'holder'      => 'hidden',
									'class'       => '',
								),
							)
					),
			),

	//Widget area
		/**
		 * Widget area
		 *
		 * @since    1.0
		 * @version  1.0.9
		 */
		'widget_area' => array(
				'since'      => '1.0',
				'preprocess' => false,
				'style'      => array(),
				'generator'  => array(
						'name'       => __( 'Widget area', 'wm_domain' ),
						'code'       => '[PREFIX_widget_area area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '" class="" max_widgets_count="0" /]',
						'vc_enabled' => true,
					),
				'vc_plugin'  => array(
						'name'     => $this->prefix_shortcode_name . __( 'Widget area', 'wm_domain' ),
						'base'     => $this->prefix_shortcode . 'widget_area',
						'class'    => 'wm-shortcode-vc-widget_area',
						'category' => __( 'Content', 'wm_domain' ),
						'params'   => array(
								10 => array(
									'heading'     => __( 'Select widget area', 'wm_domain' ),
									'description' => '',
									'type'        => 'dropdown',
									'param_name'  => 'area',
									'value'       => array_flip( wma_widget_areas_array() ),
									'holder'      => 'div',
									'class'       => '',
								),
								20 => array(
									'heading'     => __( 'Maximum count of widgets in area', 'wm_domain' ),
									'description' => __( 'Area will not be displayed when the number of widgets inserted in it is greater', 'wm_domain' ),
									'type'        => 'dropdown',
									'param_name'  => 'max_widgets_count',
									'value'       => array(
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
									'holder'      => 'hidden',
									'class'       => '',
								),
								30 => array(
									'heading'     => __( 'CSS class', 'wm_domain' ),
									'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
	 * @since    1.0
	 * @version  1.0.9
	 */
	$shortcode_definitions['vc_row'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'                    => __( 'Row / Section', 'wm_domain' ),
				'base'                    => 'vc_row',
				'class'                   => 'wm-shortcode-vc-row',
				'category'                => __( 'Structure', 'wm_domain' ),
				'is_container'            => true,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
						10 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'HTML ID', 'wm_domain' ),
							'description' => __( 'Optional ID attribute applied on the HTML container. Can be used as location anchor.', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'id',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'wm_domain' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						60 => array(
							'heading'     => __( 'Parallax scroll speed', 'wm_domain' ),
							'description' => __( 'Set the inertia of parallax background moving. For example, value of <code>0.1</code> equals 10% of normal scroll speed.', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'parallax',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'dependency'  => array(
									'element'   => 'bg_image',
									'not_empty' => true
								),
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						70 => array(
							'heading'     => __( 'Padding', 'wm_domain' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'wm_domain' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						80 => array(
							'heading'     => __( 'Margin', 'wm_domain' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'wm_domain' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'margin',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
					)
			)
		);



	/**
	 * Redefine the vc_row_inner shortcode
	 *
	 * @since    1.0
	 * @version  1.0.9
	 */
	$shortcode_definitions['vc_row_inner'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'                    => __( 'Row', 'wm_domain' ),
				'base'                    => 'vc_row_inner',
				'class'                   => 'wm-shortcode-vc-row-inner',
				'category'                => __( 'Structure', 'wm_domain' ),
				'content_element'         => false,
				'is_container'            => true,
				'weight'                  => 1000,
				'show_settings_on_create' => false,
				'js_view'                 => 'VcRowView',
				'params'                  => array(
						10 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
	 * @since    1.0
	 * @version  1.0.9
	 */
	$shortcode_definitions['vc_column'] = array(
			'since'     => '1.0',
			'vc_plugin' => array(
				'name'            => __( 'Column', 'wm_domain' ),
				'base'            => 'vc_column',
				'class'           => 'wm-shortcode-vc-column',
				'category'        => __( 'Structure', 'wm_domain' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
						10 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'HTML ID', 'wm_domain' ),
							'description' => __( 'Optional ID attribute applied on the HTML container. Can be used as location anchor.', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'id',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'wm_domain' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						60 => array(
							'heading'     => __( 'Padding', 'wm_domain' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'wm_domain' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
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
				'name'            => __( 'Column', 'wm_domain' ),
				'base'            => 'vc_column_inner',
				'class'           => 'wm-shortcode-vc-inner-column',
				'category'        => __( 'Structure', 'wm_domain' ),
				'content_element' => false,
				'is_container'    => true,
				'js_view'         => 'VcColumnView',
				'params'          => array(
						10 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'HTML ID', 'wm_domain' ),
							'description' => __( 'Optional ID attribute applied on the HTML container. Can be used as location anchor.', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'id',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),

						30 => array(
							'heading'     => __( 'Background color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'bg_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						40 => array(
							'heading'     => __( 'Text color', 'wm_domain' ),
							'description' => '',
							'type'        => 'colorpicker',
							'param_name'  => 'font_color',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						50 => array(
							'heading'     => __( 'Background image', 'wm_domain' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'bg_image',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						60 => array(
							'heading'     => __( 'Padding', 'wm_domain' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'wm_domain' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'padding',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
					)
			)
		);



	/**
	 * Text block
	 *
	 * @since    1.0
	 * @version  1.0.9
	 */
	$shortcode_definitions['text_block'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $this->prefix_shortcode_name . __( 'Text block', 'wm_domain' ),
				'base'     => $this->prefix_shortcode . 'text_block',
				'class'    => 'wm-shortcode-vc-text_block',
				'category' => __( 'Content', 'wm_domain' ),
				'params'   => array(
						10 => array(
							'heading'     => __( 'Content', 'wm_domain' ),
							'description' => '',
							'type'        => 'textarea_html',
							'param_name'  => 'content',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
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
	 * @since    1.0
	 * @version  1.0.9
	 */
	$shortcode_definitions['image'] = array(
			'since'      => '1.0',
			'vc_plugin'  => array(
				'name'     => $this->prefix_shortcode_name . __( 'Image', 'wm_domain' ),
				'base'     => $this->prefix_shortcode . 'image',
				'class'    => 'wm-shortcode-vc-image',
				'category' => __( 'Media', 'wm_domain' ),
				'params'   => array(
						10 => array(
							'heading'     => __( 'Image to display', 'wm_domain' ),
							'description' => '',
							'type'        => 'attach_image',
							'param_name'  => 'src',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						20 => array(
							'heading'     => __( 'Image link URL', 'wm_domain' ),
							'description' => __( 'Set the optional image link URL', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'link',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),
						30 => array(
							'heading'     => __( 'Image link target', 'wm_domain' ),
							'description' => '',
							'type'        => 'dropdown',
							'param_name'  => 'target',
							'value'       => array(
									__( 'Open in same window', 'wm_domain' )      => '',
									__( 'Open in new window / tab', 'wm_domain' ) => '_blank',
								),
							'holder'      => 'hidden',
							'class'       => '',
							'dependency'  => array(
									'element'   => 'link',
									'not_empty' => true
								),
						),
						40 => array(
							'heading'     => __( 'CSS class', 'wm_domain' ),
							'description' => __( 'Optional CSS additional classes', 'wm_domain' ),
							'type'        => 'textfield',
							'param_name'  => 'class',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
						),

						50 => array(
							'heading'     => __( 'Image width HTML attribute', 'wm_domain' ),
							'description' => '',
							'type'        => 'textfield',
							'param_name'  => 'width',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						60 => array(
							'heading'     => __( 'Image height HTML attribute', 'wm_domain' ),
							'description' => '',
							'type'        => 'textfield',
							'param_name'  => 'height',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
						70 => array(
							'heading'     => __( 'Margin', 'wm_domain' ),
							'description' => sprintf( __( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'wm_domain' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
							'type'        => 'textfield',
							'param_name'  => 'margin',
							'value'       => '',
							'holder'      => 'hidden',
							'class'       => '',
							'group'       => __( 'Styling', 'wm_domain' ),
						),
					)
			)
		);



	/**
	 * Soliloquy
	 *
	 * @since    1.0
	 * @version  1.0.9
	 */
	if ( post_type_exists( 'soliloquy' ) ) {
		$shortcode_definitions['soliloquy'] = array(
				'since'      => '1.0',
				'vc_plugin'  => array(
					'name'     => __( 'Soliloquy Slider', 'wm_domain' ),
					'base'     => 'soliloquy',
					'class'    => 'wm-shortcode-vc-soliloquy',
					'category' => __( 'Media', 'wm_domain' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Choose a Soliloquy slider', 'wm_domain' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'id',
								'value'       => array_flip( wma_posts_array( 'post_name', 'soliloquy' ) ),
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
					'name'     => __( 'Master Slider', 'wm_domain' ),
					'base'     => 'masterslider',
					'class'    => 'wm-shortcode-vc-masterslider',
					'category' => __( 'Media', 'wm_domain' ),
					'params'   => array(
							10 => array(
								'heading'     => __( 'Choose a slider', 'wm_domain' ),
								'description' => '',
								'type'        => 'dropdown',
								'param_name'  => 'id',
								'value'       => get_masterslider_names( false ),
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
	 * @since    1.0
	 * @version  1.0.9
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

?>