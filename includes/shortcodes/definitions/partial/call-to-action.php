<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [call_to_action]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['call_to_action'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Call to Action', 'webman-amplifier' ),
		'code'  => '[PREFIX_call_to_action caption="" button_text="" button_url="#" button_color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" button_size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" button_icon="" class=""]{{content}}[/PREFIX_call_to_action]',
		'short' => false,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Call to Action', 'webman-amplifier' ),
		'output' => '[PREFIX_call_to_action{{caption}}{{heading_tag}}{{button_text}}{{button_url}}{{target}}{{button_color}}{{button_size}}{{button_icon}}{{class}}]{{content}}[/PREFIX_call_to_action]',
		'params' => array( 'caption', 'heading_tag', 'button_text', 'button_url', 'target', 'button_color', 'button_size', 'button_icon', 'class', 'content' ),
		'wpml_fields' => array(
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
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Call to Action', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'call_to_action',
		'class'    => 'wm-shortcode-vc-call_to_action',
		'icon'     => 'icon-wpb-call-to-action',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'caption',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Content text', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			30 => array(
				'heading'     => esc_html__( 'Button text', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'button_text',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
				40 => array(
					'heading'    => esc_html__( 'Button link URL', 'webman-amplifier' ),
					'type'       => 'textfield',
					'param_name' => 'button_url',
					'value'      => '',
					'holder'     => 'hidden',
					'class'      => '',
				),
				50 => array(
					'heading'     => esc_html__( 'Button link target', 'webman-amplifier' ),
					'description' => '',
					'type'        => 'dropdown',
					'param_name'  => 'target',
					'value'       => array(
						esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
						esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
					),
					'holder'      => 'hidden',
					'class'       => '',
				),
				60 => array(
					'heading'     => esc_html__( 'Button color', 'webman-amplifier' ),
					'description' => '',
					'type'        => 'dropdown',
					'param_name'  => 'button_color',
					'value'       => array( '' => '' ) + array_flip( $helpers['colors'] ),
					'holder'      => 'hidden',
					'class'       => '',
				),
				70 => array(
					'heading'     => esc_html__( 'Button size', 'webman-amplifier' ),
					'description' => '',
					'type'        => 'dropdown',
					'param_name'  => 'button_size',
					'value'       => array( '' => '' ) + array_flip( $helpers['sizes']['options'] ),
					'holder'      => 'hidden',
					'class'       => '',
				),
				80 => array(
					'heading'     => esc_html__( 'Button icon', 'webman-amplifier' ),
					'description' => esc_html__( 'Choose one of available icons', 'webman-amplifier' ),
					'type'        => 'wm_radio',
					'param_name'  => 'button_icon',
					'value'       => $helpers['font_icons'],
					'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
					'filter'      => true,
					'hide_radio'  => true,
					'inline'      => true,
					'holder'      => 'hidden',
					'class'       => '',
				),
			90 => array(
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
