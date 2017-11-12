<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Redefining, extending the [vc_row] shortcode.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['vc_row'] = array(
	'since' => '1.0',
	 $key   => array(
		'name'                    => esc_html__( 'Row', 'webman-amplifier' ),
		'base'                    => 'vc_row',
		'class'                   => 'wm-shortcode-vc-row',
		'icon'                    => 'icon-wpb-row',
		'category'                => esc_html__( 'Structure', 'webman-amplifier' ),
		'is_container'            => true,
		'show_settings_on_create' => false,
		'js_view'                 => 'VcRowView',
		'params'                  => array(

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
				'heading'     => esc_html__( 'Parallax scroll speed', 'webman-amplifier' ),
				'description' => esc_html__( 'Set the inertia of parallax background moving. For example, value of <code>0.1</code> equals to tenth of normal scroll speed.', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'parallax',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'dependency'  => array(
					'element'   => 'bg_image',
					'not_empty' => true
				),
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			70 => array(
				'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'padding',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),

			80 => array(
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
