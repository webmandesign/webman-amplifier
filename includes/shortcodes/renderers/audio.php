<?php
/**
 * Audio
 *
 * Compatible with WordPress 3.6+
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  string class
 * @param  string src
 * @param  string ... For attributes please see @link http://codex.wordpress.org/Video_Shortcode.
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
			'src'   => '',
		),
		$shortcode
	);

	$atts = apply_filters( 'wmhook_shortcode__attributes', $atts, $shortcode );
	// get the custom attributes in $atts['attributes']
	// parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'src' ), array( 'class' ), $prefix_shortcode . $shortcode );

// Validation

	// content
	$atts['content'] = '';

	// src

		$atts['src'] = trim( $atts['src'] );

		if ( $atts['src'] ) {
			if ( stripos( $atts['src'], 'soundcloud' )) {
				$atts['content'] = wp_oembed_get( esc_url( $atts['src'] ) );
			} else {
				$atts['content'] = do_shortcode( '[audio src="' . $atts['src'] . '"' . $atts['attributes'] . ' /]' );
			}
		}

	// class
	$atts['class'] = trim( 'wm-audio ' . trim( $atts['class'] ) );
	$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

	// content filters
	$atts['content'] = apply_filters( 'wmhook_shortcode__content', $atts['content'], $shortcode, $atts );
	$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );

// Output

	$output = do_shortcode( '<div class="' . esc_attr( $atts['class'] ) . '"><div class="media-container">' . $atts['content'] . '</div></div>' );

// phpcs:enable
