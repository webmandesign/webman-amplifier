<?php
/**
 * Shortcode definitions array partial: [pricing_table]
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
$definitions['pricing_table'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Pricing Table', 'webman-amplifier' ),
		'code'  => '[PREFIX_pricing_table no_margin="0/1" class=""]<br />[PREFIX_price caption="' . esc_html__( 'Price 1', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]{{content}}[/PREFIX_price]<br />[PREFIX_price caption="' . esc_html__( 'Price 2', 'webman-amplifier' ) . '" color="" color_text="" cost="" heading_tag="" appearance="NONE/featured/legend" class=""]' . esc_html__( 'Price 2 content goes here', 'webman-amplifier' ) . '[/PREFIX_price]<br />[/PREFIX_pricing_table]',
		'short' => false,
	),
);
