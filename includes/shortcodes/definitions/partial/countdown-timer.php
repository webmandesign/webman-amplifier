<?php
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

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['countdown_timer'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Countdown Timer', 'webman-amplifier' ),
		'code'  => '[PREFIX_countdown_timer time="' . gmdate( get_option( 'date_format' ), strtotime( 'now' ) ) . '" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" class="" /]',
		'short' => false,
	),
);
