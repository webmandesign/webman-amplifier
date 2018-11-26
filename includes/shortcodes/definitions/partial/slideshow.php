<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [slideshow]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['slideshow'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Slideshow', 'webman-amplifier' ),
		'code'  => '[PREFIX_slideshow ids="" nav="none/thumbs/pagination" size="full/' . implode( '/', get_intermediate_image_sizes() ) . '" speed="3000" class="" /]',
		'short' => false,
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Slideshow', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'slideshow',
		'class'    => 'wm-shortcode-vc-slideshow',
		'icon'     => 'icon-wpb-images-carousel',
		'category' => esc_html__( 'Media', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Images', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_images',
				'param_name'  => 'ids',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Navigation', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'nav',
				'value'      => array(
					esc_html__( 'Just Next/Prev button', 'webman-amplifier' ) => '',
					esc_html__( 'Thumbnails', 'webman-amplifier' )            => 'thumbs',
					esc_html__( 'Pagination', 'webman-amplifier' )            => 'pagination',
				),
				'holder'     => 'hidden',
				'class'      => '',
			),
			30 => array(
				'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'image_size',
				'value'      => wma_asort( array( '' => '' ) + array_flip( wma_get_image_sizes() ) ),
				'holder'     => 'hidden',
				'class'      => '',
			),
			40 => array(
				'heading'     => esc_html__( 'Speed in miliseconds', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'speed',
				'value'       => apply_filters( 'wmhook_shortcode_' . 'slideshow_speed', 3000 ),
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
