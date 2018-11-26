<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [row]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['row'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Row', 'webman-amplifier' ),
		'code'  => ( wma_is_active_vc() ) ? ( '[vc_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/vc_row]' ) : ( '[PREFIX_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/PREFIX_row]' ),
		'short' => false,
	),
);
