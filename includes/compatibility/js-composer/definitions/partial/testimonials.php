<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [testimonials]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$testimonials_slugs = wma_posts_array( 'post_name', 'wm_testimonials' );
$testimonials_cats  = wma_taxonomy_array( array(
	'all_post_type' => '',
	'all_text'      => '-',
	'hierarchical'  => '0',
	'tax_name'      => 'testimonial_category'
) );

$definitions['testimonials'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Testimonials', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'testimonials',
	'class'    => 'wm-shortcode-vc-testimonials',
	'icon'     => 'vc_icon-vc-gitem-post-title',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'     => esc_html__( 'Single testimonial', 'webman-amplifier' ),
			'description' => esc_html__( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'testimonial',
			'value'       => array_flip( $testimonials_slugs ), // 1st value is empty
			'holder'      => 'div',
			'class'       => '',
		),

		20 => array(
			'heading'     => esc_html__( 'Count', 'webman-amplifier' ),
			'description' => esc_html__( 'Number of items to display', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'count',
			'value'       => 3,
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		30 => array(
			'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'columns',
			'value'      => array(
				'' => '', // prevent forcing 1
				1  => 1,
				2  => 2,
				3  => 3,
				4  => 4,
				5  => 5,
				6  => 6,
			),
			'holder'     => 'hidden',
			'class'      => '',
			'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		40 => array(
			'heading'    => esc_html__( 'Order', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Newest first', 'webman-amplifier' )       => 'new', // default
				esc_html__( 'Oldest first', 'webman-amplifier' )       => 'old',
				esc_html__( 'By name', 'webman-amplifier' )            => 'name',
				esc_html__( 'Randomly', 'webman-amplifier' )           => 'random',
				esc_html__( 'Custom, ascending', 'webman-amplifier' )  => 'menuasc',
				esc_html__( 'Custom, descending', 'webman-amplifier' ) => 'menudesc',
			),
			'holder'     => 'hidden',
			'class'      => '',
			'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		50 => array(
			'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
			'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'scroll',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		60 => array(
			'heading'     => esc_html__( 'Category', 'webman-amplifier' ),
			'description' => esc_html__( 'Displays items only from a specific category', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'category',
			'value'       => array_flip( $testimonials_cats ), // 1st value is empty
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		70 => array(
			'heading'     => esc_html__( 'Display pagination?', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'pagination',
			'value'       => array(
				esc_html__( 'No', 'webman-amplifier' )  => '',
				esc_html__( 'Yes', 'webman-amplifier' ) => 1,
			),
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		80 => array(
			'heading'     => esc_html__( 'Description text (HTML)', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'textarea',
			'param_name'  => 'content',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		90 => array(
			'heading'    => esc_html__( 'Description alignment', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'align',
			'value'      => array(
				esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
				esc_html__( 'Right', 'webman-amplifier' ) => 'right',
			),
			'holder'     => 'hidden',
			'class'      => '',
			'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		100 => array(
			'heading'     => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'no_margin',
			'value'       => array(
				esc_html__( 'No', 'webman-amplifier' )  => '',
				esc_html__( 'Yes', 'webman-amplifier' ) => 1,
			),
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		110 => array(
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
