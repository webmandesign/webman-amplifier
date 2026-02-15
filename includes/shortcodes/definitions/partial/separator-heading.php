<?php
/**
 * Shortcode definitions array partial: [separator_heading]
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
$definitions['separator_heading'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Separator Heading', 'webman-amplifier' ),
		'code'  => '[PREFIX_separator_heading align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '" tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '" class="" id=""]{{content}}[/PREFIX_separator_heading]',
		'short' => true,
	),
);
