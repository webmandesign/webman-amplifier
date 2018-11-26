<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [separator_heading]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['separator_heading'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Separator Heading', 'webman-amplifier' ),
		'code'  => '[PREFIX_separator_heading align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '" tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '" class="" id=""]{{content}}[/PREFIX_separator_heading]',
		'short' => true,
	),
	'vc_plugin' => array(
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
	),
);
