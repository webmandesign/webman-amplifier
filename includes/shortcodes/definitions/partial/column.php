<?php
/**
 * Shortcode definitions array partial: [column]
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
$definitions['column'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Column', 'webman-amplifier' ),
		'code'  => '[PREFIX_column width="' . implode( ',', $helpers['column_widths'] ) . '" last="0/1" bg_attachment="" bg_color="" bg_image="" bg_position="" bg_repeat="" bg_size="" class="" font_color="" id="" padding=""]{{content}}[/PREFIX_column]',
		'short' => false,
	),
);
