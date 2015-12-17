<?php
/**
 * Progress bar
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.2.9.1
 *
 * @uses  $codes_globals['colors']
 *
 * @param  string class
 * @param  string color
 * @param  integer progress
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class'    => '',
			'color'    => '',
			'progress' => 66,
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class']         = trim( 'wm-progress ' . trim( $atts['class'] ) );
		$atts['class_caption'] = trim( 'wm-progress-caption' );
		$atts['class_bar']     = trim( 'wm-progress-bar' );
	//color
		$atts['color'] = trim( $atts['color'] );
		if ( $atts['color'] && in_array( $atts['color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['class']     .= ' container-color-' . $atts['color'];
			$atts['class_bar'] .= ' color-' . $atts['color'];
		}
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
		$atts['content'] = '<div class="' . esc_attr( $atts['class_caption'] ) . '">' . $atts['content'] . '</div>';
	//progress
		$atts['progress'] = absint( $atts['progress'] );
		if ( 100 < $atts['progress'] ) {
			$atts['progress'] = 66;
		}
	//class
		$atts['class']     = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );
		$atts['class_bar'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_bar_classes', $atts['class_bar'], $atts );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '" title="' . esc_attr( $atts['progress'] ) . '%" data-progress="' . esc_attr( $atts['progress'] ) . '">' . $atts['content'] . '<div class="' . esc_attr( $atts['class_bar'] ) . '" style="width:' . esc_attr( $atts['progress'] ) . '%;"></div></div>';

?>