<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: Visual Composer related
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





/**
 * Redefine (extend) the vc_row shortcode
 */
$definitions['vc_row'] = array(
	'since' => '1.0',
	'vc_plugin' => array(
		'name'                    => esc_html__( 'Row', 'webman-amplifier' ),
		'base'                    => 'vc_row',
		'class'                   => 'wm-shortcode-vc-row',
		'icon'                    => 'icon-wpb-row',
		'category'                => esc_html__( 'Structure', 'webman-amplifier' ),
		'is_container'            => true,
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
			20 => array(
				'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'id',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
				'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'bg_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			40 => array(
				'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'font_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			50 => array(
				'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'bg_image',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Parallax scroll speed', 'webman-amplifier' ),
				'description' => esc_html__( 'Set the inertia of parallax background moving. For example, value of <code>0.1</code> equals to tenth of normal scroll speed.', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'parallax',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'dependency'  => array(
					'element'   => 'bg_image',
					'not_empty' => true
				),
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			70 => array(
				'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'padding',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			80 => array(
				'heading'     => esc_html__( 'Margin', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'margin',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
		),
	),
);



/**
 * Redefine the vc_row_inner shortcode
 */
$definitions['vc_row_inner'] = array(
	'since' => '1.0',
	'vc_plugin' => array(
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



/**
 * Redefine the vc_column shortcode
 */
$definitions['vc_column'] = array(
	'since' => '1.0',
	'vc_plugin' => array(
		'name'            => esc_html__( 'Column', 'webman-amplifier' ),
		'base'            => 'vc_column',
		'class'           => 'wm-shortcode-vc-column',
		'category'        => esc_html__( 'Structure', 'webman-amplifier' ),
		'content_element' => false,
		'is_container'    => true,
		'js_view'         => 'VcColumnView',
		'params'          => array(
			10 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'id',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
				'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'bg_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			40 => array(
				'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'font_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			50 => array(
				'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'bg_image',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'padding',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
		),
	),
);



/**
 * Redefine the vc_column_inner shortcode
 */
$definitions['vc_column_inner'] = array(
	'since' => '1.0.9',
	'vc_plugin' => array(
		'name'            => esc_html__( 'Column', 'webman-amplifier' ),
		'base'            => 'vc_column_inner',
		'class'           => 'wm-shortcode-vc-inner-column',
		'category'        => esc_html__( 'Structure', 'webman-amplifier' ),
		'content_element' => false,
		'is_container'    => true,
		'js_view'         => 'VcColumnView',
		'params'          => array(
			10 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Optional HTML ID', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'id',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),

			30 => array(
				'heading'     => esc_html__( 'Background color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'bg_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			40 => array(
				'heading'     => esc_html__( 'Text color', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'colorpicker',
				'param_name'  => 'font_color',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			50 => array(
				'heading'     => esc_html__( 'Background image', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'bg_image',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Padding', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_padding.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'padding',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
		),
	),
);



/**
 * Text block
 */
$definitions['text_block'] = array(
	'since' => '1.0',
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Text Block', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'text_block',
		'class'    => 'wm-shortcode-vc-text_block',
		'icon'     => 'icon-wpb-layer-shape-text',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Content', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '',
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



/**
 * Image
 */
$definitions['image'] = array(
	'since' => '1.0',
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Image', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'image',
		'class'    => 'wm-shortcode-vc-image',
		'icon'     => 'icon-wpb-single-image',
		'category' => esc_html__( 'Media', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Image to display', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'attach_image',
				'param_name'  => 'src',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
			20 => array(
				'heading'    => esc_html__( 'Image link URL', 'webman-amplifier' ),
				'type'       => 'textfield',
				'param_name' => 'link',
				'value'      => '',
				'holder'     => 'hidden',
				'class'      => '',
			),
			30 => array(
				'heading'     => esc_html__( 'Target', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'target',
				'value'       => array(
					esc_html__( 'Open in same window', 'webman-amplifier' )      => '',
					esc_html__( 'Open in new window / tab', 'webman-amplifier' ) => '_blank',
				),
				'holder'      => 'hidden',
				'class'       => '',
				'dependency'  => array(
					'element'   => 'link',
					'not_empty' => true
				),
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

			50 => array(
				'heading'     => esc_html__( 'Image width HTML attribute', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'width',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Image height HTML attribute', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textfield',
				'param_name'  => 'height',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
			70 => array(
				'heading'     => esc_html__( 'Margin', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Set a <a%s>CSS value</a>, such as <code>60px 0 60px 0</code>', 'webman-amplifier' ), ' href="http://www.w3schools.com/cssref/pr_margin.asp" target="_blank"'),
				'type'        => 'textfield',
				'param_name'  => 'margin',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Styling', 'webman-amplifier' ),
			),
		),
	),
);



/**
 * Soliloquy
 *
 * @todo  Remove?
 */
if ( post_type_exists( 'soliloquy' ) ) {

	$definitions['soliloquy'] = array(
		'since' => '1.0',
		'vc_plugin' => array(
			'name'     => esc_html__( 'Soliloquy Slider', 'webman-amplifier' ),
			'base'     => 'soliloquy',
			'class'    => 'wm-shortcode-vc-soliloquy',
			'icon'     => 'icon-wpb-images-carousel',
			'category' => esc_html__( 'Media', 'webman-amplifier' ),
			'params'   => array(
				10 => array(
					'heading'     => esc_html__( 'Choose a Soliloquy slider', 'webman-amplifier' ),
					'description' => '',
					'type'        => 'dropdown',
					'param_name'  => 'id',
					'value'       => array_flip( wma_posts_array( 'post_name', 'soliloquy' ) ), // 1st value is empty
					'holder'      => 'hidden',
					'class'       => '',
				),
			),
		),
	);

}



/**
 * Master Slider
 *
 * @todo  Remove?
 */
if ( function_exists( 'get_masterslider_names' ) ) {

	$definitions['masterslider'] = array(
		'since' => '1.0.9',
		'vc_plugin' => array(
			'name'     => esc_html__( 'Master Slider', 'webman-amplifier' ),
			'base'     => 'masterslider',
			'class'    => 'wm-shortcode-vc-masterslider',
			'icon'     => 'icon-wpb-images-carousel',
			'category' => esc_html__( 'Media', 'webman-amplifier' ),
			'params'   => array(
				10 => array(
					'heading'     => esc_html__( 'Choose a slider', 'webman-amplifier' ),
					'description' => '',
					'type'        => 'dropdown',
					'param_name'  => 'id',
					'value'       => array( '' => '' ) + get_masterslider_names( false ),
					'holder'      => 'hidden',
					'class'       => '',
				),
			),
		),
	);

}



/**
 * Aliases: Render certain VC shortcodes even when the plugin is disabled
 */
if ( ! wma_is_active_vc() ) {

	/**
	 * vc_row
	 */
	$definitions['vc_row'] = array(
		'since'         => '1.0',
		'custom_prefix' => '',
		'renderer'      => array(
			'alias' => 'row',
		),
	);

		/**
		 * vc_row_inner
		 */
		$definitions['vc_row_inner'] = array(
			'since'         => '1.0',
			'custom_prefix' => '',
			'renderer'      => array(
				'alias' => 'row',
			),
		);



	/**
	 * vc_column
	 */
	$definitions['vc_column'] = array(
		'since'         => '1.0',
		'custom_prefix' => '',
		'renderer'      => array(
			'alias' => 'column',
		),
	);

		/**
		 * vc_column_inner
		 */
		$definitions['vc_column_inner'] = array(
			'since'         => '1.0',
			'custom_prefix' => '',
			'renderer'      => array(
				'alias' => 'column',
			),
		);

} // /! wma_is_active_vc()
