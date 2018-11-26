<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [message]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['message'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name' => esc_html__( 'Message', 'webman-amplifier' ),
		'code' => '[PREFIX_message title="" color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_message]',
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Message', 'webman-amplifier' ),
		'output' => '[PREFIX_message{{title}}{{heading_tag}}{{color}}{{size}}{{icon}}{{class}}]{{content}}[/PREFIX_message]',
		'params' => array( 'title', 'heading_tag', 'color', 'size', 'icon', 'class', 'content' ),
		'wpml_fields' => array(
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
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Message', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'message',
		'class'    => 'wm-shortcode-vc-message',
		'icon'     => 'icon-wpb-information-white',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'    => esc_html__( 'Caption', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'title',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Content', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			30 => array(
				'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'color',
				'value'      => array( '' => '' ) + array_flip( $helpers['colors'] ),
				'holder'     => 'div',
				'class'      => '',
			),
			40 => array(
				'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'size',
				'value'      => array( '' => '' ) + array_flip( $helpers['sizes']['options'] ),
				'holder'     => 'hidden',
				'class'      => '',
			),
			50 => array(
				'heading'    => esc_html__( 'Icon', 'webman-amplifier' ),
				'type'       => 'wm_radio',
				'param_name' => 'icon',
				'value'      => $helpers['font_icons'],
				'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
				'filter'     => true,
				'hide_radio' => true,
				'inline'     => true,
				'holder'     => 'hidden',
				'class'      => '',
			),
			60 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
		),
	),
);
