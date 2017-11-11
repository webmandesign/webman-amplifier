<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [separator_heading]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['separator_heading']['vc_plugin'] = array(
	'name'     => $prefix['name'] . esc_html__( 'Separator Heading', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'separator_heading',
	'class'    => 'wm-shortcode-vc-separator_heading',
	'icon'     => 'icon-wpb-ui-separator-label',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(
		10 => array(
			'heading'     => esc_html__( 'Heading text', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'textfield',
			'param_name'  => 'content',
			'value'       => '',
			'holder'      => 'div',
			'class'       => '',
		),
		20 => array(
			'heading'     => esc_html__( 'Heading size', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'tag',
			'value'       => array_flip( $helpers['heading_tags'] ),
			'holder'      => 'hidden',
			'class'       => '',
		),
		30 => array(
			'heading'     => esc_html__( 'Text align', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'align',
			'value'       => array(
				esc_html__( 'Left', 'webman-amplifier' )   => 'left', // default
				esc_html__( 'Center', 'webman-amplifier' ) => 'center',
				esc_html__( 'Right', 'webman-amplifier' )  => 'right',
			),
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
			'heading'     => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'id',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),
	),
);
