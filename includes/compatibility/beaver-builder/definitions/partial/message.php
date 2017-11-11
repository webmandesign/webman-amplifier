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
							'options' => $helpers['colors'],
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /color

						'size' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Size', 'webman-amplifier' ),
							//type specific
							'options' => $helpers['sizes']['options'],
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /size

						), // /fields
					), // /section

			), // /sections
		), // /tab

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
