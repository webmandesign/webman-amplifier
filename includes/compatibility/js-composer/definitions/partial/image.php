<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Adding custom [image] shortcode (only for WPBakery Page Builder).
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['image'] = array(
	'since' => '1.0',
	$key    => array(
		'name'     => $prefix['name'] . esc_html__( 'Image', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'image',
		'class'    => 'wm-shortcode-vc-image',
		'icon'     => 'icon-wpb-single-image',
		'category' => esc_html__( 'Media', 'webman-amplifier' ),
		'params'   => array(

			10 => array(
				'heading'     => esc_html__( 'Image to display', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'src',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),

			20 => array(
				'heading'    => esc_html__( 'Image link URL', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'link',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
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
				'dependency'  => array(
					'element'   => 'link',
					'not_empty' => true
				),
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
				'heading'     => esc_html__( 'Image width HTML attribute', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'width',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			60 => array(
				'heading'     => esc_html__( 'Image height HTML attribute', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'height',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			70 => array(
				'heading'     => esc_html__( 'Margin', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'margin',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

		),
	),
);
