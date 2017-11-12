<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [message]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['message'][ $key ] = array(
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
);
