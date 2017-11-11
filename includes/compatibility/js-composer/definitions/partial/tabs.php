<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [tabs]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['tabs']['vc_plugin'] = array(
	'name'                    => $prefix['name'] . esc_html__( 'Tabs', 'webman-amplifier' ),
	'base'                    => $prefix['code'] . 'tabs',
	'class'                   => 'wm-shortcode-vc-tabs wm-sections-mode',
	'icon'                    => 'icon-wpb-ui-tab-content',
	'show_settings_on_create' => false,
	'is_container'            => true,
	'category'                => esc_html__( 'Content', 'webman-amplifier' ),
	'custom_markup'           => '
		<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-tab-content"></i> ' . esc_html__( 'Tabs', 'webman-amplifier' ) . '</h4>
		<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
			%content%
		</div>
		<div class="tab_controls">
			<button data-item="' . $prefix['code'] . 'item" data-item-title="' . esc_html__( 'Tab', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Tabs: Add new tab', 'webman-amplifier' ) . '">' . esc_html__( 'Tabs: Add new tab', 'webman-amplifier' ) . '</button>
		</div>
	',
	'default_content'         => '
		[' . $prefix['code'] . 'item title="' . esc_html__( 'Tab 1', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
		[' . $prefix['code'] . 'item title="' . esc_html__( 'Tab 2', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
	',
	'js_view'                 => 'VcCustomAccordionView',
	'params'                  => array(
		10 => array(
			'heading'     => esc_html__( 'Active tab', 'webman-amplifier' ),
			'description' => esc_html__( 'Enter the order number of the tab which should be open by default', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'active',
			'value'       => 1,
			'holder'      => 'hidden',
			'class'       => '',
		),
		20 => array(
			'heading'     => esc_html__( 'Layout', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'layout',
			'value'       => array(
				esc_html__( 'Tabs on top', 'webman-amplifier' )   => 'top', // default
				esc_html__( 'Tabs on left', 'webman-amplifier' )  => 'left',
				esc_html__( 'Tabs on right', 'webman-amplifier' ) => 'right',
			),
			'holder'      => 'hidden',
			'class'       => '',
		),
		30 => array(
			'heading'     => esc_html__( 'Enable tour mode?', 'webman-amplifier' ),
			'description' => '',
			'type'        => 'dropdown',
			'param_name'  => 'tour',
			'value'       => array(
				esc_html__( 'No', 'webman-amplifier' )  => '',
				esc_html__( 'Yes', 'webman-amplifier' ) => 1,
			),
			'holder'      => 'hidden',
			'class'       => '',
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
