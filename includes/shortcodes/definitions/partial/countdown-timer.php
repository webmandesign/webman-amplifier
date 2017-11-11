<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [countdown_timer]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['countdown_timer'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Countdown Timer', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_countdown_timer'
				. ' class=""'
				. ' size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '"'
				. ' time="' . date( get_option( 'date_format' ), strtotime( 'now' ) ) . '"'
			. ' /]',
		'short' => false,
	),
);
