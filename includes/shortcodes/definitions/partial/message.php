<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [message]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['message'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name' => esc_html__( 'Message', 'webman-amplifier' ),
		'code' =>
			'[PREFIX_message'
				. ' class=""'
				. ' color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
				. ' icon=""'
				. ' size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '"'
				. ' title=""'
			. ']'
				. '{{content}}'
			. '[/PREFIX_message]',
	),
);
