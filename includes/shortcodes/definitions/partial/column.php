<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [column]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['column'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Column', 'webman-amplifier' ),
		'code'  => ( wma_is_active_vc() ) ? ( '[vc_column width="1/1,1/2,1/3,2/3,1/4,3/4,1/6,5/6" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/vc_column]' ) : ( '[PREFIX_column width="' . implode( ',', $helpers['column_widths'] ) . '" last="0/1" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/PREFIX_column]' ),
		'short' => false,
	),
);
