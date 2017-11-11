<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [call_to_action]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['call_to_action'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Call to Action', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_call_to_action'
				. ' button_color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
				. ' button_icon=""'
				. ' button_size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '"'
				. ' button_text=""'
				. ' button_url="#"'
				. ' caption=""'
				. ' class=""'
			. ']'
				. '{{content}}'
			. '[/PREFIX_call_to_action]',
		'short' => false,
	),
);
