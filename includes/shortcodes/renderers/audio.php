<?php
/**
 * Audio
 *
 * Compatible with WordPress 3.6+
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string class
 * @param  string src
 * @param  string ... For attributes please see @link http://codex.wordpress.org/Video_Shortcode.
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class' => '',
			'src'   => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'src' ), array( 'class' ), $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = '';
	//src
		$atts['src'] = trim( $atts['src'] );
		if ( $atts['src'] ) {
			if ( stripos( $atts['src'], 'soundcloud' )) {
				$atts['content'] = wp_oembed_get( esc_url( $atts['src'] ) );
			} else {
				$atts['content'] = do_shortcode( '[audio src="' . $atts['src'] . '"' . $atts['attributes'] . ' /]' );
			}
		}
	//class
		$atts['class'] = trim( 'wm-audio ' . trim( $atts['class'] ) );
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );
	//content filters
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $atts['content'], $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );

//Output
	$output = do_shortcode( '<div class="' . $atts['class'] . '"><div class="media-container">' . $atts['content'] . '</div></div>' );

?>