<?php
/**
 * Shortcode definitions array partial: [item]
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
$definitions['item'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Item (Accordion or Tab Section)', 'webman-amplifier' ),
		'code'  => '[PREFIX_item title="' . esc_html__( 'Title', 'webman-amplifier' ) . '" tags="" icon="" heading_tag=""]{{content}}[/PREFIX_item]',
		'short' => false,
	),
);
