<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [button]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['button'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Button', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_button'
				. ' class=""'
				. ' color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
				. ' icon=""'
				. ' size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '"'
				. ' url="#"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_button]',
		'short' => true,
	),
	'preprocess' => true,
);
