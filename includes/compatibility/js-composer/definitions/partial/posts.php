<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [posts]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$taxonomies = get_taxonomies( '', 'names' );
unset( $taxonomies['nav_menu'] );
unset( $taxonomies['link_category'] );
asort( $taxonomies );

$definitions['posts']['vc_plugin'] = array(
	'name'     => $prefix['name'] . esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
	'base'     => $prefix['code'] . 'posts',
	'class'    => 'wm-shortcode-vc-posts',
	'icon'     => 'icon-wpb-vc_carousel',
	'category' => esc_html__( 'Content', 'webman-amplifier' ),
	'params'   => array(
		10 => array(
			'heading'     => esc_html__( 'Post type', 'webman-amplifier' ),
			'description' => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'post_type',
			'value'       => array( '' => '' ) + array_flip( $helpers['post_types'] ),
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
		),
		30 => array(
			'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'columns',
			'value'      => array(
				'' => '', // prevent forcing 1 as default
				1  => 1,
				2  => 2,
				3  => 3,
				4  => 4,
				5  => 5,
				6  => 6,
			),
			'holder'     => 'hidden',
			'class'      => '',
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
		),

		50 => array(
			'heading'     => esc_html__( 'Taxonomy', 'webman-amplifier' ),
			'description' => esc_html__( 'Displays items only from a specific taxonomy. Set a taxonomy name and taxonomy slug separated with colon.', 'webman-amplifier' ) . '<br>' . esc_html__( 'For example: "category:category-slug".', 'webman-amplifier' ) . '<br>' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
			'type'        => 'textfield',
			'param_name'  => 'taxonomy',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
		),
		60 => array(
			'heading'     => esc_html__( 'Relation', 'webman-amplifier' ),
			'description' => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ) . ' ' . esc_html__( 'For example: "category".', 'webman-amplifier' ) . '<br>' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
			'type'        => 'textfield',
			'param_name'  => 'related',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
		),

		70 => array(
			'heading'     => esc_html__( 'Filter', 'webman-amplifier' ),
			'description' => esc_html__( 'If set, the items will be filtered. Set a taxonomy name (and optional parent taxonomy slug separated with colon - filter will be created from sub-taxonomies) which will be used to filter the items.', 'webman-amplifier' ) . '<br>' . esc_html__( 'For example: "category" or "category:parent-category-slug".', 'webman-amplifier' ) . '<br>' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
			'type'        => 'textfield',
			'param_name'  => 'filter',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
		),
		80 => array(
			'heading'     => esc_html__( 'Filter layout', 'webman-amplifier' ),
			'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'filter_layout',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
		),
		90 => array(
			'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
			'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'scroll',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
		),

		100 => array(
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
		),

		110 => array(
			'heading'     => esc_html__( 'Description text', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'textarea_html',
			'param_name'  => 'content',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Description', 'webman-amplifier' ),
		),
		120 => array(
			'heading'     => esc_html__( 'Description alignment', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'align',
			'value'       => array(
				esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
				esc_html__( 'Right', 'webman-amplifier' ) => 'right',
			),
			'holder'      => 'hidden',
			'class'       => '',
			'group'       => esc_html__( 'Description', 'webman-amplifier' ),
		),

		130 => array(
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
			'group'       => esc_html__( 'Layout', 'webman-amplifier' ),
		),
		140 => array(
			'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
			'type'       => 'dropdown',
			'param_name' => 'image_size',
			'value'      => wma_asort( array( '' => '' ) + array_flip( wma_get_image_sizes() ) ),
			'holder'     => 'hidden',
			'class'      => '',
			'group'      => esc_html__( 'Layout', 'webman-amplifier' ),
		),

		150 => array(
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
