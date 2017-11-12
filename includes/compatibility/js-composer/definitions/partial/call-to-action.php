<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [call_to_action]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['call_to_action'][ $key ] = array(
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
);
