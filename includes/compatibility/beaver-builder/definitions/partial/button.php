<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [button]
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
	'icon',
	'size',
	'target',
	'url',
);

$definitions['button'][ $key ] = array(
	'name'   => esc_html__( 'Button', 'webman-amplifier' ),
	'output' => '[PREFIX_button{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_button]',
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

						'content' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Button text', 'webman-amplifier' ),
							'default' => esc_html__( 'Button Text', 'webman-amplifier' ),
							'preview' => array( 'type' => 'none' ),
						),

						'url' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Button link URL', 'webman-amplifier' ),
							'default' => '#',
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

						'color' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Color', 'webman-amplifier' ),
							'options' => $helpers['colors'],
							'preview' => array( 'type' => 'none' ),
						),

						'size' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Size', 'webman-amplifier' ),
							'options' => $helpers['sizes']['options'],
							'preview' => array( 'type' => 'none' ),
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

	),
	'compatibility/wpml' => array(
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
);
