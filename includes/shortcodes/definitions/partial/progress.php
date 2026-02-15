<?php
/**
 * Shortcode definitions array partial: [progress]
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
$definitions['progress'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Progress Bar', 'webman-amplifier' ),
		'code'  => '[PREFIX_progress color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" progress="75" class=""]{{content}}[/PREFIX_progress]',
		'short' => false,
	),
);
