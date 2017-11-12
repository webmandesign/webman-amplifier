<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [content_module]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$content_module_slugs = wma_posts_array( 'post_name', 'wm_modules' );
$content_module_tags  = wma_taxonomy_array( array(
	'all_post_type' => '',
	'all_text'      => '-',
	'hierarchical'  => '0',
	'tax_name'      => 'module_tag'
) );

$definitions['content_module'][ $key ] = array(
	'name'     => $prefix['name'] . esc_html__( 'Content Module', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'content_module',
	'class'    => 'wm-shortcode-vc-content_module',
	'icon'     => 'icon-wpb-toggle-small-expand',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(

		10 => array(
			'heading'     => esc_html__( 'Single module', 'webman-amplifier' ),
			'description' => esc_html__( 'Leave empty to display multiple modules', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'module',
			'value'       => array_flip( $content_module_slugs ), // 1st value is empty
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
				'' => '', // not forcing default to 1
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
			'heading'     => esc_html__( 'Filter', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'filter',
			'value'       => array(
				esc_html__( 'No', 'webman-amplifier' )  => '',
				esc_html__( 'Yes', 'webman-amplifier' ) => 1,
			),
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		60 => array(
			'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
			'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'scroll',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		70 => array(
			'heading'     => esc_html__( 'Tag', 'webman-amplifier' ),
			'description' => esc_html__( 'Display specifically tagged items only', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'tag',
			'value'       => array_flip( $content_module_tags ), // 1st value is empty
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		80 => array(
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

		90 => array(
			'heading'     => esc_html__( 'Description text (HTML)', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'textarea',
			'param_name'  => 'content',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		100 => array(
			'heading'     => esc_html__( 'Description alignment', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'align',
			'value'       => array(
				esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
				esc_html__( 'Right', 'webman-amplifier' ) => 'right',
			),
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
		),

		110 => array(
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

		120 => array(
			'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'image_size',
			'value'      => wma_asort( array( '' => '' ) + array_flip( wma_get_image_sizes() ) ),
			'holder'     => 'hidden',
			'class'      => '',
			'group'      => esc_html__( 'Layout', 'webman-amplifier' ),
		),

		130 => array(
			'heading'     => esc_html__( 'Custom layout', 'webman-amplifier' ),
			'description' => sprintf( esc_html__( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
			'type'        => 'textfield',
			'param_name'  => 'layout',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Layout', 'webman-amplifier' ),
		),

		140 => array(
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
