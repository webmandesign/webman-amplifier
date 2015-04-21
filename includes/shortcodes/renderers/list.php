<?php
/**
 * Icon List
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  string bullet
 * @param  string class
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'bullet' => '',
			'class'  => '',
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', ' ' . trim( $atts['class'] ), $atts );
	//content
		$atts['content'] = $content;
		$atts['content'] = str_replace( '<ul>', '<ul class="wm-icon-list ' . esc_attr( trim( $atts['class'] ) ) . '">', $atts['content'] );
	//bullet
		$atts['bullet'] = trim( $atts['bullet'] );
		if ( $atts['bullet'] ) {
			$atts['bullet']  = '<li class="' . esc_attr( $atts['bullet'] ) . '">';
			$atts['content'] = str_replace( '<li>', $atts['bullet'], $atts['content'] );
		}
	//content filters
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $atts['content'], $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );

//Output
	$output = $atts['content'];

?>