<?php
/**
 * Shortcode definitions array partial: [tabs]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['tabs'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Tabs', 'webman-amplifier' ),
		'code'  => '[PREFIX_tabs active="0" layout="top/left/right" tour="0/1" class=""]<br />[PREFIX_item title="' . esc_html__( 'Tab 1', 'webman-amplifier' ) . '" icon="" heading_tag=""]{{content}}[/PREFIX_item]<br />[PREFIX_item title="' . esc_html__( 'Tab 2', 'webman-amplifier' ) . '" icon="" heading_tag=""][/PREFIX_item]<br />[/PREFIX_tabs]',
		'short' => false,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Tabs', 'webman-amplifier' ),
		'output' => '[PREFIX_tabs{{layout}}{{tour}}{{active}}{{class}}]{{children}}[/PREFIX_tabs]',
		'output_children' => '[PREFIX_item{{title}}{{icon}}{{heading_tag}}]{{content}}[/PREFIX_item]',
		'params' => array( 'layout', 'tour', 'active', 'class' ),
		'params_children' => array( 'title', 'content', 'icon', 'heading_tag' ),
		'wpml_fields' => array(
			/**
			 * @see  WM_Amplifier_WPML_Beaver_Builder_Children()
			 */
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
								'type'         => 'form',
								'label'        => esc_html__( 'Section', 'webman-amplifier' ),
								'form'         => 'wm_children_form_tabs',
								'preview_text' => 'title', //DO NOT FORGET TO SET!
								'multiple'     => true,
								'preview'      => array( 'type' => 'refresh' ),
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
									'options'    => $helpers['font_icons'],
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
									/* translators: %s: HTML tag. */
									'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
									//type specific
									'options' => $helpers['heading_tags'],
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
);
