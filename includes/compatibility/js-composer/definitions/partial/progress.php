<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [progress]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['progress'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Progress Bar', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'progress',
	'class'    => 'wm-shortcode-vc-progress',
	'icon'     => 'icon-wpb-graph',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'     => esc_html__( 'Caption', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'textarea_html',
			'param_name'  => 'content',
			'value'       => esc_html__( 'Progress bar caption', 'webman-amplifier' ),
			'holder'      => 'div',
			'class'       => '',
		),

		20 => array(
			'heading'     => esc_html__( 'Progress in %', 'webman-amplifier' ),
			'description' => esc_html__( 'Insert a number between 0 and 100', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'progress',
			'value'       => '75',
			'holder'      => 'hidden',
			'class'       => '',
		),

		30 => array(
			'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'color',
			'value'      => array( '' => '' ) + array_flip( $helpers['colors'] ),
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
);
