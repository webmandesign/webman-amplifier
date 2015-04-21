<?php
/**
 * Text Block
 *
 * Visual Composer plugin helper shortcode.
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  string class
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class' => '',
			'id'    => ''
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
	//id
		$atts['id'] = trim( $atts['id'] );
		if ( $atts['id'] ) {
			$atts['id'] = ' id="' . esc_attr( $atts['id'] ) . '"';
		}
	//class
		$atts['class'] = trim( apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', 'wm-text-block ' . trim( $atts['class'] ), $atts ) );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '"' . $atts['id'] . '>' . $atts['content'] . '</div>';

?>