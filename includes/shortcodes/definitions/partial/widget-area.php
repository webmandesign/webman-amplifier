<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [widget_area]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['widget_area'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Widgets Area', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_widget_area'
				. ' area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '"'
				. ' class=""'
				. ' max_widgets_count="0"'
			. ' /]',
		'short' => true,
	),
);
