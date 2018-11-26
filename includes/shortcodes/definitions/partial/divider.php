<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [divider]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['divider'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'code' => '[PREFIX_divider appearance="' . implode( '/', array_keys( wma_ksort( $helpers['divider_appearance'] ) ) ) . '" space_before="" space_after="" class="" /]',
		'short' => true,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'output' => '[PREFIX_divider{{appearance}}{{class}} /]',
		'params' => array( 'appearance', 'class' ),
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
								'options' => $helpers['divider_appearance'],
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /appearance

						), // /fields
					), // /section

				), // /sections
			), // /tab

		),
	),
	'vc_plugin'  => array(
		'name'                    => $prefix['name'] . esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'base'                    => $prefix['code'] . 'divider',
		'class'                   => 'wm-shortcode-vc-divider',
		'icon'                    => 'icon-wpb-ui-separator',
		'show_settings_on_create' => false,
		'category'                => esc_html__( 'Content', 'webman-amplifier' ),
		'params'                  => array(
			10 => array(
				'heading'     => esc_html__( 'Appearance', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'appearance',
				'value'       => array_flip( $helpers['divider_appearance'] ),
				'holder'      => 'div',
				'class'       => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Space before divider', 'webman-amplifier' ),
				'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'space_before',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			30 => array(
				'heading'     => esc_html__( 'Space after divider', 'webman-amplifier' ),
				'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'space_after',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
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
			50 => array(
				'heading'     => esc_html__( 'CSS styles', 'webman-amplifier' ),
				'description' => esc_html__( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'style',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
		),
	),
);
