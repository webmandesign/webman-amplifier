<?php
/**
 * Shortcode definitions array partial: [widget_area]
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
$definitions['widget_area'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Widgets Area', 'webman-amplifier' ),
		'code'  => '[PREFIX_widget_area area="' . implode( '/', array_keys( wma_ksort( wma_widget_areas_array() ) ) ) . '" class="" max_widgets_count="0" /]',
		'short' => true,
	),
);
