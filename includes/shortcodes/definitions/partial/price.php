<?php
/**
 * Shortcode definitions array partial: [price]
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
$definitions['price'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Price', 'webman-amplifier' ),
		'code'  => '[PREFIX_price caption="' . esc_html__( 'Title', 'webman-amplifier' ) . '" cost="99$" color="" color_text="" appearance="default/featured/legend" class=""]{{content}}[/PREFIX_price]',
		'short' => false,
	),
);
