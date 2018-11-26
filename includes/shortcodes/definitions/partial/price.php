<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [price]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['price'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Price', 'webman-amplifier' ),
		'code'  => '[PREFIX_price caption="' . esc_html__( 'Title', 'webman-amplifier' ) . '" cost="99$" color="" color_text="" appearance="default/featured/legend" class=""]{{content}}[/PREFIX_price]',
		'short' => false,
	),
	'vc_plugin' => array(
		'name'            => $prefix['name'] . esc_html__( 'Price', 'webman-amplifier' ),
		'base'            => $prefix['code'] . 'price',
		'class'           => 'wm-shortcode-vc-price',
		'content_element' => false,
		'category'        => esc_html__( 'Content', 'webman-amplifier' ),
		'params'          => array(
			array(
				'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'caption',
				'value'       => '',
				'holder'      => 'div',
				'class'       => '',
			),
			array(
				'heading'    => esc_html__( 'Cost', 'webman-amplifier' ),
				'type'       => 'textarea',
				'param_name' => 'cost',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),
			array(
				'heading'     => esc_html__( 'Features list', 'webman-amplifier' ),
				'description' => esc_html__( 'Insert an unordered list of features', 'webman-amplifier' ),
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button]',
				'holder'      => 'hidden',
				'class'       => '',
			),
			array(
				'heading'     => esc_html__( 'Column color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			array(
				'heading'     => esc_html__( 'Column text color', 'webman-amplifier' ),
				'type'        => 'colorpicker',
				'param_name'  => 'color_text',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			array(
				'heading'     => esc_html__( 'Appearance', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'appearance',
				'value'       => array(
					esc_html__( 'Default price column', 'webman-amplifier' )  => '',
					esc_html__( 'Featured price column', 'webman-amplifier' ) => 'featured',
					esc_html__( 'Pricing table legend', 'webman-amplifier' )  => 'legend',
				),
				'holder'      => 'hidden',
				'class'       => '',
			),
			array(
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
