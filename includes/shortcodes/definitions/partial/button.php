<?php
/**
 * Shortcode definitions array partial: [button]
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
$definitions['button'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Button', 'webman-amplifier' ),
		'code'  => '[PREFIX_button url="#" color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" icon="" class=""]{{content}}[/PREFIX_button]',
		'short' => true,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Button', 'webman-amplifier' ),
		'output' => '[PREFIX_button{{url}}{{target}}{{color}}{{size}}{{icon}}{{class}}]{{content}}[/PREFIX_button]',
		'params' => array( 'url', 'target', 'color', 'size', 'icon', 'class', 'content' ),
		'wpml_fields' => array(
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

							'content' => array(
								'type' => 'text',
								//description
								'label' => esc_html__( 'Button text', 'webman-amplifier' ),
								//default
								'default' => esc_html__( 'Button Text', 'webman-amplifier' ),
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /content

							'url' => array(
								'type' => 'text',
								//description
								'label' => esc_html__( 'Button link URL', 'webman-amplifier' ),
								//default
								'default' => '#',
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /url

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

							'color' => array(
								'type' => 'select',
								//description
								'label' => esc_html__( 'Color', 'webman-amplifier' ),
								//type specific
								'options' => $helpers['colors'],
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /color

							'size' => array(
								'type' => 'select',
								//description
								'label' => esc_html__( 'Size', 'webman-amplifier' ),
								//type specific
								'options' => $helpers['sizes']['options'],
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /size

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

		),
	),
);
