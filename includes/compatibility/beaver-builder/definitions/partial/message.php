<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [message]
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
	'class',
	'color',
	'content',
	'heading_tag',
	'icon',
	'size',
	'title',
);

$definitions['message']['bb_plugin'] = array(
	'name'   => esc_html__( 'Message', 'webman-amplifier' ),
	'output' => '[PREFIX_message{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_message]',
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

						'title' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Caption', 'webman-amplifier' ),
							'default' => '',
							'preview' => array( 'type' => 'refresh' ),
						),

						'heading_tag' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Caption HTML tag', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H3' ),
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
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

		// Tab
		'icon' => array(
			'title'       => esc_html__( 'Icon', 'webman-amplifier' ),
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

						'color' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Color', 'webman-amplifier' ),
							'options' => $helpers['colors'],
							'preview' => array( 'type' => 'refresh' ),
						),

						'size' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Size', 'webman-amplifier' ),
							'options' => $helpers['sizes']['options'],
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

	),
	'compatibility/wpml' => array(
		array(
			'field'       => 'title',
			'type'        => esc_html__( 'Caption', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
		array(
			'field'       => 'content',
			'type'        => esc_html__( 'Content', 'webman-amplifier' ),
			'editor_type' => 'VISUAL',
		),
	),
);
