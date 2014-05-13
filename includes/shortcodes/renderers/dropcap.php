<?php
/**
 * Dropcap
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @uses   $codes_globals['colors'], $codes_globals['dropcap_shapes']
 *
 * @param  string class
 * @param  string color
 * @param  string shape
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class' => '',
			'color' => '',
			'shape' => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//class
		$atts['class'] = trim( 'wm-dropcap ' . trim( $atts['class'] ) );
	//color
		$atts['color'] = trim( $atts['color'] );
		if ( in_array( $atts['color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['class'] .= ' color-' . $atts['color'];
		}
	//shape
		$atts['shape'] = trim( $atts['shape'] );
		if ( in_array( $atts['shape'], array_keys( $codes_globals['dropcap_shapes'] ) ) ) {
			$atts['class'] .= ' shape-' . $atts['shape'];
		}
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );

//Output
	$output = '<span class="' . $atts['class'] . '">' . $atts['content'] . '</span>';

?>