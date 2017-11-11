<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [divider]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['divider']['vc_plugin'] = array(
	'name'                    => $prefix['name'] . esc_html__( 'Divider / Gap', 'webman-amplifier' ),
	'base'                    => $prefix['code'] . 'divider',
	'class'                   => 'wm-shortcode-vc-divider',
	'icon'                    => 'icon-wpb-ui-separator',
	'show_settings_on_create' => false,
	'category'                => esc_html__( 'Content', 'webman-amplifier' ),
	'params'                  => array(
		10 => array(
			'heading'     => esc_html__( 'Appearance', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'appearance',
			'value'       => array_flip( $helpers['divider_appearance'] ),
			'holder'      => 'div',
			'class'       => '',
		),
		20 => array(
			'heading'     => esc_html__( 'Space before divider', 'webman-amplifier' ),
			'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'space_before',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),
		30 => array(
			'heading'     => esc_html__( 'Space after divider', 'webman-amplifier' ),
			'description' => esc_html__( 'Insert a number (of pixels)', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'space_after',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
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
			'heading'     => esc_html__( 'CSS styles', 'webman-amplifier' ),
			'description' => esc_html__( 'Any custom CSS style inserted into style HTML attribute', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'style',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),
	),
);
