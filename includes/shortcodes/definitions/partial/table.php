<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [table]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['table'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Table', 'webman-amplifier' ),
		'code'  => '[PREFIX_table appearance="' . implode( '/', array_keys( wma_ksort( $helpers['table_appearance'] ) ) ) . '" separator="," class=""]{{content}}[/PREFIX_table]',
		'short' => false,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Table', 'webman-amplifier' ),
		'output' => '[PREFIX_table{{appearance}}{{separator}}{{class}}]{{content}}[/PREFIX_table]',
		'params' => array( 'appearance', 'separator', 'class', 'content' ),
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

							'appearance' => array(
								'type' => 'select',
								//description
								'label' => esc_html__( 'Appearance', 'webman-amplifier' ),
								//type specific
								'options' => $helpers['table_appearance'],
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /appearance

							'separator' => array(
								'type' => 'text',
								//description
								'label' => esc_html__( 'CSV data separator', 'webman-amplifier' ),
								//default
								'default' => ',',
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /separator

						), // /fields
					), // /section

					//Section
					'content' => array(
						'title'  => esc_html__( 'CSV data', 'webman-amplifier' ),
						'fields' => array(

							'content' => array(
								'type' => 'editor',
								//description
								'label' => '',
								//default
								'default' => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
								//preview
								'preview' => array( 'type' => 'none' ),
							), // /content

						), // /fields
					), // /section

				), // /sections
			), // /tab

		),
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Table', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'table',
		'class'    => 'wm-shortcode-vc-table',
		'icon'     => 'vc_icon-vc-media-grid',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'    => esc_html__( 'CSV data', 'webman-amplifier' ),
				'type'       => 'textarea_html',
				'param_name' => 'content',
				'value'      => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
				'holder'     => 'hidden',
				'class'      => '',
			),
			20 => array(
				'heading'    => esc_html__( 'CSV data separator', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'separator',
				'value'      => ',',
				'holder'     => 'hidden',
				'class'      => '',
			),
			30 => array(
				'heading'    => esc_html__( 'Appearance', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'appearance',
				'value'      => array( '' => '' ) + array_flip( $helpers['table_appearance'] ),
				'holder'     => 'hidden',
				'class'      => '',
			),
			40 => array(
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
