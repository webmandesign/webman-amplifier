<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [pricing_table]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['pricing_table'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Pricing Table', 'webman-amplifier' ),
		'code'  => '[PREFIX_pricing_table no_margin="0/1" class=""]<br />[PREFIX_price caption="' . esc_html__( 'Price 1', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]{{content}}[/PREFIX_price]<br />[PREFIX_price caption="' . esc_html__( 'Price 2', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]' . esc_html__( 'Price 2 content goes here', 'webman-amplifier' ) . '[/PREFIX_price]<br />[/PREFIX_pricing_table]',
		'short' => false,
	),
	'vc_plugin' => array(
		'name'                    => $prefix['name'] . esc_html__( 'Pricing Table', 'webman-amplifier' ),
		'base'                    => $prefix['code'] . 'pricing_table',
		'class'                   => 'wm-shortcode-vc-pricing_table wm-sections-mode',
		'show_settings_on_create' => false,
		'is_container'            => true,
		'category'                => esc_html__( 'Content', 'webman-amplifier' ),
		'custom_markup'           => '
			<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon" data-is-container="true"></i> ' . esc_html__( 'Pricing table', 'webman-amplifier' ) . '</h4>
			<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
				%content%
			</div>
			<div class="tab_controls">
				<button data-item="' . $prefix['code'] . 'price" data-item-title="' . esc_html__( 'Price', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Pricing table: Add new price', 'webman-amplifier' ) . '">' . esc_html__( 'Pricing table: Add new price', 'webman-amplifier' ) . '</button>
			</div>
		',
		'default_content'         => '
			[' . $prefix['code'] . 'price caption="' . esc_html__( 'Price 1', 'webman-amplifier' ).'"]' . esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button][/' . $prefix['code'] . 'price]
			[' . $prefix['code'] . 'price caption="' . esc_html__( 'Price 2', 'webman-amplifier' ).'"]' . esc_html__( '<ul><li>Price feature</li><li>Another price feature</li></ul>', 'webman-amplifier' ) . '[' . $prefix['code'] . 'button url="#" color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" icon="" class=""]' . esc_html__( 'Button text', 'webman-amplifier' ) .'[/' . $prefix['code'] . 'button][/' . $prefix['code'] . 'price]
		',
		'js_view'                 => 'VcCustomPricingTableView',
		'params'                  => array(
			10 => array(
				'heading'     => esc_html__( 'Remove margins between price columns?', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'no_margin',
				'value'       => array(
					esc_html__( 'No', 'webman-amplifier' )  => '',
					esc_html__( 'Yes', 'webman-amplifier' ) => 1,
				),
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
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
