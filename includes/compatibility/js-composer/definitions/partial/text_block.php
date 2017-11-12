<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Adding custom [text_block] shortcode (only for WPBakery Page Builder).
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['text_block'] = array(
	'since' => '1.0',
	$key    => array(
		'name'     => $prefix['name'] . esc_html__( 'Text Block', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'text_block',
		'class'    => 'wm-shortcode-vc-text_block',
		'icon'     => 'icon-wpb-layer-shape-text',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(

			10 => array(
				'heading'     => esc_html__( 'Content', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),

			20 => array(
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
