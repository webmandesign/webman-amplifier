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
							'options' => $helpers['heading_tags'],
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
							'options' => $helpers['colors'],
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /button_color

						'button_size' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Button size', 'webman-amplifier' ),
							//type specific
							'options' => $helpers['sizes']['options'],
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
							'options'    => $helpers['font_icons'],
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
