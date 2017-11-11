<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [accordion]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['accordion']['vc_plugin'] = array(
	'name'                    => $prefix['name'] . esc_html__( 'Accordion', 'webman-amplifier' ),
	'base'                    => $prefix['code'] . 'accordion',
	'class'                   => 'wm-shortcode-vc-accordion wm-sections-mode',
	'icon'                    => 'icon-wpb-ui-accordion',
	'show_settings_on_create' => false,
	'is_container'            => true,
	'category'                => esc_html__( 'Content', 'webman-amplifier' ),
	'custom_markup'           => '
		<h4 class="wm-sections-mode-title wpb_element_title"><i class="vc_general vc_element-icon icon-wpb-ui-separator-label"></i> ' . esc_html__( 'Accordion', 'webman-amplifier' ) . '</h4>
		<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
			%content%
		</div>
		<div class="tab_controls">
			<button data-item="' . $prefix['code'] . 'item" data-item-title="' . esc_html__( 'Section', 'webman-amplifier' ) . '" class="add_tab" title="' . esc_html__( 'Accordion: Add new section', 'webman-amplifier' ) . '">' . esc_html__( 'Accordion: Add new section', 'webman-amplifier' ) . '</button>
		</div>
	',
	'default_content'         => '
		[' . $prefix['code'] . 'item title="' . esc_html__( 'Section 1', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
		[' . $prefix['code'] . 'item title="' . esc_html__( 'Section 2', 'webman-amplifier' ).'"][/' . $prefix['code'] . 'item]
	',
	'js_view'                 => 'VcCustomAccordionView',
	'params'                  => array(
		10 => array(
			'heading'     => esc_html__( 'Active section', 'webman-amplifier' ),
			'description' => esc_html__( 'Set section order number, "0" for all sections closed', 'webman-amplifier' ),
			'type'        => 'textfield',
			'param_name'  => 'active',
			'value'       => 0,
			'holder'      => 'hidden',
			'class'       => '',
		),
		20 => array(
			'heading'     => esc_html__( 'Mode', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'mode',
			'value'       => array(
				esc_html__( 'Accordion (only one section open)', 'webman-amplifier' ) => 'accordion', // default
				esc_html__( 'Toggle (multiple sections open)', 'webman-amplifier' )   => 'toggle',
			),
			'holder'      => 'hidden',
			'class'       => '',
		),
		30 => array(
			'heading'     => esc_html__( 'Filtering', 'webman-amplifier' ),
			'description' => esc_html__( 'Display the sections filter from sections tags?', 'webman-amplifier' ),
			'type'        => 'dropdown',
			'param_name'  => 'filter',
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
