<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Redefining, extending the [vc_row_inner] shortcode.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$definitions['vc_row_inner'] = array(
	'since' => '1.0',
	 $key   => array(
		'name'                    => esc_html__( 'Row', 'webman-amplifier' ),
		'base'                    => 'vc_row_inner',
		'class'                   => 'wm-shortcode-vc-row-inner',
		'icon'                    => 'icon-wpb-row',
		'category'                => esc_html__( 'Structure', 'webman-amplifier' ),
		'content_element'         => false,
		'is_container'            => true,
		'weight'                  => 1000,
		'show_settings_on_create' => false,
		'js_view'                 => 'VcRowView',
		'params'                  => array(

			10 => array(
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
