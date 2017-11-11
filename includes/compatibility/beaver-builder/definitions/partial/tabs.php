<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [tabs]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$params = array(
	'active',
	'class',
	'layout',
	'tour',
);
$params_children = array(
	'content',
	'heading_tag',
	'icon',
	'title',
);

$definitions['tabs']['bb_plugin'] = array(
	'name'            => esc_html__( 'Tabs', 'webman-amplifier' ),
	'output'          => '[PREFIX_tabs{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{children}}[/PREFIX_tabs]',
	'output_children' => '[PREFIX_item{{' . implode( '}}{{', array_diff( $params_children, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_item]',
	'params'          => $params,
	'params_children' => $params_children,
	'form'            => array(

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
	'compatibility/wpml' => array(
		/**
		 * @see  WM_Amplifier_WPML_Beaver_Builder_Children()
		 */
	),
);
