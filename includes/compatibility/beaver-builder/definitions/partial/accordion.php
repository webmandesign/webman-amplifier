<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [accordion]
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
	'filter',
	'mode',
);
$params_children = array(
	'content',
	'heading_tag',
	'icon',
	'tags',
	'title',
);

$definitions['accordion']['bb_plugin'] = array(
	'name'            => esc_html__( 'Accordion', 'webman-amplifier' ),
	'output'          => '[PREFIX_accordion{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{children}}[/PREFIX_accordion]',
	'output_children' => '[PREFIX_item{{' . implode( '}}{{', array_diff( $params_children, array( 'content' ) ) ) . '}}[/PREFIX_item]',
	'params'          => $params,
	'params_children' => $params_children,
	'form'            => array(

		// Tab
		'general' => array(
			'title'       => esc_html__( 'General', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'mode' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Mode', 'webman-amplifier' ),
							'options' => array(
								'accordion' => esc_html__( 'Accordion (only one section open)', 'webman-amplifier' ),
								'toggle'    => esc_html__( 'Toggle (multiple sections open)', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'none' ),
						),

					),
				),

				'sections' => array(
					'title'  => esc_html__( 'Sections', 'webman-amplifier' ),
					'fields' => array(

						'children' => array(
							'type'        => 'form',
							'label'       => '',
							'description' => '',
							'help'        => '',
							'default'     => array(
								// This will be converted automatically
								'title' => esc_html__( 'Section', 'webman-amplifier' ),
							),
							'form'         => 'wm_children_form_' . 'accordion',
							'preview_text' => 'title',
							'multiple'     => true,
							'preview'      => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

		// Tab
		'others' => array(
			'title'       => esc_html__( 'Others', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'filter' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Filtering', 'webman-amplifier' ),
							'help'    => esc_html__( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'none' ),
						),

						'active' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Active section number', 'webman-amplifier' ),
							'default' => 1,
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
							'preview' => array( 'type' => 'none' ),
						),

					),
				),

			),
		),

	),
	'form_children'   => array(

		'title' => esc_html__( 'Section', 'webman-amplifier' ),

		'tabs' => array(

			'general' => array(
				'title'       => esc_html__( 'General', 'webman-amplifier' ),
				'description' => '',
				'sections'    => array(

					'title' => array(
						'title'  => '',
						'fields' => array(

							'title' => array(
								'type'    => 'text',
								'label'   => esc_html__( 'Title', 'webman-amplifier' ),
								'default' => esc_html__( 'Section', 'webman-amplifier' ),
								'preview' => array( 'type' => 'none' ),
							),

						),
					),

					'content' => array(
						'title'  => esc_html__( 'Content', 'webman-amplifier' ),
						'fields' => array(

							'content' => array(
								'type'    => 'editor',
								'label'   => '',
								'preview' => array( 'type' => 'none' ),
							),

						),
					),

				),
			),

			'others' => array(
				'title'       => esc_html__( 'Others', 'webman-amplifier' ),
				'description' => '',
				'sections'    => array(

					'icon' => array(
						'title'  => esc_html__( 'Icon', 'webman-amplifier' ),
						'fields' => array(

							'icon' => array(
								'type'       => 'wm_radio',
								'label'      => '',
								'options'    => $helpers['font_icons'],
								'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
								'filter'     => true,
								'hide_radio' => true,
								'inline'     => true,
								'preview'    => array( 'type' => 'none' ),
							),

						),
					),

					'other' => array(
						'title'  => esc_html__( 'Other parameters', 'webman-amplifier' ),
						'fields' => array(

							'tags' => array(
								'type'    => 'text',
								'label'   => esc_html__( 'Tags', 'webman-amplifier' ),
								'help'    => esc_html__( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
								'preview' => array( 'type' => 'none' ),
							),

							'heading_tag' => array(
								'type'        => 'select',
								'label'       => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
								'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
								'options'     => $helpers['heading_tags'],
								'preview'     => array( 'type' => 'none' ),
							),

						),
					),

				),
			),

		),

	),
	'compatibility/wpml' => array(
		/**
		 * @see  WM_Amplifier_WPML_Beaver_Builder_Children()
		 */
	),
);
