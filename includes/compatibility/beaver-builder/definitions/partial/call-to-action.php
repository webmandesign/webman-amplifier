<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [call_to_action]
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
	'button_color',
	'button_icon',
	'button_size',
	'button_text',
	'button_url',
	'caption',
	'class',
	'content',
	'heading_tag',
	'target',
);

$definitions['call_to_action']['bb_plugin'] = array(
	'name'   => esc_html__( 'Call to Action', 'webman-amplifier' ),
	'output' => '[PREFIX_call_to_action{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_call_to_action]',
	'params' => $params,
	'form'   => array(

		// Tab
		'general' => array(
			'title'       => esc_html__( 'General', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'caption' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Caption', 'webman-amplifier' ),
							'default' => '',
							'preview' => array( 'type' => 'none' ),
						),

						'heading_tag' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Caption HTML tag', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
							'options'     => $helpers['heading_tags'],
							'preview'     => array( 'type' => 'none' ),
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

		// Tab
		'button' => array(
			'title'       => esc_html__( 'Button', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'button_text' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Button text', 'webman-amplifier' ),
							'default' => '',
							'preview' => array( 'type' => 'none' ),
						),

						'button_url' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Button link URL', 'webman-amplifier' ),
							'default' => '',
							'preview' => array( 'type' => 'none' ),
						),

						'target' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Target', 'webman-amplifier' ),
							'help'    => esc_html__( 'Button link target', 'webman-amplifier' ),
							'options' => array(
								''       => esc_html__( 'Open in same window', 'webman-amplifier' ),
								'_blank' => esc_html__( 'Open in new window / tab', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'none' ),
						),

						'button_color' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Button color', 'webman-amplifier' ),
							'options' => $helpers['colors'],
							'preview' => array( 'type' => 'none' ),
						),

						'button_size' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Button size', 'webman-amplifier' ),
							'options' => $helpers['sizes']['options'],
							'preview' => array( 'type' => 'none' ),
						),

					),
				),

				'icon' => array(
					'title'  => esc_html__( 'Button icon', 'webman-amplifier' ),
					'fields' => array(

						'button_icon' => array(
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

			),
		),

	),
	'compatibility/wpml' => array(
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
);
