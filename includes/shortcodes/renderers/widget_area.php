<?php
/**
 * Widget area
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  string area
 * @param  string class
 * @param  integer max_widgets_count
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'area'              => '',
			'class'             => '',
			'max_widgets_count' => 0,
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'clearfix ' . $atts['class'] );
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Output
	if ( function_exists( 'wma_sidebar' ) ) {
		$output = wma_sidebar( array(
				'class'             => esc_attr( $atts['class'] ),
				'max_widgets_count' => absint( $atts['max_widgets_count'] ),
				'sidebar'           => trim( $atts['area'] ),
			) );
	}

?>