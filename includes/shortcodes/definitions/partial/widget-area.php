<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [widget_area]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['widget_area'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Widgets Area', 'webman-amplifier' ),
		'code'  => '[PREFIX_widget_area area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '" class="" max_widgets_count="0" /]',
		'short' => true,
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Widgets Area', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'widget_area',
		'class'    => 'wm-shortcode-vc-widget_area',
		'icon'     => 'icon-wpb-layout_sidebar',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Widgets area', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'area',
				'value'       => array_flip( wma_widget_areas_array() ), // 1st value is empty
				'holder'      => 'div',
				'class'       => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Maximum widgets count', 'webman-amplifier' ),
				'description' => esc_html__( 'Area will not be displayed when the number of widgets inserted in it is greater', 'webman-amplifier' ),
				'type'        => 'dropdown',
				'param_name'  => 'max_widgets_count',
				'value'       => array(
					'' => '',
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4,
					5  => 5,
					6  => 6,
					7  => 7,
					8  => 8,
					9  => 9,
					10 => 10,
					11 => 11,
					12 => 12,
				),
				'holder'      => 'hidden',
				'class'       => '',
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
