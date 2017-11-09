<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [icon]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$social_icons = $helpers['social_icons'];
array_push(
	$social_icons,
	'',
	'background-light',
	'background-dark'
);
asort( $social_icons );
$social_icons = array_combine(
	$social_icons, // keys
	$social_icons // values
);



$definitions['icon'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
		'code'  => '[PREFIX_icon class="icon-class" social="' . implode( '/', $social_icons ) . '" url="" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" /]',
		'short' => true,
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'icon',
		'class'    => 'wm-shortcode-vc-icon',
		'icon'     => 'icon-wpb-vc_icon',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'    => esc_html__( 'Icon', 'webman-amplifier' ),
				'type'       => 'wm_radio',
				'param_name' => 'icon',
				'value'      => $helpers['font_icons'],
				'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
				'filter'     => true,
				'hide_radio' => true,
				'inline'     => true,
				'holder'     => 'div',
				'class'      => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Size', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'size',
				'value'      => array( '' => '' ) + array_flip( $helpers['sizes']['options'] ),
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
				'heading'    => esc_html__( 'Social icon?', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'social',
				'value'      => $social_icons, // 1st value is empty
				'holder'     => 'hidden',
				'class'      => '',
				'group'      => esc_html__( 'Social icon', 'webman-amplifier' ),
			),
			40 => array(
				'heading'    => esc_html__( 'Social icon link URL', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'url',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
				'group'      => esc_html__( 'Social icon', 'webman-amplifier' ),
			),
			50 => array(
				'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'target',
				'value'       => array(
					esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
					esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
				),
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Social icon title', 'webman-amplifier' ),
				'description' => esc_html__( 'Will be displayed when mouse hovers over the icon', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'title',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
			),
			70 => array(
				'heading'     => esc_html__( 'Social icon relation', 'webman-amplifier' ),
				'description' => esc_html__( 'The HTML "rel" attribute', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'rel',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Social icon', 'webman-amplifier' ),
			),

			80 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			90 => array(
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
