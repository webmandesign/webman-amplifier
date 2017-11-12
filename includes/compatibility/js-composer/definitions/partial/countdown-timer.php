<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [countdown_timer]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['countdown_timer'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Countdown Timer', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'countdown_timer',
	'class'    => 'wm-shortcode-vc-countdown_timer',
	'icon'     => 'vc_icon-vc-gitem-post-date',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'    => esc_html__( 'Time', 'webman-amplifier' ),
			'type'       => 'textfield',
			'param_name' => 'time',
			'value'      => date( get_option( 'date_format' ), strtotime( 'now' ) ),
			'holder'     => 'hidden',
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
