<?php
/**
 * Widget area
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string area
 * @param  string class
 * @param  integer max_widgets_count
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'area'              => '',
			'class'             => '',
			'max_widgets_count' => 0,
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//area
		$atts['area'] = trim( $atts['area'] );
	//max_widgets_count
		$atts['max_widgets_count'] = absint( $atts['max_widgets_count'] );
	//class
		$atts['class'] = esc_attr( trim( 'clearfix ' . $atts['class'] ) );
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', $atts['class'] );

//Output
	if ( function_exists( 'wma_sidebar' ) ) {
		$output = wma_sidebar( array(
				'class'             => $atts['class'],
				'max_widgets_count' => $atts['max_widgets_count'],
				'sidebar'           => $atts['area'],
			) );
	}

?>