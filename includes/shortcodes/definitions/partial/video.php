<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [video]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['video'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Video', 'webman-amplifier' ),
		'code'  => '[PREFIX_video src="" poster="" autoplay="0/1" loop="0/1" class="" /]',
		'short' => false,
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Video', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'video',
		'class'    => 'wm-shortcode-vc-video',
		'icon'     => 'icon-wpb-film-youtube',
		'category' => esc_html__( 'Media', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Video source', 'webman-amplifier' ),
				'description' => esc_html__( 'Set the video URL', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'src',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Poster', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional placeholder image', 'webman-amplifier' ),
				'type'        => 'attach_image',
				'param_name'  => 'poster',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			30 => array(
				'heading'     => esc_html__( 'Autoplay the video?', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'autoplay',
				'value'       => array(
					esc_html__( 'No', 'webman-amplifier' )  => '',
					esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
				),
				'holder'      => 'hidden',
				'class'       => '',
			),
			40 => array(
				'heading'     => esc_html__( 'Loop the video?', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'loop',
				'value'       => array(
					esc_html__( 'No', 'webman-amplifier' )  => '',
					esc_html__( 'Yes', 'webman-amplifier' ) => 'on',
				),
				'holder'      => 'hidden',
				'class'       => '',
			),
			50 => array(
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
