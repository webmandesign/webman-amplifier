<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [row]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





/**
 * @todo  Page builder plugin!
 */
$js_composer_is_active = ( is_callable( 'WM_Amplifier_JS_Composer::is_active' ) ) ? ( WM_Amplifier_JS_Composer::is_active() ) : ( false );

$definitions['row'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Row', 'webman-amplifier' ),
		'code'  => ( $js_composer_is_active ) ? ( '[vc_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/vc_row]' ) : ( '[PREFIX_row bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" margin="" padding="" parallax=""]{{content}}[/PREFIX_row]' ),
		'short' => false,
	),
);
