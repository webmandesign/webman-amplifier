<?php
/**
 * Marker
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  string class
 * @param  string color
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Variables come from WM_Shortcodes::shortcode_render(), they are not global.
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Shortcode attributes

	$defaults = apply_filters(
		'wmhook_shortcode__defaults',
		array(
			'class' => '',
			'color' => '',
		),
		$shortcode
	);

	$atts = apply_filters( 'wmhook_shortcode__attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

// Validation

	// content
	$atts['content'] = apply_filters( 'wmhook_shortcode__content', $content, $shortcode, $atts );
	$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );

	// class
	$atts['class'] = trim( 'wm-marker ' . trim( $atts['class'] ) );

	// color
	$atts['color'] = trim( $atts['color'] );
	if ( $atts['color'] ) {
		$atts['class'] .= ' color-' . $atts['color'];
	}

	// class
	$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

// Output

	$output = '<mark class="' . esc_attr( $atts['class'] ) . '">' . $atts['content'] . '</mark>';

// phpcs:enable
