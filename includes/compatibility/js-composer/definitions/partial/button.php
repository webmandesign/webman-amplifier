<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [button]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['button'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Button', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'button',
	'class'    => 'wm-shortcode-vc-button',
	'icon'     => 'icon-wpb-ui-button',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'    => esc_html__( 'Button text', 'webman-amplifier' ),
			'type'       => 'textfield',
			'param_name' => 'content',
			'value'      => esc_html__( 'Button Text', 'webman-amplifier' ),
			'holder'     => 'div',
			'class'      => '',
		),

		20 => array(
			'heading'     => esc_html__( 'Button URL', 'webman-amplifier' ),
			'description' => esc_html__( 'Set the button link URL', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'url',
			'value'       => '#',
			'holder'      => 'hidden',
			'class'       => '',
		),

		30 => array(
			'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
			'description' => esc_html__( 'Button link target', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'target',
			'value'       => array(
				esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
				esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
			),
			'holder'      => 'hidden',
			'class'       => '',
			'dependency'  => array(
				'element'   => 'url',
				'not_empty' => true
			),
		),

		40 => array(
			'heading'    => esc_html__( 'Color', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'color',
			'value'      => array( '' => '' ) + array_flip( $helpers['colors'] ),
			'holder'     => 'hidden',
			'class'      => '',
		),

		50 => array(
			'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'size',
			'value'      => array( '' => '' ) + array_flip( $helpers['sizes']['options'] ),
			'holder'     => 'hidden',
			'class'      => '',
		),

		60 => array(
			'heading'     => esc_html__( 'Icon', 'webman-amplifier' ),
			'type'        => 'wm_radio',
			'param_name'  => 'icon',
			'value'       => $helpers['font_icons'],
			'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
			'filter'      => true,
			'hide_radio'  => true,
			'inline'      => true,
			'holder'      => 'hidden',
			'class'       => '',
		),

		70 => array(
			'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
			'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'class',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),

		80 => array(
			'heading'     => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'id',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),

	),
);
