<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Redefining, extending the [vc_column] shortcode.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['vc_column'] = array(
	'since' => '1.0',
	 $key   => array(
		'name'            => esc_html__( 'Column', 'webman-amplifier' ),
		'base'            => 'vc_column',
		'class'           => 'wm-shortcode-vc-column',
		'category'        => esc_html__( 'Structure', 'webman-amplifier' ),
		'content_element' => false,
		'is_container'    => true,
		'js_view'         => 'VcColumnView',
		'params'          => array(

			10 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),

			20 => array(
				'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'id',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
				'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'bg_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			40 => array(
				'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'font_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			50 => array(
				'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'bg_image',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			60 => array(
				'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'padding',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

		),
	),
);
