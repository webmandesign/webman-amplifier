<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [list]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['list'] = array(
	'since'  => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Icon List', 'webman-amplifier' ),
		'code'  => '[PREFIX_list bullet="icon-class" class=""]<ul><li>{{content}}</li><li>' . esc_html__( 'List item', 'webman-amplifier' ) . '</li></ul>[/PREFIX_list]',
		'short' => true,
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Icon List', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'list',
		'class'    => 'wm-shortcode-vc-list',
		'icon'     => 'icon-wpb-vc_icon',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'List items (insert unordered list only)', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '<ul><li>TEXT</li><li>TEXT</li></ul>',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Bullet icon', 'webman-amplifier' ),
				'type'       => 'wm_radio',
				'param_name' => 'bullet',
				'value'      => $helpers['font_icons'],
				'custom'     => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
				'filter'     => true,
				'hide_radio' => true,
				'inline'     => true,
				'holder'     => 'div',
				'class'      => '',
			),
			30 => array(
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
