<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [table]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['table'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Table', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'table',
	'class'    => 'wm-shortcode-vc-table',
	'icon'     => 'vc_icon-vc-media-grid',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'    => esc_html__( 'CSV data', 'webman-amplifier' ),
			'type'       => 'textarea_html',
			'param_name' => 'content',
			'value'      => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
			'holder'     => 'hidden',
			'class'      => '',
		),

		20 => array(
			'heading'    => esc_html__( 'CSV data separator', 'webman-amplifier' ),
			'type'       => 'textfield',
			'param_name' => 'separator',
			'value'      => ',',
			'holder'     => 'hidden',
			'class'      => '',
		),

		30 => array(
			'heading'    => esc_html__( 'Appearance', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'appearance',
			'value'      => array( '' => '' ) + array_flip( $helpers['table_appearance'] ),
			'holder'     => 'hidden',
			'class'      => '',
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

	),
);
