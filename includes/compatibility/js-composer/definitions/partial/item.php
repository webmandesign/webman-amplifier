<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [item]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['item'][ $key ] = array(
	'name'                      => $prefix['name'] . esc_html__( 'Item (Accordion / Tab)', 'webman-amplifier' ),
	'base'                      => $prefix['code'] . 'item',
	'class'                     => 'wm-shortcode-vc-item wm-sections-mode-section wpb_vc_accordion_tab',
	'allowed_container_element' => 'vc_row',
	'is_container'              => true,
	'content_element'           => false,
	'category'                  => esc_html__( 'Content', 'webman-amplifier' ),
	'js_view'                   => 'VcCustomAccordionTabView',
	'params'                    => array(

		10 => array(
			'heading'    => esc_html__( 'Title', 'webman-amplifier' ),
			'type'       => 'textfield',
			'param_name' => 'title',
			'value'      => '',
			'holder'     => 'hidden',
			'class'      => '',
		),

		20 => array(
			'heading'     => esc_html__( 'Icon', 'webman-amplifier' ),
			'type'        => 'wm_radio',
			'param_name'  => 'icon',
			'value'       => $helpers['font_icons'],
			'custom'      => '<span aria-hidden="true" class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;"></span>',
			'filter'      => true,
			'hide_radio'  => true,
			'inline'      => true,
			'holder'      => 'hidden',
			'class'       => '',
		),

		30 => array(
			'heading'     => esc_html__( 'Tags', 'webman-amplifier' ),
			'description' => esc_html__( 'Enter comma separated tags. These will be used to filter through items.', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'tags',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),

		40 => array(
			'heading'     => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'heading_tag',
			'value'       => '',
			'holder'      => 'hidden',
			'class'       => '',
		),

	),
);
